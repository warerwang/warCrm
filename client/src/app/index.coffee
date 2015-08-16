angular.module 'crm', ['ngAnimate', 'ngCookies', 'ngTouch', 'ngSanitize', 'ngResource', 'ui.router', 'ui.bootstrap']
  .config ($stateProvider, $urlRouterProvider, $locationProvider) ->
    $stateProvider
      .state "home",
        url: "/",
        templateUrl: "app/controllers/main/main.html",
        controller: "MainCtrl"
      .state "chat",
        url: '/chat/:id',
        templateUrl: "app/controllers/chat/index.html",
        controller: "ChatCtrl"
    $locationProvider.html5Mode true
    $urlRouterProvider.otherwise '/'
  .constant('API_BASE_URL', 'http://www.warcrm.com')
  .constant('PRE_PAGE_COUNT', 10)