angular.module "crm"
  .controller "ContactCtrl", ($scope, UserService, $location, $modal) ->
    $scope.query = ''
    $scope.order = 'resource.name'
    $scope.chat = (user)->
      UserService.openChat user.id, (chat)->
        $location.path '/chat/'+chat.id

    $scope.inviteMember = ()->
      modalInstance = $modal.open {
        templateUrl: 'invite-modal.html',
        controller: 'inviteModalCtrl'
      }
#      modalInstance.result.then (resData)->
#  #        $scope.afterSignIn resData
#      false


  .controller "ContactProfileCtrl", ($scope, $stateParams, UserService, WebService, EVENT_PREDATA_LOADED_SUCCESS) ->
    id = $stateParams.id
    afterLoadPreData = ()->
      if id?
        $scope.user = UserService.getUser id
      else
        $scope.users = UserService.getUsers()
    if WebService.isLoadedPreData
      afterLoadPreData()
    $scope.$on EVENT_PREDATA_LOADED_SUCCESS, ()->
      afterLoadPreData()


