angular.module 'crm'
  .factory 'UserService', (UserResource, AuthService, $q, MessageResource, ConnectService, WebService)->
    userService = {}
    class User
      constructor: (options)->
        {@id} = options
        @resource = options
      getLoginStatus: ()->
        status = switch @resource.loginStatus
          when 1 then 'online'
          when 2 then 'offline'
          when 3 then 'busy'
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
        if AuthService.currentUser.id > options.id
          @id = options.id + '-' + AuthService.currentUser.id
        else
          @id = AuthService.currentUser.id  + '-' +  options.id
        @user = options
        @messages = null

      getName : ()->
        @user.getName()
      getLoginStatus : ()->
        @user.getLoginStatus()

      getHistoryMessage: ()->
        _this = this
        deferred = $q.defer()
        promise = deferred.promise
        promise.then (data)->
          data
        if this.messages?
          deferred.resolve(this.messages)
        else
          MessageResource.get {cid:this.id}, (messages)->
            _this.messages = (new Message message for message in messages)
            deferred.resolve(_this.messages)
        promise
      sendMessage: (content, data)->
        ConnectService.sendMessage(this.id, content, data)
      getAvatar: (size)->
        @user.getAvatar(size)

    class Message
      constructor: (options)->
        {@id, @cid, @sender, @content, @createTime, @extraData} = options
      getSender: ()->
        userService.getUser @sender

    userService.getUsers = ()->
      if !userService.users?
        userService.users = (new User num for num in WebService.preData.users)
      userService.users

    userService.getRecentChat = ()->
      if !userService.chats?
        userService.chats = (new Chat user for user in userService.users when user.id != AuthService.currentUser.id)
      userService.chats

    userService.setUsers = (users)->
      userService.users = users


    userService.createUser = (options)->
      new User options

    userService.addNewUser = (userData)->
      WebService.preData.users.push userData
      newUser = userService.createUser userData
      userService.users.push newUser
      newUser

    userService.createMessage = (options)->
      new Message options

    userService.getChat = (cid)->
      (chat for chat in userService.getRecentChat() when chat.id == cid)[0]

    userService.getUser = (uid)->
      return user for user in userService.getUsers() when user.id == uid

    userService