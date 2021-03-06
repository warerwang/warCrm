window.WARPHP_starter = angular.module('crm',[
  'ngAnimate',
   'ngCookies',
   'ngTouch',
   'ngSanitize',
   'ngResource',
   'ui.router',
   'ui.bootstrap',
   'luegg.directives',
   'toastr',
   'ngImgCrop',
   'base64',
   'summernote',
   'localytics.directives'
]).config ($stateProvider, $urlRouterProvider, $locationProvider) ->
  $stateProvider
#  .state "home",
#    url: "/",
#    templateUrl: "app/controllers/main/main.html",
#    controller: "MainCtrl"
  .state "chat",
    url: '/chat/:id',
    templateUrl: "app/controllers/chat/index.html",
    controller: "ChatCtrl"
  .state "contact",
    url: '/contact',
    templateUrl: "app/controllers/contact/base.html",
    controller: "ContactCtrl"
  .state "contact.list",
    url: '/list',
    templateUrl: "app/controllers/contact/index.html",
  .state "contact.profile",
    url: "/:id",
    templateUrl: "app/controllers/contact/profile.html",
  .state "profile",
    url: "/profile",
    templateUrl: "app/controllers/profile/index.html",
    controller: "ProfileCtrl"
  .state "profile.profile",
    url: "/profile",
    templateUrl: "app/controllers/profile/profile.html",
  .state "profile.password",
    url: "/password",
    templateUrl: "app/controllers/profile/password.html",
  .state "profile.avatar",
    url: "/avatar",
    templateUrl: "app/controllers/profile/avatar.html",
  .state "admin",
    url: "/admin",
    templateUrl: "app/controllers/admin/admin.html",
    controller: "AdminCtrl"
  .state "adminUser",
    url: "/admin/user",
    abstract: true,
    templateUrl: "app/controllers/admin/user/index.html"
  .state "adminUser.list",
    url: "/list",
    templateUrl: "app/controllers/admin/user/list.html",
    controller: 'AdminUserCtrl'
  .state "adminUser.add",
    url: "/add",
    templateUrl: "app/controllers/admin/user/add.html",
  .state "adminUser.edit",
    url: "/edit/:id",
    templateUrl: "app/controllers/admin/user/edit.html"
  .state "project",
    url: "/project",
    abstract: true,
    templateUrl: "app/controllers/base.html"
  .state "project.list",
    url: "/list",
    templateUrl: "app/controllers/project/list.html"
    controller: "ProjectListCtrl"
  .state "project.add",
    url: "/add",
    templateUrl: "app/controllers/project/add.html",
    controller: "ProjectCtrl"
  .state "project.detail",
    url: "/:id",
    templateUrl: "app/controllers/project/detail.html"
    controller: "ProjectDetailCtrl"
  .state "project.edit",
    url: "/:id/edit",
    templateUrl: "app/controllers/project/add.html"
    controller: "ProjectEditCtrl"
  .state "project.sprint-add",
    url: "/:id/sprint-add",
    controller: "SprintAddCtrl"
    templateUrl: "app/controllers/project/sprint-add.html"
  .state "project.sprint-detail",
    url: "/:id/:sid",
    controller: "SprintDetailCtrl"
    templateUrl: "app/controllers/project/sprint-detail.html"
  .state "project.sprint-list",
    url: "/:id/sprint-list",
    controller: "SprintListCtrl"
    templateUrl: "app/controllers/project/sprint-list.html"
  .state "project.sprint-edit",
    url: "/:id/:sid/edit",
    controller: "SprintEditCtrl"
    templateUrl: "app/controllers/project/sprint-add.html"
  .state "task",
    url: "/task",
    abstract: true,
    templateUrl: "app/controllers/base.html"
  .state "task.add",
    url: "/:oid/:uid/:pid/:sid/add",
    controller: "TaskAddCtrl",
    templateUrl: "app/controllers/task/add.html"
  .state "task.list",
    url: "/:oid/:uid/:pid/:sid",
    controller: "TaskListCtrl",
    templateUrl: "app/controllers/task/list.html"
  .state "task.detail",
    url: "/:id",
    controller: "TaskDetailCtrl",
    templateUrl: "app/controllers/task/detail.html"
  .state "task.edit",
    url: "/:id/edit",
    controller: "TaskEditCtrl",
    templateUrl: "app/controllers/task/add.html"

  $locationProvider.html5Mode true
  $urlRouterProvider.otherwise '/chat/'
.constant('API_BASE_URL', 'http://www.docker.gwork.cc:888')
.constant('BASE_DOMAIN', 'docker.gwork.cc')
.constant('PRE_PAGE_COUNT', 10)
.constant('EVENT_CONFIG_LOADED_SUCCESS', 'config-loaded-success')
.constant('EVENT_SIGN_IN_SUCCESS', 'sign-in-success')
.constant('EVENT_PREDATA_LOADED_SUCCESS', 'predata-loaded-success')
.constant('EVENT_DOMAIN_NOT_FOUND', 'domain-not-found')






