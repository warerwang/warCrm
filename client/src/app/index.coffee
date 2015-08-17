angular.module 'crm', ['ngAnimate', 'ngCookies', 'ngTouch', 'ngSanitize', 'ngResource', 'ui.router', 'ui.bootstrap', 'luegg.directives']
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
      .state "profile",
        url: "/profile/:id",
        templateUrl: "app/controllers/profile/index.html",
        controller: "ProfileCtrl"

    $locationProvider.html5Mode true
    $urlRouterProvider.otherwise '/'
  .constant('API_BASE_URL', 'http://www.warcrm.com')
  .constant('BASE_DOMAIN', 'warcrm.com')
  .constant('PRE_PAGE_COUNT', 10)
  .constant('EVENT_CONFIG_LOADED_SUCCESS', 'config-loaded-success')
  .constant('EVENT_SIGN_IN_SUCCESS', 'sign-in-success')
  .constant('EVENT_PREDATA_LOADED_SUCCESS', 'predata-loaded-success')





