angular.module "crm"
  .controller "AdminUserEditCtrl", ($scope, UserService, $stateParams, EVENT_PREDATA_LOADED_SUCCESS, WebService, UserResource, GlobalService, $location, toastr) ->

    uid = $stateParams.id
    afterLoadPreData = ()->
      $scope.users = UserService.getUsers()
      if uid  #编辑
        user = UserService.getUser uid
        if user?
          $scope.userRes = user.resource
        else
          $location.path('/admin/user/list')
      else  #添加
        $scope.userRes = new UserResource({did:GlobalService.config.id})
        $scope.userRes.isAdmin = 0;

    if WebService.isLoadedPreData
      afterLoadPreData()
    $scope.$on EVENT_PREDATA_LOADED_SUCCESS, ()->
      afterLoadPreData()



    $scope.save = ()->
      $scope.userRes.$save (userData)->
        UserService.addNewUser userData
        toastr.success('添加用户成功')
        $scope.userRes = new UserResource({did:GlobalService.config.id})
        $scope.userRes.isAdmin = 0;
        $scope.userForm.$setPristine()
      ,
      (res)->
        for key, error of res.data
          eval "$scope.userForm."+key+".$invalid = true"
          eval "$scope.userForm."+key+".$dirty = true"
          eval "$scope.userForm."+key+".error = error"



    $scope.update = ()->
      $scope.userRes.$update (userData)->
        user = UserService.getUser uid
        user.resource = userData
        toastr.success('修改用户成功')
        $location.path('/admin/user/list')
      ,
      (res)->
        for key, error of res.data
          eval "$scope.userForm."+key+".$invalid = true"
          eval "$scope.userForm."+key+".$dirty = true"
          eval "$scope.userForm."+key+".error = error"
