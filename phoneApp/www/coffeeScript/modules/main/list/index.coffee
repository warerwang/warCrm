angular.module('starter.modules.main.list', [])

.config ($stateProvider, $urlRouterProvider)->
  $stateProvider.state('tab.main', {
    url: '/main',
    templateUrl: 'coffeeScript/modules/main/list/index.html',
    controller: 'ChatsCtrl'
  })
.controller 'ChatsCtrl', ($scope, UserService, WebService, EVENT_PREDATA_LOADED_SUCCESS, $ionicNavBarDelegate)->
  $ionicNavBarDelegate.showBackButton(false);
  afterLoadPreData = ()->
    UserService.getChats().then (chats)->
      $scope.chats = chats

  if WebService.isLoadedPreData
    afterLoadPreData()
  $scope.$on EVENT_PREDATA_LOADED_SUCCESS, ()->
    afterLoadPreData()