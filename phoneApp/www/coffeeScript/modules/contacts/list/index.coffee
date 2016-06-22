angular.module('starter.modules.contacts.list', [])

.config ($stateProvider, $urlRouterProvider)->
  $stateProvider.state('tab.contacts', {
    url: '/contacts',
    templateUrl: 'coffeeScript/modules/contacts/list/index.html',
    controller: 'ContactsCtrl'
  })
.controller 'ContactsCtrl', ($scope, UserService, $ionicNavBarDelegate, WebService, EVENT_PREDATA_LOADED_SUCCESS)->
  $ionicNavBarDelegate.showBackButton(false)
  afterLoadPreData = ()->
    $scope.users = UserService.getUsers()

  if WebService.isLoadedPreData
    afterLoadPreData()
  $scope.$on EVENT_PREDATA_LOADED_SUCCESS, ()->
    afterLoadPreData()