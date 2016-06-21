angular.module('starter.modules.account.signin', [])

.config ($stateProvider, $urlRouterProvider)->
  $stateProvider.state('tab.signin', {
    url: '/auth',
    templateUrl: 'coffeeScript/modules/account/signin/index.html',
    controller: 'SignInCtrl'
  })
.controller 'SignInCtrl', ($scope, AuthService, UserResource, UserService, $location)->
  $scope.user = {}
  $scope.error = ''
  $scope.submit = ()->
    AuthService.login $scope.user.email, $scope.user.password, $scope.user.domain
    .then (res)->
      AuthService.saveAccessToken(res.data.accessToken)
      UserResource.getCurrent {}, (userResource)->
        $scope.afterSignIn userResource
        $location.path('/tab/dash')
        $scope.error = ''
    ,
      (res)->
        $scope.error = res.data.message