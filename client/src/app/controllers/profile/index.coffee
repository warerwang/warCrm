angular.module 'crm'
  .controller "ProfileCtrl", ($scope, UserService, $stateParams, AuthService, EVENT_PREDATA_LOADED_SUCCESS, WebService, toastr) ->

    afterLoadPreData = ()->
      $scope.user    = UserService.getUser AuthService.currentUser.id
      $scope.userRes = $scope.user.resource
      $scope.myImage = $scope.currentUser.getAvatar(150)

    if WebService.isLoadedPreData
      afterLoadPreData()
    $scope.$on EVENT_PREDATA_LOADED_SUCCESS, ()->
      afterLoadPreData()

    $scope.save = ()->
      $scope.userRes.$update (user)->
        $scope.user = UserService.createUser user
        $scope.setCurrentUser $scope.user
        toastr.success('更新成功')


    $scope.updateUser = {}
  .controller "ProfilePasswordCtrl", ($scope, $http, API_BASE_URL, SessionService, toastr)->
    $scope.updatePassword = ()->
      $http.post(API_BASE_URL + '/user/update-password?access-token=' + SessionService.accessToken, {oldPassword:$scope.updateUser.oldPassword, newPassword:$scope.updateUser.password1})
      .then ()->
          toastr.success('更新密码成功')
      ,(res)->
        $scope.passwordForm.oldPassword.error = res.data.message
        $scope.passwordForm.oldPassword.$invalid = true
        $scope.passwordForm.oldPassword.$dirty = true