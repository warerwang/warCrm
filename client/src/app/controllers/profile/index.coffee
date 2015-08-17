angular.module 'crm'
  .controller "ProfileCtrl", ($scope, UserService, $stateParams, AuthService, EVENT_PREDATA_LOADED_SUCCESS, WebService) ->
    uid = $stateParams.id
    afterLoadPreData = ()->
      if uid == ''
        uid = AuthService.currentUser.id
      $scope.user    = UserService.getUser uid
      $scope.userRes = $scope.user.resource

    if WebService.isLoadedPreData
      afterLoadPreData()
    $scope.$on EVENT_PREDATA_LOADED_SUCCESS, ()->
      afterLoadPreData()

    $scope.save = ()->
      $scope.userRes.$update {id:uid} , (user)->
        $scope.user = UserService.createUser user






