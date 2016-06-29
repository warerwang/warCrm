angular.module('starter.modules.contacts.detail', [])

.config ($stateProvider, $urlRouterProvider)->
  $stateProvider.state('contact-profile', {
    url: '/contact/:id',
    templateUrl: 'coffeeScript/modules/contacts/detail/index.html',
    controller: 'ContactProfileCtrl'
  })
.controller 'ContactProfileCtrl', ($scope, UserService, $ionicNavBarDelegate, $stateParams, $location)->
  $ionicNavBarDelegate.showBackButton(true)
  id = $stateParams.id
  $scope.user = UserService.getUser id
  $scope.chat = (user)->
    UserService.openChat(
      user.id
    ,
      (chat)->
        $location.path("/chat/"+chat.id)
    )

