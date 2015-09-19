angular.module "crm"
  .controller 'TaskAddCtrl', ($scope, UserService, TaskResource, WebService, EVENT_PREDATA_LOADED_SUCCESS, ProjectResource, SprintResource, $location) ->
    $scope.isCreate = true
    $scope.task = new TaskResource()
    $scope.types = UserService.taskTypes
    $scope.task.type = UserService.taskTypes[0]

    afterLoadPreData = ()->
      $scope.users = UserService.getUsers()
      ProjectResource.query {}, (projectRes)->
        $scope.projects = (UserService.createProject project for project in projectRes)
        $scope.task.pid = $scope.projects[0]

        SprintResource.query {pid:$scope.task.pid.id}, (sprintRes)->
          $scope.sprints = (UserService.createSprint sprint for sprint in sprintRes)
          $scope.task.sid = $scope.sprints[0]

        $scope.setBreadcrumbs [
          {name:"首页", link:"/"},
          {name:"项目列表", link:"/project/list"},
          {name:"创建新任务"}
        ]

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
      $scope.task.type = $scope.task.type.id
      if !$scope.task.followers?
        $scope.task.followers = []
      $scope.task.followers = JSON.stringify(u.id for u in $scope.task.followers)
      $scope.task.$save {}, (task)->
        $location.path('/task/' + task.id)

  .controller 'TaskEditCtrl', ($scope, UserService, WebService, EVENT_PREDATA_LOADED_SUCCESS, $location) ->
    console.log 1




  .controller 'TaskListCtrl', ($scope, UserService, WebService, EVENT_PREDATA_LOADED_SUCCESS, $location) ->
    console.log 1





  .controller 'TaskDetailCtrl', ($scope, UserService, WebService, EVENT_PREDATA_LOADED_SUCCESS, $location, TaskResource, $stateParams, CommentResource) ->
    afterLoadPreData = ()->
      TaskResource.get {id:$stateParams.id,expand:'project,sprint'}, (taskRes)->
        $scope.task = UserService.createTask taskRes
        CommentResource.query {rid:taskRes.id}, (commentRes)->
          $scope.comments = (UserService.createComment comment for comment in commentRes)
        $scope.setBreadcrumbs [
          {name:"首页", link:"/"},
          {name:"项目列表", link:"/project/list"},
          {name:taskRes.project.name, link:"/project/" + taskRes.project.id},
          {name:taskRes.title}
        ]

    if WebService.isLoadedPreData
      afterLoadPreData()
    $scope.$on EVENT_PREDATA_LOADED_SUCCESS, ()->
      afterLoadPreData()
    $scope.comment = new CommentResource
    $scope.createComment = ()->
      $scope.comment.relationId = $scope.task.id
      $scope.comment.type = 'task'
      $scope.comment.$save {}, (commentRes)->
        $scope.comments.push (UserService.createComment commentRes)
        $scope.task.resource.lastModify = (new Date()).toUTCString()
        $scope.comment = new CommentResource
