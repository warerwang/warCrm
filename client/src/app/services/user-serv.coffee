angular.module 'crm'
  .factory 'UserService', (UserResource, ChatResource, AuthService, $q, MessageResource, ConnectService, WebService)->
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
          @_recipient = userService.getGroup @id
        @messages = null

      getName : ()->
          @_recipient.getName()

      getLoginStatus : ()->
        @_recipient.getLoginStatus()

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

    class Message
      constructor: (options)->
        {@id, @cid, @sender, @content, @createTime, @extraData} = options
      getSender: ()->
        userService.getUser @sender
      getContent: ()->
        @content




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

#      if !userService.chats?
#        userService.chats = (new Chat user for user in userService.getUsers() when user.id != AuthService.currentUser.id)
#      userService.chats

    userService.setUsers = (users)->
      userService.users = users


    userService.createUser = (options)->
      new User options

    userService.createChat = (options)->
      new Chat options

    userService.addNewUser = (userData)->
      WebService.preData.users.push userData
      newUser = userService.createUser userData
      userService.users.push newUser
      newUser

    userService.createMessage = (options)->
      new Message options

    userService.getChat = (id)->
      (chat for chat in userService.chats when chat.id == id)[0]

    userService.getUser = (uid)->
      return user for user in userService.getUsers() when user.id == uid

    userService.getGroup = (gid)->
      null
    userService