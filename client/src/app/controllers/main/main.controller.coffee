angular.module "crm"
  .controller "MainCtrl", ($scope, UserService, UserResource, WebService, EVENT_PREDATA_LOADED_SUCCESS) ->
    afterLoadPreData = ()->
      UserResource.getDashboard {}, (data)->
        $scope.projects = (UserService.createProject project for project in data.projects)
        $scope.tasks = (UserService.createTask task for task in data.tasks)

    if WebService.isLoadedPreData
      afterLoadPreData()
    $scope.$on EVENT_PREDATA_LOADED_SUCCESS, ()->
      afterLoadPreData()