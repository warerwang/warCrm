angular.module "crm"
.controller 'CodeModalCtrl', ($scope, $http, AuthService, $modalInstance, chat) ->
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
      console.log $scope.language
      chat.sendMessage($scope.message, {
        type:'code',
        data:{
          language    : $scope.language
        }
      })
      $modalInstance.close()
    $scope.close = ()->
      $modalInstance.dismiss('cancel')
