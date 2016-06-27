angular.module "crm"
  .controller 'SigninmodalCtrl', ($scope, $http, AuthService, $uibModalInstance, UserResource, GlobalService) ->
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

    $scope.inputUser = (user)->
      $scope.email = user + '@' + GlobalService.preDomain + '.com'
      $scope.password = '111111'