angular.module "crm"
  .controller 'ProjectCtrl', ($scope, UserService, WebService, EVENT_PREDATA_LOADED_SUCCESS, ProjectResource, $location) ->
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
    afterLoadPreData = ()->
      ProjectResource.query {}, (projects)->
        $scope.projects = (UserService.createProject project for project in projects)


    if WebService.isLoadedPreData
      afterLoadPreData()
    $scope.$on EVENT_PREDATA_LOADED_SUCCESS, ()->
      afterLoadPreData()

    $scope.delete = (index)->
      UtilsServ.confirm '确认要删除么?', ()->
        $scope.projects[index].resource.$delete()
        $scope.projects.splice index,1

  .controller 'ProjectDetailCtrl', ($scope, UserService, WebService, EVENT_PREDATA_LOADED_SUCCESS, ProjectResource, $stateParams, SprintResource, UtilsServ) ->
    afterLoadPreData = ()->
      ProjectResource.get {id:$stateParams.id}, (project)->
        $scope.project = UserService.createProject project
        SprintResource.query {pid:project.id}, (sprintsRes)->
          $scope.sprints = sprintsRes
          console.log $scope.sprints

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

    if WebService.isLoadedPreData
      afterLoadPreData()
    $scope.$on EVENT_PREDATA_LOADED_SUCCESS, ()->
      afterLoadPreData()

    $scope.update = ()->
      $scope.project.members = JSON.stringify(u.id for u in $scope.project.members)
      $scope.project.$update (resource)->
        $location.path('/project/' + resource.id)