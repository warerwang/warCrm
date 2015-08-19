angular.module "crm"
  .controller "AdminCtrl", ($scope, UserService, $stateParams, EVENT_PREDATA_LOADED_SUCCESS, WebService) ->
#    afterLoadPreData = ()->
#      $scope.users = UserService.getUsers()
#      $scope.chats = UserService.getRecentChat()
#
#    if WebService.isLoadedPreData
#      afterLoadPreData()
#    $scope.$on EVENT_PREDATA_LOADED_SUCCESS, ()->
#      afterLoadPreData()

