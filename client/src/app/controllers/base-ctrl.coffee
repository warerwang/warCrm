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
                           EVENT_PREDATA_LOADED_SUCCESS
                            ) ->
    $scope.currentUser = null
    $scope.isAuthorized = AuthService.isAuthenticated()

    WebService.loadWebConfig()
      .then (res)->
        config = res.data
        GlobalService.setConfig config
        WebService.isLoadConfig = true
        $scope.$broadcast EVENT_CONFIG_LOADED_SUCCESS, config
        if $scope.isAuthorized
          AuthService.loginByAccessToken SessionService.accessToken
          .then (res)->
            afterSignIn res.data
          ,
          ()->
            $scope.signOut()
            #重定向到sign-in


    $scope.absUrl = $location.absUrl()

    $scope.setCurrentUser = (user) ->
      $scope.currentUser = user
      AuthService.currentUser = user
      $scope.isAuthorized = AuthService.isAuthenticated()

    $scope.signOut = ()->
      SessionService.destroy()
      AuthService.currentUser = null
      $scope.isAuthorized = AuthService.isAuthenticated()


    $scope.showSignModal = ()->
      modalInstance = $modal.open {
        animation: $scope.animationsEnabled,
        templateUrl: 'sign-in-modal.html',
        controller: 'SigninmodalCtrl'
      }
      modalInstance.result.then (resData)->
        afterSignIn resData
      false

    $scope.showSignUpModal = ()->
      $('#sign-up-modal').modal('show')
      false

    regiesterOnMessage = ()->
      ConnectService.websocket.onmessage = (messageEvent)->
        data = $.parseJSON messageEvent.data
        if data.type == ConnectService.MESSAGE_TYPE
          $scope.$broadcast('new-message', UserService.createMessage data.message)
        else if data.type == ConnectService.BROADCAST_TYPE

        else if data.type == ConnectService.IQ_TYPE

        else if data.type == ConnectService.AUTH_TYPE
          ConnectService.sendAuth SessionService.accessToken
        else
          throw new Error(messageEvent)

    afterSignIn = (resData)->
      currentUser = UserService.createUser resData
      $scope.setCurrentUser currentUser
      $scope.$broadcast EVENT_SIGN_IN_SUCCESS, currentUser
      ConnectService.init()
      regiesterOnMessage()
      WebService.loadData()
        .then ()->
          WebService.isLoadedPreData = true
          $scope.$broadcast EVENT_PREDATA_LOADED_SUCCESS, currentUser