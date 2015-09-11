angular.module "crm"
  .controller 'SprintAddCtrl', ($scope, UserService, WebService, EVENT_PREDATA_LOADED_SUCCESS, SprintResource, $location, $filter, $stateParams, toastr) ->
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
      $scope.sprint = resource
      $scope.sprint.startTime = (new Date(resource.startTime))
      $scope.sprint.endTime = (new Date(resource.endTime))


      d = new Date()
      $scope.startMinDate = $filter('date')(d, "yyyy-MM-dd", null)
      $scope.startMaxDate = "2099-12-31"
      $scope.endMinDate = $filter('date')(d.valueOf() + 24 * 3600 *1000, "yyyy-MM-dd", null)
      $scope.endMaxDate = "2099-12-31"

      $scope.changeStart = ()->
        $scope.endMinDate = $filter('date')((new Date($scope.sprint.startTime)).valueOf() + 24 * 3600 *1000, "yyyy-MM-dd", null)

      $scope.changeEnd = ()->
        $scope.startMaxDate = $filter('date')((new Date($scope.sprint.endTime)).valueOf() - 24 * 3600 *1000, "yyyy-MM-dd", null)