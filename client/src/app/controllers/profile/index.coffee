angular.module 'crm'
  .controller "ProfileCtrl", ($scope, UserService, $stateParams, AuthService, EVENT_PREDATA_LOADED_SUCCESS, WebService, toastr) ->

    afterLoadPreData = ()->
      $scope.user    = UserService.getUser AuthService.currentUser.id
      $scope.userRes = $scope.user.resource

    if WebService.isLoadedPreData
      afterLoadPreData()
    $scope.$on EVENT_PREDATA_LOADED_SUCCESS, ()->
      afterLoadPreData()

    $scope.save = ()->
      $scope.userRes.$update (user)->
        $scope.user = UserService.createUser user
        $scope.setCurrentUser $scope.user
        toastr.success('更新成功')






