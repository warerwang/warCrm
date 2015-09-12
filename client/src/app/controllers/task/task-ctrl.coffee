angular.module "crm"
  .controller 'TaskAddCtrl', ($scope, UserService, TaskResource, WebService, EVENT_PREDATA_LOADED_SUCCESS, ProjectResource, SprintResource, $location) ->
    $scope.isCreate = true
    $scope.task = new TaskResource()


    afterLoadPreData = ()->
      $scope.users = UserService.getUsers()
      ProjectResource.query {}, (projectResources)->
        $scope.projects = (UserService.createProject project for project in projectResources)
        $scope.task.pid = $scope.projects[0]

        SprintResource.query {pid:$scope.task.pid.id}, (sprintRes)->
          $scope.sprints = (UserService.createSprint sprint for sprint in sprintRes)
          $scope.task.sid = $scope.sprints[0]

    if WebService.isLoadedPreData
      afterLoadPreData()
    $scope.$on EVENT_PREDATA_LOADED_SUCCESS, ()->
      afterLoadPreData()

    $scope.changeProject = ()->
      SprintResource.query {pid:$scope.task.pid.id}, (sprintRes)->
        $scope.sprints = (UserService.createSprint sprint for sprint in sprintRes)
        $scope.task.sid = $scope.sprints[0]

    $scope.create = ()->
      $scope.task.pid = $scope.task.pid.id
      $scope.task.sid = $scope.task.sid.id
      $scope.task.followers = JSON.stringify(u.id for u in $scope.task.followers)
      $scope.task.$save {}, (task)->
        $location.path('/task/' + task.id)

  .controller 'TaskEditCtrl', ($scope, UserService, WebService, EVENT_PREDATA_LOADED_SUCCESS, $location) ->
    console.log 1




  .controller 'TaskListCtrl', ($scope, UserService, WebService, EVENT_PREDATA_LOADED_SUCCESS, $location) ->
    console.log 1





  .controller 'TaskDetailCtrl', ($scope, UserService, WebService, EVENT_PREDATA_LOADED_SUCCESS, $location) ->
    console.log 1