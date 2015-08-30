angular.module "crm"
  .controller "ContactCtrl", ($scope, UserService, $location) ->
    $scope.query = ''
    $scope.order = 'resource.name'
    $scope.chat = (user)->
      UserService.openChat user.id, (chat)->
        $location.path '/chat/'+chat.id

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