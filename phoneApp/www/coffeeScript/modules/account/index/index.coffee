angular.module('starter.modules.account.index', [])

.config ($stateProvider, $urlRouterProvider)->
  $stateProvider.state('tab.account', {
    url: '/account',
    templateUrl: 'coffeeScript/modules/account/index/index.html',
    controller: 'AccountCtrl'
  })

.controller 'AccountCtrl', ($scope)->
  $scope.settings = {
    enableFriends: true
  }