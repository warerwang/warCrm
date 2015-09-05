angular.module "crm"
.controller "AdminUserEditCtrl", ( $scope,
                                   UserService,
                                   $stateParams,
                                   WebService,
                                   UserResource,
                                   GlobalService,
                                   $location,
                                   toastr
                                   EVENT_CONFIG_LOADED_SUCCESS
                                   ConnectService
) ->
  uid = $stateParams.id
  afterLoadPreData = ()->
    UserResource.query {status:0,did:GlobalService.config.id}, (users)->
      $scope.users = users
  #   编辑
      if uid
        user = u for u in users when u.id == uid
        if user?
          $scope.userRes = user
        else
          $location.path('/admin/user/list')
      else  #添加
        $scope.userRes = new UserResource({did:GlobalService.config.id})
        $scope.userRes.isAdmin = 0

  if WebService.isLoadConfig
    afterLoadPreData()
  $scope.$on EVENT_CONFIG_LOADED_SUCCESS, ()->
    afterLoadPreData()

  $scope.save = ()->
    $scope.userRes.$save (userData)->
      toastr.success('添加用户成功')
      ConnectService.sendBroadcast('user-add', userData)
      $scope.userRes = new UserResource({did:GlobalService.config.id})
      $scope.userRes.isAdmin = 0
      $scope.userForm.$setPristine()
    ,
    (res)->
      for key, error of res.data
        eval "$scope.userForm."+key+".$invalid = true"
        eval "$scope.userForm."+key+".$dirty = true"
        eval "$scope.userForm."+key+".error = error"



  $scope.update = ()->
    $scope.userRes.$update (userData)->
      ConnectService.sendBroadcast('user-edit', userData)
      toastr.success('修改用户成功')
      $location.path('/admin/user/list')
    ,
    (res)->
      for key, error of res.data
        eval "$scope.userForm."+key+".$invalid = true"
        eval "$scope.userForm."+key+".$dirty = true"
        eval "$scope.userForm."+key+".error = error"
