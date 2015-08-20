angular.module 'crm', ['ngAnimate', 'ngCookies', 'ngTouch', 'ngSanitize', 'ngResource', 'ui.router', 'ui.bootstrap', 'luegg.directives', 'toastr']
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
          url: "/profile",
          templateUrl: "app/controllers/profile/index.html",
          controller: "ProfileCtrl"
      .state "profile.user",
          url: "/profile/:id",
          templateUrl: "app/controllers/profile/index.html",
          controller: "ProfileCtrl"
      .state "admin",
          url: "/admin",
          templateUrl: "app/controllers/admin/admin.html",
          controller: "AdminCtrl"
      .state "adminUser",
          url: "/admin/user",
          controller: "AdminUserCtrl"
          templateUrl: "app/controllers/admin/user/index.html",
      .state "adminUser.list",
          url: "/list",
          templateUrl: "app/controllers/admin/user/list.html",
      .state "adminUser.add",
          url: "/add",
          templateUrl: "app/controllers/admin/user/add.html",
      .state "adminUser.edit",
          url: "/edit/:id",
          templateUrl: "app/controllers/admin/user/edit.html",

    $locationProvider.html5Mode true
    $urlRouterProvider.otherwise '/'
  .constant('API_BASE_URL', 'http://www.warcrm.com')
  .constant('BASE_DOMAIN', 'warcrm.com')
  .constant('PRE_PAGE_COUNT', 10)
  .constant('EVENT_CONFIG_LOADED_SUCCESS', 'config-loaded-success')
  .constant('EVENT_SIGN_IN_SUCCESS', 'sign-in-success')
  .constant('EVENT_PREDATA_LOADED_SUCCESS', 'predata-loaded-success')
  .constant('EVENT_DOMAIN_NOT_FOUND', 'domain-not-found')






