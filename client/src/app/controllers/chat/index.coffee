angular.module "crm"
  .controller "ChatCtrl", ($scope, UserService, $stateParams, EVENT_PREDATA_LOADED_SUCCESS, WebService, toastr) ->
    id = $stateParams.id

    afterLoadPreData = ()->
      $scope.users = UserService.getUsers()
      $scope.chats = UserService.getRecentChat()
      $scope.message = ''

      if id != ''
        $scope.chat = UserService.getChat id
        $scope.chat.getHistoryMessage().then (messages)->
          $scope.messages = messages

    if WebService.isLoadedPreData
      afterLoadPreData()
    $scope.$on EVENT_PREDATA_LOADED_SUCCESS, ()->
      afterLoadPreData()

    $scope.sendMessage = ()->
      if $scope.message == ''
        toastr.warning '不能发送空子符'
      else
        $scope.chat.sendMessage($scope.message)
        $scope.message = ''

    $scope.enterSubmit = (event)->
      if event.keyCode == 13
        $scope.sendMessage()
        event.preventDefault()

    $scope.$on 'new-message', (event, message)->

      if message.cid == id
        $scope.messages.push(message)
        $scope.$apply()
      else
        #其他窗口的消息, 把消息置顶, 并提示未读消息.
