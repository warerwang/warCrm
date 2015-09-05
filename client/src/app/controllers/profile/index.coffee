angular.module 'crm'
  .controller "ProfileCtrl", ($scope,
                              UserService,
                              $stateParams,
                              AuthService,
                              EVENT_PREDATA_LOADED_SUCCESS,
                              WebService,
                              toastr,
                              ConnectService) ->

    afterLoadPreData = ()->
      $scope.user    = UserService.getUser AuthService.currentUser.id
      $scope.userRes = $scope.user.resource
      $scope.myImage = $scope.currentUser.getAvatar(150)

    if WebService.isLoadedPreData
      afterLoadPreData()
    $scope.$on EVENT_PREDATA_LOADED_SUCCESS, ()->
      afterLoadPreData()

    $scope.save = ()->
      $scope.userRes.$update (resource)->
        $scope.user.resource = resource
        ConnectService.sendBroadcast('user-edit', resource)
        $scope.setCurrentUser $scope.user
        toastr.success('更新成功')


    $scope.updateUser = {}
  .controller "ProfilePasswordCtrl", ($scope, $http, API_BASE_URL, SessionService, toastr, $location)->
    $scope.updatePassword = ()->
      $scope.userRes.$updatePassword {oldPassword:$scope.updateUser.oldPassword, newPassword:$scope.updateUser.password1}, (res)->
        $scope.updateUser = {}
        $scope.passwordForm.$setPristine()
        toastr.success('更新密码成功')
      ,(res)->
        $scope.passwordForm.oldPassword.error = res.data.message
        $scope.passwordForm.oldPassword.$invalid = true
        $scope.passwordForm.oldPassword.$dirty = true