angular.module "crm"
  .controller "ContactCtrl", ($scope, UserService, $location, $uibModal) ->
    $scope.query = ''
    $scope.order = 'resource.name'
    $scope.chat = (user)->
      UserService.openChat user.id, (chat)->
        $location.path '/chat/'+chat.id

    $scope.inviteMember = ()->
      modalInstance = $uibModal.open {
        templateUrl: 'invite-modal.html',
        controller: 'inviteModalCtrl'
      }

  .controller "ContactProfileCtrl", ($scope, $stateParams, UserService, WebService, EVENT_PREDATA_LOADED_SUCCESS) ->

    id = $stateParams.id
    afterLoadPreData = ()->
      if id?
        $scope.user = UserService.getUser id
        $scope.setBreadcrumbs [
          {name:"首页", link:"/"},
          {name:"通讯录", link:"/contact/list"},
          {name:$scope.user.getName(), link:""}
        ]
      else
        $scope.users = UserService.getUsers()
        $scope.setBreadcrumbs [
          {name:"首页", link:"/"},
          {name:"通讯录", link:""}
        ]
    if WebService.isLoadedPreData
      afterLoadPreData()
    $scope.$on EVENT_PREDATA_LOADED_SUCCESS, ()->
      afterLoadPreData()


