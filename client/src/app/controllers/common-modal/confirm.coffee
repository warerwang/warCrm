angular.module "crm"
  .controller 'ConfirmModalCtrl', ($scope, $http, AuthService, $uibModalInstance, content) ->
    $scope.content = content
    $scope.confirm = ()->
      $uibModalInstance.close()
    $scope.close = ()->
      $uibModalInstance.dismiss('cancel')
