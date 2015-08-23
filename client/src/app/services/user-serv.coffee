angular.module 'crm'
  .factory 'UserService', (UserResource, ChatResource, AuthService, $q, MessageResource, ConnectService, WebService, $location, GroupResource)->
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
          avatar = @resource.avatar + '&size='+size
        else
          avatar = @resource.avatar

        avatar
      isAdmin: ()->
        @resource.isAdmin


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

      isActive: ()->
        return $location.path() == '/chat/' + @id
      getSort: ()->
        if this.isActive()
          return '9' + @resource.lastActivity
        else
          return @resource.lastActivity
      getName : ()->
        if @_recipient?
          @_recipient.getName()
        else
          ''

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
          cid = @_recipient.id

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

      sendMessage: (content, data)->
        ConnectService.sendMessage(this.getCid(), content, data)

      getAvatar: (size)->
        @_recipient.getAvatar(size)

      getMembers: ()->
        if @resource.type == 1
          return [
            AuthService.currentUser
            @_recipient
          ]
        else
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

        #
        else


    class Message
      constructor: (options)->
        {@id, @cid, @sender, @content, @createTime, @extraData} = options
      getSender: ()->
        userService.getUser @sender
      getContent: ()->
        @content



    class Group
      constructor: (options)->
        @id = options.id
        @resource = options
      getName: ()->
        @resource.name
      getLoginStatus: ()->
        'fa fa-users'

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