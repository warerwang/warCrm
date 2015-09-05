angular.module "crm"
  .controller "AdminUserCtrl", ($scope,
                                UserService,
                                EVENT_CONFIG_LOADED_SUCCESS,
                                WebService,
                                UtilsServ,
                                UserResource,
                                GlobalService) ->
    afterLoadPreData = ()->
      UserResource.query {status:0,did:GlobalService.config.id}, (users)->
        $scope.users = users

    if WebService.isLoadConfig
      afterLoadPreData()
    $scope.$on EVENT_CONFIG_LOADED_SUCCESS, ()->
      afterLoadPreData()

    $scope.remove = (index)->
      UtilsServ.confirm '确认要删除么?', ()->
        $scope.users[index].$delete()
        $scope.users.splice index,1