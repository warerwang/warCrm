window.WARPHP_starter = angular.module('starter', ['ionic', 'ngCookies', 'ngResource', 'ui.bootstrap'])
  .run ($ionicPlatform)->
    $ionicPlatform.ready ()->
      if (window.cordova && window.cordova.plugins && window.cordova.plugins.Keyboard)
        cordova.plugins.Keyboard.hideKeyboardAccessoryBar(true);
        cordova.plugins.Keyboard.disableScroll(true);

      if (window.StatusBar)
        StatusBar.styleLightContent()
  .config ($stateProvider, $urlRouterProvider)->
    $stateProvider
      .state 'auth', {
        url: '/auth',
        controller:'SignInCtrl',
        templateUrl: 'templates/sign-in.html'
      }
      .state 'chat', {
        url: '/chat/:id',
        templateUrl: 'templates/chat-detail.html',
        controller: 'ChatDetailCtrl'
      }
      .state 'tab', {
        url: '/tab',
        abstract: true,
        templateUrl: 'templates/tabs.html'
      }
      .state('tab.dash', {
        url: '/dash',
        views: {
          'tab-dash': {
            templateUrl: 'templates/tab-dash.html',
            controller: 'DashCtrl'
          }
        }
      })
      .state('tab.chats', {
        url: '/chats',
        views: {
          'tab-chats': {
            templateUrl: 'templates/tab-chats.html',
            controller: 'ChatsCtrl'
          }
        }
      })
      .state('tab.chat-detail', {
        url: '/chats/:id',
        views: {
          'tab-chats': {
            templateUrl: 'templates/chat-detail.html',
            controller: 'ChatDetailCtrl'
          }
        }
      })
      .state('tab.contacts', {
        url: '/contacts',
        views: {
          'tab-contacts': {
            templateUrl: 'templates/tab-contacts.html',
            controller: 'ContactsCtrl'
          }
        }
      })
      .state('tab.account', {
        url: '/account',
        views: {
          'tab-account': {
            templateUrl: 'templates/tab-account.html',
            controller: 'AccountCtrl'
          }
        }
      })
    $urlRouterProvider.otherwise('/tab/dash')
  .constant('API_BASE_URL', 'http://www.warcrm.com')
  .constant('BASE_DOMAIN', 'warcrm.com')
  .constant('PRE_PAGE_COUNT', 10)
  .constant('EVENT_CONFIG_LOADED_SUCCESS', 'config-loaded-success')
  .constant('EVENT_SIGN_IN_SUCCESS', 'sign-in-success')
  .constant('EVENT_PREDATA_LOADED_SUCCESS', 'predata-loaded-success')
  .constant('EVENT_DOMAIN_NOT_FOUND', 'domain-not-found')