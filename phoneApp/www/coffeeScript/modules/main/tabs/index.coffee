angular.module('starter.modules.main.tabs', [])

.config ($stateProvider, $urlRouterProvider)->
  $stateProvider.state 'tab', {
    templateUrl: "coffeeScript/modules/main/tabs/main.html",
    controller: 'MainTabsCtrl'
  }
.controller 'MainTabsCtrl', ($scope, $state)->
  $scope.isActive = (state)->
    state == $state.current.name