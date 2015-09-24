WARPHP_starter.controller "BaseCtrl", ($scope,
                         AuthService,
                         $location,
                         SessionService,
                         ConnectService,
                         UserService,
                         WebService,
                         GlobalService,
                         EVENT_CONFIG_LOADED_SUCCESS,
                         EVENT_SIGN_IN_SUCCESS,
                         EVENT_PREDATA_LOADED_SUCCESS,
                         API_BASE_URL,
                         UserResource
                           ) ->
  $scope.currentUser = null
  $scope.absUrl = $location.absUrl()
  $scope.tab = 'default'
  $scope.setTab = (tab)->
    $scope.tab = tab
  if AuthService.isAuthenticated()
    UserResource.getCurrent {}, (userResource)->
      console.log userResource
      $scope.afterSignIn userResource
    ,
    ()->
      SessionService.destroy()
  else
    $location.path('/auth')


#  WebService.loadWebConfig().then (res)->
#    $scope.domainExist = true
#    config = res.data
#    GlobalService.setConfig config
#    WebService.isLoadConfig = true
#    $scope.$broadcast EVENT_CONFIG_LOADED_SUCCESS, config
#
#  ,
#  ()->
#    $scope.domainExist = false
#    $scope.subDomain = WebService.preDomain
#    $scope.API_BASE_URL = API_BASE_URL
#    $location.path('/')


  $scope.setCurrentUser = (user) ->
    $scope.currentUser = user
    AuthService.currentUser = user

  $scope.getIsAuthorized = ()->
    AuthService.isAuthenticated()

  if $scope.getIsAuthorized()
    UserResource.getCurrent {}, (userResource)->
      $scope.afterSignIn userResource
    ,
      ()->
        SessionService.destroy()

  handleNewMessage = (message)->
    cid = message.getChatId()
    UserService.newMessageChat cid, message.isGroupMessage()
    $scope.$apply()
    $scope.$broadcast('new-message', message)
    WebService.checkIfSendNotification(message)

  regiesterOnMessage = ()->
    ConnectService.websocket.onmessage = (messageEvent)->
      data = $.parseJSON messageEvent.data
      if data.type == ConnectService.MESSAGE_TYPE
        message = UserService.createMessage data.message
        handleNewMessage(message)

      else if data.type == ConnectService.BROADCAST_TYPE
        #处理广播的消息
        broadcast = 'server-' + data.message
        $scope.$broadcast(broadcast, data.data)
        if !WebService.isLoadedPreData
          return false
        if data.message.indexOf('user-') == 0
          uid = data.data['id']
          user = UserService.getUser uid
          if user?
            if data.message == 'user-remove'
              UserService.removeUser uid
              return false
            $.extend(user.resource, data.data)
            if uid == $scope.currentUser.id
              $scope.setCurrentUser user
          else
            UserService.addNewUser data.data

        $scope.$apply()

      else if data.type == ConnectService.IQ_TYPE

      else if data.type == ConnectService.AUTH_TYPE
        ConnectService.sendAuth SessionService.accessToken
      else if data.type != ConnectService.PING_TYPE
        throw new Error(messageEvent.data)

  $scope.afterSignIn = (resData)->
    currentUser = UserService.createUser resData
    $scope.setCurrentUser currentUser
    $scope.$broadcast EVENT_SIGN_IN_SUCCESS, currentUser
    GlobalService.setConfig {id:resData.did}
    WebService.loadData()
      .then ()->
        ConnectService.init()
        regiesterOnMessage()
        WebService.isLoadedPreData = true
        $scope.$broadcast EVENT_PREDATA_LOADED_SUCCESS, currentUser

  $scope.signOut = ()->
    SessionService.destroy()
    AuthService.currentUser = null
    $location.path('/')
    WebService.resetSystem()