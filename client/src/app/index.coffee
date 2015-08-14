angular.module 'crm', ['ngAnimate', 'ngCookies', 'ngTouch', 'ngSanitize', 'ngResource', 'ui.router', 'ui.bootstrap']
  .config ($stateProvider, $urlRouterProvider, $locationProvider) ->
    $stateProvider
      .state "home",
        url: "/",
        templateUrl: "app/controllers/main/main.html",
        controller: "MainCtrl"
      .state "account",
        url: '/account',
        templateUrl: "app/account/account.html",
        controller: "AccountCtrl"
    $locationProvider.html5Mode true
    $urlRouterProvider.otherwise '/'
  .constant('API_BASE_URL', 'http://api.warphp.com')
  .constant('PRE_PAGE_COUNT', 10);