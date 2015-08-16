angular.module "crm"
  .controller "ChatCtrl", ($scope, UserService, $stateParams, ConnectService) ->
    UserService.getUsers().then (users)->
      $scope.users = users

    id = $stateParams.id
    UserService.getRecentChat().then (chats)->
      $scope.chats = chats
      if id != ''
        $scope.chat = UserService.getChat id
        $scope.chat.getHistoryMessage().then (messages)->
          $scope.messages = messages
          $(".chat-container").scrollTop(20000)

    $scope.message = ''
    $scope.sendMessage = ()->
      $scope.chat.sendMessage($scope.message)

    $scope.$on 'new-message', (event, message)->
      if message.cid == id
        $scope.messages.push(message)
        $scope.$apply()
        $(".chat-container").scrollTop($(".chat-container")[0].scrollHeight + 1000)
      else
        #其他窗口的消息, 把消息置顶, 并提示未读消息.
