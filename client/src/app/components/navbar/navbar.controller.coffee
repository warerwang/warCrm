angular.module "crm"
  .controller "NavbarCtrl", ($scope, GlobalService, EVENT_CONFIG_LOADED_SUCCESS, $modal, SessionService, AuthService) ->
    $scope.webName = 'WarCrm'
    afterLoadConfig = ()->
      $scope.webName = GlobalService.config.name

    if GlobalService.config
      afterLoadConfig()
    $scope.$on EVENT_CONFIG_LOADED_SUCCESS, ()->
      afterLoadConfig()


    $scope.showSignModal = ()->
      modalInstance = $modal.open {
        templateUrl: 'sign-in-modal.html',
        controller: 'SigninmodalCtrl'
      }
      modalInstance.result.then (resData)->
        $scope.afterSignIn resData
      false

    $scope.signOut = ()->
      SessionService.destroy()
      AuthService.currentUser = null
      $scope.isAuthorized = AuthService.isAuthenticated()