angular.module "crm"
  .controller "BaseCtrl", ($scope,
                           AuthService,
                           $location,
                           SessionService,
                           $modal,
                           ConnectService,
                           UserService,
                           WebService,
                           GlobalService,
                           EVENT_CONFIG_LOADED_SUCCESS,
                           EVENT_SIGN_IN_SUCCESS,
                           EVENT_PREDATA_LOADED_SUCCESS,
                           API_BASE_URL
                            ) ->
    $scope.currentUser = null
    $scope.isAuthorized = AuthService.isAuthenticated()
    $scope.absUrl = $location.absUrl()

    WebService.loadWebConfig()
      .then (res)->
        $scope.domainExist = true
        config = res.data
        GlobalService.setConfig config
        WebService.isLoadConfig = true
        $scope.$broadcast EVENT_CONFIG_LOADED_SUCCESS, config
        if $scope.isAuthorized
          AuthService.loginByAccessToken SessionService.accessToken
          .then (res)->
            $scope.afterSignIn res.data
          ,
          ()->
            SessionService.destroy()
            $scope.isAuthorized = false
            #重定向到sign-in
        else
          $location.path('/')

      , ()->
        $scope.domainExist = false
        $scope.subDomain = WebService.preDomain
        $scope.API_BASE_URL = API_BASE_URL
        $location.path('/')


    $scope.setCurrentUser = (user) ->
      $scope.currentUser = user
      AuthService.currentUser = user
      $scope.isAuthorized = AuthService.isAuthenticated()



    regiesterOnMessage = ()->
      ConnectService.websocket.onmessage = (messageEvent)->
        data = $.parseJSON messageEvent.data
        if data.type == ConnectService.MESSAGE_TYPE
          message = UserService.createMessage data.message
          $scope.$broadcast('new-message', message)
          WebService.checkIfSendNotification(message)
        else if data.type == ConnectService.BROADCAST_TYPE

        else if data.type == ConnectService.IQ_TYPE

        else if data.type == ConnectService.AUTH_TYPE
          ConnectService.sendAuth SessionService.accessToken
        else
          throw new Error(messageEvent)

    $scope.afterSignIn = (resData)->
      currentUser = UserService.createUser resData
      $scope.setCurrentUser currentUser
      $scope.$broadcast EVENT_SIGN_IN_SUCCESS, currentUser
      ConnectService.init()
      regiesterOnMessage()
      WebService.loadData()
        .then ()->
          WebService.isLoadedPreData = true
          $scope.$broadcast EVENT_PREDATA_LOADED_SUCCESS, currentUser

