angular.module "crm"
  .controller "AdminUserCtrl", ($scope, UserService, EVENT_PREDATA_LOADED_SUCCESS, WebService, UtilsServ) ->
    afterLoadPreData = ()->
      $scope.users = UserService.getUsers()

    if WebService.isLoadedPreData
      afterLoadPreData()
    $scope.$on EVENT_PREDATA_LOADED_SUCCESS, ()->
      afterLoadPreData()

    $scope.remove = (index)->
      UtilsServ.confirm '确认要删除么?', ()->
        $scope.users[index].resource.$delete()
        $scope.users.splice index,1