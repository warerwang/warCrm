angular.module "crm"
  .controller 'ConfirmModalCtrl', ($scope, $http, AuthService, $modalInstance, content) ->
    $scope.content = content
    $scope.confirm = ()->
      $modalInstance.close()
    $scope.close = ()->
      $modalInstance.dismiss('cancel')
