angular.module 'crm'
  .controller "ProfileCtrl", ($scope, UserService, $stateParams, AuthService, EVENT_PREDATA_LOADED_SUCCESS, WebService, toastr, $http, API_BASE_URL, SessionService) ->

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


    $scope.updateUser = {}

    $scope.updatePassword = ()->
      $http.post(API_BASE_URL + '/user/update-password?access-token=' + SessionService.accessToken, {oldPassword:$scope.updateUser.oldPassword, newPassword:$scope.updateUser.password1}).then (res)->
        console.log res




