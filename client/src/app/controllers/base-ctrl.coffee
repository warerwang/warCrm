angular.module "crm"
  .controller "BaseCtrl", ($scope, AuthService, $location, SessionService, $modal) ->
    $scope.currentUser = null

    $scope.isAuthorized = AuthService.isAuthenticated()

    $scope.absUrl = $location.absUrl()

    $scope.setCurrentUser = (user) ->
      $scope.currentUser = user
      $scope.isAuthorized = AuthService.isAuthenticated()

    $scope.signOut = ()->
      SessionService.destroy()
      $scope.isAuthorized = AuthService.isAuthenticated()


    $scope.showSignModal = ()->
#      $('#sign-in-modal').modal('show')
      $modal.open {
        animation: $scope.animationsEnabled,
        templateUrl: 'sign-in-modal.html',
        controller: 'SigninmodalCtrl'
      }
      false

    $scope.showSignUpModal = ()->
      $('#sign-up-modal').modal('show')
      false