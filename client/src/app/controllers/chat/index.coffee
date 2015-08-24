angular.module "crm"
  .controller "ChatCtrl", ($scope, UserService, $stateParams, EVENT_PREDATA_LOADED_SUCCESS, WebService, toastr, $location, $modal) ->
    id = $stateParams.id
    if id == ''
      $scope.showRight = false
    else
      $scope.showRight = true
    $scope.orderBy = '-getSort()'
    afterLoadPreData = ()->
      UserService.getChats().then (chats)->
        $scope.chats = chats
        $scope.message = ''
        if id != ''
          $scope.chat = UserService.getChat id
          if !$scope.chat?
            $location.path('/')
            return false
          $scope.chat.getHistoryMessage().then (messages)->
            $scope.messages = messages
          $scope.chat.resource.unReadCount = 0
          $scope.chat.resource.$update (res)->
            $scope.chat.resource = res

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
      if $scope.chat? && message.cid == $scope.chat.getCid()
        $scope.messages.push(message)
        $scope.$apply()
      else
        #其他窗口的消息, 把消息置顶, 并提示未读消息.

    $scope.addMembers = (chat)->
      modalInstance = $modal.open {
        templateUrl: 'add-members-modal.html',
        controller: 'addMembersModalCtrl'
        resolve: {
          members: ()->
            chat.getMembers()
          chat: ()->
            chat
        }
      }
      modalInstance.result.then (resData)->


    $scope.removeChat = (index, event)->
      chat = $scope.chats[index]
      if chat.isActive()
        if $scope.chats[1]
          cid = $scope.chats[1].id
          $location.path('/chat/'+cid)
        else
          $location.path('/chat/')
      $scope.chats.splice index,1
      chat.resource.$delete()
      event.preventDefault()


