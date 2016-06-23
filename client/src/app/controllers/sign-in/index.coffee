angular.module "crm"
  .controller 'SigninmodalCtrl', ($scope, $http, AuthService, $uibModalInstance, UserResource) ->
    $scope.submit = ()->
      AuthService.login $scope.email, $scope.password
      .then (res)->
        AuthService.saveAccessToken(res.data.accessToken)
        UserResource.getCurrent {}, (userResource)->
          $uibModalInstance.close(userResource)
      ,
      (res)->
        $scope.userForm.password.$invalid = true
        $scope.userForm.password.$dirty = true
        $scope.userForm.password.error = res.data.message

    $scope.close = ()->
      $uibModalInstance.dismiss('cancel')
