angular.module('starter.modules.main.list', [])

.config ($stateProvider, $urlRouterProvider)->
  $stateProvider.state('tab.main', {
    url: '/chat',
    templateUrl: 'coffeeScript/modules/main/list/index.html',
    controller: 'ChatsCtrl'
  })
.controller 'ChatsCtrl', ($scope, UserService, WebService, EVENT_PREDATA_LOADED_SUCCESS, $ionicNavBarDelegate)->
  $ionicNavBarDelegate.showBackButton(false);
  $scope.orderBy = '-getSort()'
  $scope.remove = (chat)->
#    chat = UserService.getChat id
    index = $scope.chats.indexOf(chat)
    $scope.chats.splice index,1
    chat.resource.$delete()
    if chat.isActive()
      if $scope.chats[0]?
        cid = $scope.chats[0].id
        $location.path('/chat/'+cid)
      else
        $location.path('/chat/')

  afterLoadPreData = ()->
    UserService.getChats().then (chats)->
      $scope.chats = chats

  if WebService.isLoadedPreData
    afterLoadPreData()
  $scope.$on EVENT_PREDATA_LOADED_SUCCESS, ()->
    afterLoadPreData()