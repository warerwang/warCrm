angular.module "crm"
  .controller "AdminUserCtrl", ($scope, UserService, $stateParams, EVENT_PREDATA_LOADED_SUCCESS, WebService, UserResource, GlobalService, $location) ->
    afterLoadPreData = ()->
      $scope.users = UserService.getUsers()
      uid = $stateParams.id
      if uid
        if uid == ''
          $scope.userRes = new UserResource({did:GlobalService.config.id})
          $scope.userRes.isAdmin = 0;
        else
          user = UserService.getUser uid
          $scope.userRes = user.resource

    if WebService.isLoadedPreData
      afterLoadPreData()
    $scope.$on EVENT_PREDATA_LOADED_SUCCESS, ()->
      afterLoadPreData()



    $scope.save = ()->
      $scope.userRes.$save (userData)->
        UserService.addNewUser userData
        #todo 增加一个成功的提示
        $scope.userRes = new UserResource({did:GlobalService.config.id})
        $scope.userRes.isAdmin = 0;
      ,
      (res)->
        for key, error of res.data
          eval "$scope.userForm."+key+".$invalid = true"
          eval "$scope.userForm."+key+".$dirty = true"
          eval "$scope.userForm."+key+".error = error"



    $scope.update = ()->
      $scope.userRes.$update (userData)->
#        UserService.addNewUser userData
        #todo 增加一个成功的提示
#        $scope.userRes = new UserResource({did:GlobalService.config.id})
#        $scope.userRes.isAdmin = 0;
      ,
      (res)->
        for key, error of res.data
          eval "$scope.userForm."+key+".$invalid = true"
          eval "$scope.userForm."+key+".$dirty = true"
          eval "$scope.userForm."+key+".error = error"
