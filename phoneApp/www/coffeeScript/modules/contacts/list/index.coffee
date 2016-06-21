angular.module('starter.modules.contacts.list', [])

.config ($stateProvider, $urlRouterProvider)->
  $stateProvider.state('tab.contacts', {
    url: '/contacts',
    templateUrl: 'coffeeScript/modules/contacts/list/index.html',
    controller: 'ContactsCtrl'
  })
.controller 'ContactsCtrl', ($scope, UserService)->
  $scope.users = UserService.getUsers()