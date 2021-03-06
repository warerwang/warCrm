angular.module "crm"
.controller "NavbarCtrl", ($scope,
                           GlobalService,
                           EVENT_CONFIG_LOADED_SUCCESS,
                           $uibModal,
                           SessionService,
                           AuthService,
                           NotificationService,
                           toastr,
                           $location,
                           WebService) ->
  $scope.webName = 'WarCrm'
  afterLoadConfig = ()->
    $scope.webName = GlobalService.config.name

  if GlobalService.config
    afterLoadConfig()
  $scope.$on EVENT_CONFIG_LOADED_SUCCESS, ()->
    afterLoadConfig()


  $scope.showSignModal = ()->
    modalInstance = $uibModal.open {
      templateUrl: 'sign-in-modal.html',
      controller: 'SigninmodalCtrl'
    }
    modalInstance.result.then (resData)->
      $scope.afterSignIn resData
    false

  $scope.signOut = ()->
    SessionService.destroy()
    AuthService.currentUser = null
    $location.path('/')
    WebService.resetSystem()


  $scope.showOpenNotification = ()->
    if NotificationService.checkSupport()
      return !NotificationService.isAllow()
    else
      return false

  $scope.openNotification = ()->
    if NotificationService.isDefault()
      NotificationService.requestPermission()
    else
      toastr.warning '你已经禁止通知了,请在浏览器设置里打开.'