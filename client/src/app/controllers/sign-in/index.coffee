angular.module "crm"
  .controller 'SigninmodalCtrl', ($scope, $http, AuthService, $modalInstance, UserResource) ->
    $scope.submit = ()->
      AuthService.login $scope.email, $scope.password
      .then (res)->
        AuthService.saveAccessToken(res.data.accessToken)
        UserResource.getCurrent {}, (userResource)->
          $modalInstance.close(userResource)
      ,
      (res)->
        $scope.userForm.password.$invalid = true
        $scope.userForm.password.$dirty = true
        $scope.userForm.password.error = res.data.message

    $scope.close = ()->
      $modalInstance.dismiss('cancel')
