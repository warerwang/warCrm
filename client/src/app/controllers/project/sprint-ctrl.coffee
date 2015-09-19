angular.module "crm"
  .controller 'SprintAddCtrl', ($scope, UserService, WebService, EVENT_PREDATA_LOADED_SUCCESS, SprintResource, $location, $filter, $stateParams, toastr, ProjectResource) ->

    ProjectResource.get {id:$stateParams.id}, (project)->
      $scope.setBreadcrumbs [
        {name:"首页", link:"/"},
        {name:"项目列表", link:"/project/list"},
        {name:project.name, link:"/project/" + project.id},
        {name:"创建里程碑", link:""},
      ]
    , ()->
      $location.path('project/list')

    $scope.isCreate = true
    $scope.sprint = new SprintResource()
    $scope.sprint.pid = $stateParams.id

    d = new Date()
    $scope.startMinDate = $filter('date')(d, "yyyy-MM-dd", null)
    $scope.startMaxDate = "2099-12-31"
    $scope.endMinDate = $filter('date')(d.valueOf() + 24 * 3600 *1000, "yyyy-MM-dd", null)
    $scope.endMaxDate = "2099-12-31"

    $scope.changeStart = ()->
      $scope.endMinDate = $filter('date')((new Date($scope.sprint.startTime)).valueOf() + 24 * 3600 *1000, "yyyy-MM-dd", null)

    $scope.changeEnd = ()->
      $scope.startMaxDate = $filter('date')((new Date($scope.sprint.endTime)).valueOf() - 24 * 3600 *1000, "yyyy-MM-dd", null)

    $scope.create = ()->
      $scope.sprint.$save {}, (res)->
        toastr.success "里程碑创建成功"
        $location.path('/project/' + $scope.sprint.pid)



  .controller 'SprintEditCtrl', ($scope, UserService, WebService, EVENT_PREDATA_LOADED_SUCCESS, SprintResource, $location, $filter, $stateParams, toastr) ->
    $scope.isEdit = true
    SprintResource.get {id:$stateParams.sid}, (resource)->
      $scope.setBreadcrumbs [
        {name:"首页", link:"/"},
        {name:"项目列表", link:"/project/list"},
        {name:resource.name, link:"/project/" + resource.pid + '/' + resource.id},
        {name:"修改里程碑", link:""},
      ]
      sprint = UserService.createSprint resource
      $scope.sprint = resource
      $scope.sprint.startTime = sprint.getStartTime()
      $scope.sprint.endTime   = sprint.getEndTime()

      d = new Date()
      $scope.startMinDate = $filter('date')(d, "yyyy-MM-dd", null)
      $scope.startMaxDate = "2099-12-31"
      $scope.endMinDate = $filter('date')(d.valueOf() + 24 * 3600 *1000, "yyyy-MM-dd", null)
      $scope.endMaxDate = "2099-12-31"

      $scope.changeStart = ()->
        $scope.endMinDate = $filter('date')((new Date($scope.sprint.startTime)).valueOf() + 24 * 3600 *1000, "yyyy-MM-dd", null)

      $scope.changeEnd = ()->
        $scope.startMaxDate = $filter('date')((new Date($scope.sprint.endTime)).valueOf() - 24 * 3600 *1000, "yyyy-MM-dd", null)

      $scope.create = ()->
        $scope.sprint.$update {}, (res)->
        toastr.success "里程碑修改成功"
        $location.path('/project/' + $scope.sprint.pid)




  .controller 'SprintDetailCtrl', ($scope, UserService, WebService, EVENT_PREDATA_LOADED_SUCCESS, SprintResource, $location, TaskResource, $stateParams, toastr) ->
    SprintResource.get {id:$stateParams.sid}, (resource)->
      $scope.setBreadcrumbs [
        {name:"首页", link:"/"},
        {name:"项目列表", link:"/project/list"},
        {name:resource.name, link:""}
      ]

      $scope.sprint = UserService.createSprint resource
      TaskResource.query {sid:$stateParams.sid}, (taskRes)->
        $scope.tasks = (UserService.createTask task for task in taskRes)


