angular.module "crm"
  .controller "BaseCtrl", ($scope, AuthService, $location, SessionService, $modal, ConnectService, UserService) ->
    $scope.currentUser = null

    $scope.isAuthorized = AuthService.isAuthenticated()

    if $scope.isAuthorized
      AuthService.loginByAccessToken SessionService.accessToken
        .then (user)->
          $scope.setCurrentUser(user)

    $scope.absUrl = $location.absUrl()

    $scope.setCurrentUser = (user) ->
      $scope.currentUser = user
      $scope.isAuthorized = AuthService.isAuthenticated()

    $scope.signOut = ()->
      SessionService.destroy()
      $scope.isAuthorized = AuthService.isAuthenticated()


    $scope.showSignModal = ()->
      modalInstance = $modal.open {
        animation: $scope.animationsEnabled,
        templateUrl: 'sign-in-modal.html',
        controller: 'SigninmodalCtrl'
      }
      modalInstance.result.then (user)->
        $scope.setCurrentUser user
      false

    $scope.showSignUpModal = ()->
      $('#sign-up-modal').modal('show')
      false
    ConnectService.init();

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
