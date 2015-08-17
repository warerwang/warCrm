angular.module "crm"
  .controller 'SigninmodalCtrl', ($scope, $http, AuthService, $modalInstance) ->
    $scope.submit = ()->
      AuthService.login $scope.email, $scope.password
      .then (res)->
        AuthService.saveAccessToken(res.data.accessToken)
        AuthService.loginByAccessToken(res.data.accessToken).then (res) ->
          $modalInstance.close(res.data)
      ,
      (res)->
        $scope.userForm.password.$invalid = true
        $scope.userForm.password.$dirty = true
        $scope.userForm.password.error = res.data.message

    $scope.close = ()->
      $modalInstance.dismiss('cancel')
