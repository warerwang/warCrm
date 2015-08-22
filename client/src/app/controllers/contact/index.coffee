angular.module "crm"
  .controller "ContactCtrl", ($scope, UserService, $stateParams, EVENT_PREDATA_LOADED_SUCCESS, WebService, toastr, $location, ChatResource) ->
    $scope.query = ''
    $scope.order = 'resource.name'
    afterLoadPreData = ()->
      $scope.users = UserService.getUsers()


    if WebService.isLoadedPreData
      afterLoadPreData()
    $scope.$on EVENT_PREDATA_LOADED_SUCCESS, ()->
      afterLoadPreData()


    $scope.chat = (user)->
      chat = UserService.getChat user.id
      if chat
        $location.path('/chat/' + chat.id)
      else
        ChatResource.get {id:user.id}, (res)->
          chat = UserService.createChat res
          UserService.chats.push(chat)
          $location.path('/chat/' + chat.id)