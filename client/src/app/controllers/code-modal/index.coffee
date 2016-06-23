angular.module "crm"
.controller 'CodeModalCtrl', ($scope, $http, AuthService, $uibModalInstance, chat) ->
  $scope.languages = [
    'java'
    'javascript'
    'php'
    'css'
    'html'
    'xml'
    'python'
    'ruby'
    'perl'
    'c++'
    'c#'
    'sql'
    'makefile'
  ]
  $scope.language = 'javascript'
  $scope.sendMessage = ()->
    chat.sendMessage($scope.message, {
      type:'code',
      data:{
        language    : $scope.language
      }
    })
    $uibModalInstance.close()
  $scope.close = ()->
    $uibModalInstance.dismiss('cancel')
