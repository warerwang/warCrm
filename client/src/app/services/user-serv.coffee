angular.module 'crm'
.factory 'UserService', (UserResource,
                         ChatResource,
                         AuthService,
                         $q,
                         MessageResource,
                         ConnectService,
                         WebService,
                         $location,
                         GroupResource,
                         AttachResource)->
  userService = {}
  class User
    constructor: (options)->
      {@id} = options
      @resource = options
    getLoginStatus: ()->
      status = switch @resource.loginStatus
        when 1 then 'online'
        when 0 then 'offline'
        when 2 then 'busy'
        else 'deleted'
    getName: ()->
      if @resource.nickName
        @resource.nickName
      else if @resource.name
        @resource.name
      else
        @resource.email
    getAvatar: (size)->
      if size
        avatar = @resource.avatar[size]
      else
        avatar = @resource.avatar[36]
      avatar

    isAdmin: ()->
      @resource.isAdmin


  userService.maxChatSort = 0
  class Chat
    constructor: (options)->
      {@id} = options
      @resource = options
      if @resource.type == 1
        @_recipient = userService.getUser @id
      else
        _this = this
        userService.getGroupPromise(@id).then (group)->
          _this._recipient = group
      @messages = null
      @sort = 0

    isActive: ()->
      return $location.path() == '/chat/' + @id
    getSort: ()->
      if @sort > 0
        '9' + @sort
      else
        @resource.lastActivity
    getName : ()->
      if @_recipient?
        @_recipient.getName()
      else
        ''
    getUnReadCount: ()->
      @resource.unReadCount

    getLoginStatus : ()->
      if @resource.type == 1
        @_recipient.getLoginStatus()
      else
        'fa fa-users'

    getCid : ()->
      if @resource.type == 1
        if AuthService.currentUser.id > @id
          cid = @id + '-' + AuthService.currentUser.id
        else
          cid = AuthService.currentUser.id  + '-' +  @id
      else
        cid = @id

      cid

    getHistoryMessage: ()->
      _this = this
      deferred = $q.defer()
      promise = deferred.promise
      promise.then (data)->
        data
      if this.messages?
        deferred.resolve(this.messages)
      else
        MessageResource.get {cid:this.getCid()}, (messages)->
          _this.messages = (new Message message for message in messages)
          deferred.resolve(_this.messages)
      promise

    loadMoreMessage: ()->
      _this = this
      deferred = $q.defer()
      promise = deferred.promise
      promise.then (data)->
        data
      if this.messages.length == 0
        deferred.resolve(this.messages)
      else
        MessageResource.get {cid:this.getCid(), id:this.messages[0].id}, (messages)->
          messages = (new Message message for message in messages)
          _this.messages = messages.concat(_this.messages)
          deferred.resolve(_this.messages)
      promise

    getAttachments: ()->

      _this = this
      deferred = $q.defer()
      promise = deferred.promise
      promise.then (data)->
        data
      if this.attachs?
        deferred.resolve(this.attachs)
      else
        AttachResource.query {cid:this.getCid()}, (attachs)->
          _this.attachs = (new Attach attach for attach in attachs)
          deferred.resolve(_this.attachs)
      promise

    sendMessage: (content, data)->
      @sort = ++userService.maxChatSort
      ConnectService.sendMessage(this.getCid(), content, data)

    getAvatar: (size)->
      if @_recipient?
        @_recipient.getAvatar(size)

    getMembers: ()->
      if @resource.type == 1
        return [
          AuthService.currentUser
          @_recipient
        ]
      else
        if @_recipient?
          @_recipient.getMembers()
    addMembers: (users, callback)->
      #1对1聊天
      if @resource.type == 1
        #创建一个group
        group = new GroupResource()
        members = users
        members.push(AuthService.currentUser)
        members.push(@_recipient)
        group.name = (member.getName() for member in members).join(', ').substr(0,50)
        group.members = JSON.stringify (member.id for member in members)
        group.$save callback

      #群组聊天
      else
        @_recipient.members.push user for user in users
        @_recipient.resource.members = JSON.stringify (member.id for member in @_recipient.members)
        @_recipient.resource.$update {id:@_recipient.id}, callback

    isGroup: ()->
      return @resource.type == 2

  class Message
    constructor: (options)->
      {@id, @cid, @sender, @content, @createTime} = options
      @extraData = $.parseJSON options.extraData

    getSender: ()->
      userService.getUser @sender
    getContent: ()->
      @content
    getChatId: ()->
      if @isGroupMessage() #一对一聊天
        @cid
      else
        cids = @cid.split('-')
        return cid for cid in cids when cid != AuthService.currentUser.id
    isGroupMessage: ()->
      return @cid.indexOf('-') == -1
    isImg: ()->
      if @isAttach()
        return @extraData.data.ext.toLowerCase() in ['.jpg', '.png', '.gif', '.bmp']
      else
        false
    isAttach: ()->
      return @extraData.type == 'attach'
    isCode: ()->
      return @extraData.type == 'code'
    getCodeType: ()->
      return @extraData.data.language

  class Attach
    constructor: (options)->
      {@id, @name, @size, @ext, @ownerId, @chatId, @createTime, @isImg, @url} = options
      @owner = userService.getUser @ownerId

  class Group
    constructor: (options)->
      @id = options.id
      @resource = options
    getName: ()->
      @resource.name
    getLoginStatus: ()->
      'fa fa-users'
    getMembers: ()->
      if !@members?
        membersIds = $.parseJSON @resource.members
        @members = (user for user in userService.getUsers() when user.id in membersIds)
      @members
    getAvatar: ()->
      ''

  userService.getUsers = ()->
    if !userService.users?
      userService.users = (new User num for num in WebService.preData.users)
    userService.users

  userService.recentChatLoaded = false
  userService.chats = []
  userService.getChats = ()->
    deferred = $q.defer()
    promise = deferred.promise
    promise.then (data)->
      data
    if userService.recentChatLoaded
      deferred.resolve(userService.chats)
    else
      ChatResource.query {}, (chats)->
        userService.chats = (new Chat chat for chat in chats)
        userService.recentChatLoaded = true
        deferred.resolve(userService.chats)
    promise

  userService.setUsers = (users)->
    userService.users = users


  userService.createUser = (options)->
    new User options

  userService.createChat = (options)->
    new Chat options

  userService.createGroup = (resource)->
    new Group resource

  userService.addNewUser = (userData)->
    WebService.preData.users.push userData
    newUser = userService.createUser userData
    userService.users.push newUser
    newUser

  userService.createMessage = (options)->
    new Message options

  userService.getChat = (id)->
    return chat for chat in userService.chats when chat.id == id

  userService.openChat = (id, callback)->
    if id == AuthService.currentUser.id
      return false
    chat = userService.getChat id
    if chat
      callback(chat)
    else
      ChatResource.get {id:id, type:1}, (res)->
        chat = new Chat res
        userService.chats.push(chat)
        callback(chat)

  userService.openGroupChat = (id, callback)->
    chat = userService.getChat id
    if chat
      callback(chat)
    else
      ChatResource.get {id:id, type:2}, (res)->
        chat = new Chat res
        userService.chats.push(chat)
        callback(chat)

  userService.newMessageChat = (id, isGroup)->
    chat = userService.getChat id
    if chat?
      if !chat.isActive()
        chat.resource.unReadCount++
        chat.sort = ++userService.maxChatSort
    else
      type = if isGroup then 2 else 1
      ChatResource.get {id:id, type:type}, (res)->
        chat = new Chat res
        userService.chats.push(chat)

  userService.getUser = (uid)->
    return user for user in userService.getUsers() when user.id == uid


  userService.groups = []
  userService.getGroup = (id)->
    return group for group in userService.groups when group.id == id
  userService.getGroupPromise = (id)->
    deferred = $q.defer()
    promise = deferred.promise
    promise.then (data)->
      data
    group = userService.getGroup id
    if group?
      deferred.resolve(group)
    else
      GroupResource.get {id:id}, (groupRes)->
        group = new Group groupRes
        userService.groups.push(group)
        deferred.resolve(group)
    promise

  userService.groupLoaded = false
  userService.getGroups = ()->
    deferred = $q.defer()
    promise = deferred.promise
    promise.then (data)->
      data
    if userService.groupLoaded
      deferred.resolve(userService.groups)
    else
      ChatResource.query {}, (groups)->
        userService.groups = (new Group group for group in groups)
        userService.groupLoaded = true
        deferred.resolve(userService.groups)
    promise

  userService