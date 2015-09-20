angular.module "crm"
  .controller 'ProjectCtrl', ($scope, UserService, WebService, EVENT_PREDATA_LOADED_SUCCESS, ProjectResource, $location) ->
    $scope.setBreadcrumbs [
      {name:"首页", link:"/"},
      {name:"项目列表", link:"/project/list"},
      {name:"创建新项目", link:''}
    ]
    $scope.isCreate = true
    $scope.project = {type : 1}
    afterLoadPreData = ()->
      $scope.users = UserService.getUsers()

    if WebService.isLoadedPreData
      afterLoadPreData()
    $scope.$on EVENT_PREDATA_LOADED_SUCCESS, ()->
      afterLoadPreData()

    $scope.create = ()->
      project = new ProjectResource()
      project.name = $scope.project.name
      project.content = $scope.project.content
      project.type = $scope.project.type
      project.members = JSON.stringify(u.id for u in $scope.project.members)
      project.$save (resource)->
        $location.path('/project/' + resource.id)


  .controller 'ProjectListCtrl', ($scope, UserService, WebService, EVENT_PREDATA_LOADED_SUCCESS, ProjectResource, UtilsServ) ->
    $scope.setBreadcrumbs [
      {name:"首页", link:"/"},
      {name:"项目列表", link:""}
    ]
    $scope.setTools [
      {name:"创建新的项目", link:"/project/add"}
    ]
    afterLoadPreData = ()->
      ProjectResource.query {expand:'currentSprint'}, (projects)->
        $scope.projects = (UserService.createProject project for project in projects)

    if WebService.isLoadedPreData
      afterLoadPreData()
    $scope.$on EVENT_PREDATA_LOADED_SUCCESS, ()->
      afterLoadPreData()

    $scope.delete = (index)->
      UtilsServ.confirm '确认要删除么?', ()->
        $scope.projects[index].resource.$delete()
        $scope.projects.splice index,1

  .controller 'ProjectDetailCtrl', ($scope, UserService, WebService, EVENT_PREDATA_LOADED_SUCCESS, ProjectResource, $stateParams, SprintResource, TaskResource, UtilsServ) ->
    $scope.setTools []
    afterLoadPreData = ()->
      ProjectResource.get {id:$stateParams.id,expand:'taskCount,sprintCount,currentSprint'}, (project)->
        $scope.setBreadcrumbs [
          {name:"首页", link:"/"},
          {name:"项目列表", link:"/project/list"},
          {name:project.name, link:""},
        ]
        $scope.project = UserService.createProject project
        SprintResource.query {pid:project.id}, (sprintsRes)->
          $scope.sprints = (UserService.createSprint sprint for sprint in sprintsRes)

        TaskResource.query {pid:project.id,status:-4}, (tasksRes)->
          $scope.tasks = (UserService.createTask task for task in tasksRes)

    if WebService.isLoadedPreData
      afterLoadPreData()
    $scope.$on EVENT_PREDATA_LOADED_SUCCESS, ()->
      afterLoadPreData()

    $scope.delete = (index)->
      UtilsServ.confirm '确认要删除么?', ()->
        $scope.sprints[index].$delete()
        $scope.sprints.splice index,1

  .controller 'ProjectEditCtrl', ($scope, UserService, WebService, EVENT_PREDATA_LOADED_SUCCESS, ProjectResource, $stateParams, $location) ->
    $scope.isEdit = true;
    afterLoadPreData = ()->
      $scope.users = UserService.getUsers()
      ProjectResource.get {id:$stateParams.id}, (projectRes)->
        project = UserService.createProject projectRes
        $scope.project = project.resource
        $scope.project.members = project.getMembers()

        $scope.setBreadcrumbs [
          {name:"首页", link:"/"},
          {name:"项目列表", link:"/project/list"},
          {name:project.getName(), link:"/project/" + project.id},
          {name:"修改项目", link:''}
        ]

    if WebService.isLoadedPreData
      afterLoadPreData()
    $scope.$on EVENT_PREDATA_LOADED_SUCCESS, ()->
      afterLoadPreData()

    $scope.update = ()->
      $scope.project.members = JSON.stringify(u.id for u in $scope.project.members)
      $scope.project.$update (resource)->
        $location.path('/project/' + resource.id)