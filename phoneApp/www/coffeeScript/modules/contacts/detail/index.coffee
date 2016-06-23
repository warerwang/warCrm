angular.module('starter.modules.contacts.detail', [])

.config ($stateProvider, $urlRouterProvider)->
  $stateProvider.state('contact-profile', {
    url: '/contact/:id',
    templateUrl: 'coffeeScript/modules/contacts/detail/index.html',
    controller: 'ContactProfileCtrl'
  })
.controller 'ContactProfileCtrl', ($scope, UserService, $ionicNavBarDelegate, $stateParams)->
  $ionicNavBarDelegate.showBackButton(true)
  id = $stateParams.id
  user = UserService.getUser id
  console.log user

