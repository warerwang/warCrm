angular.module 'crm'
  .factory 'UserService', (UserResource, AuthService, $q, MessageResource, ConnectService)->
    userService = {}
#    currentUser = AuthService.currentUser
    class User
      constructor: (options)->
        {@id, @email, @firstName, @lastName, @nickName, @avatar, @description, @isAdmin, @createTime, @lastActivity, @status} = options
      getStatus: ()->
        status = switch this.status
          when 1 then 'online'
          when 2 then 'offline'
          when 3 then 'busy'
          else 'deleted'

    class Chat
      constructor: (options)->
        if AuthService.currentUser.id > options.id
          @id = options.id + '-' + AuthService.currentUser.id
        else
          @id = AuthService.currentUser.id  + '-' +  options.id
        @name = options.nickName
        @messages = null

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


    class Message
      constructor: (options)->
        {@id, @cid, @sender, @content, @createTime, @extraData} = options
      getSender: ()->
        userService.getUser this.sender



    userService.getUsers = ()->
      deferred = $q.defer()
      promise = deferred.promise
      promise.then (data)->
        data
      ,
      (data)->
        data

      if userService.users?
        deferred.resolve(userService.users)
      else
        UserResource.get {}, (user)->
          userService.users = (new User num for num in user)
          deferred.resolve(userService.users)
        ,
        (data)->
          deferred.reject(data)
      promise

    userService.getRecentChat = ()->
      deferred = $q.defer()
      promise = deferred.promise
      promise.then (data)->
        data

      if userService.chats?
        deferred.resolve(userService.chats)
      else
        userService.getUsers().then (users)->
          userService.chats = (new Chat user for user in users when user.id != AuthService.currentUser.id)
          deferred.resolve(userService.chats)

      promise


    userService.setUsers = (users)->
      userService.users = users


    userService.createUser = (options)->
      new User options

    userService.createMessage = (options)->
      new Message options

    userService.getChat = (cid)->
      (chat for chat in userService.chats when chat.id == cid)[0]

    userService.getUser = (uid)->
      (user for user in userService.users when user.id == uid)[0]

    userService