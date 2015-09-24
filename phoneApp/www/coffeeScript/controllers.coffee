WARPHP_starter
  .controller 'DashCtrl', ($scope, UserResource, UserService, EVENT_PREDATA_LOADED_SUCCESS, WebService, AuthService)->
    afterLoadPreData = ()->
      UserResource.getDashboard {}, (data)->
        $scope.projects = (UserService.createProject project for project in data.projects)
        $scope.tasks = (UserService.createTask task for task in data.tasks)
    if WebService.isLoadedPreData
      afterLoadPreData()
    $scope.$on EVENT_PREDATA_LOADED_SUCCESS, ()->
      afterLoadPreData()


  .controller 'ChatsCtrl', ($scope, UserService, WebService, EVENT_PREDATA_LOADED_SUCCESS)->
    afterLoadPreData = ()->
      UserService.getChats().then (chats)->
        $scope.chats = chats

    if WebService.isLoadedPreData
      afterLoadPreData()
    $scope.$on EVENT_PREDATA_LOADED_SUCCESS, ()->
      afterLoadPreData()



  .controller 'ChatDetailCtrl', ($scope, $stateParams, UserService, UtilsServ, AuthService, WebService, EVENT_PREDATA_LOADED_SUCCESS, $location)->
    afterLoadPreData = ()->
      id = $stateParams.id
      $scope.currentUser.lastChatId = id
      $scope.chat = UserService.getChat id
      if !$scope.chat?
        $location.path('/')
        return false

      $scope.chat.getHistoryMessage().then (messages)->
        $scope.messages = messages

      $scope.chat.resource.unReadCount = 0
      $scope.chat.resource.$update (res)->
        $scope.chat.resource = res

      if $scope.chat.isGroup()
        members = $scope.chat.getMembers()
        if members?
          avatars = (member.getAvatar() for member, i in members when i < 9)
          UtilsServ.combineAvatar avatars, 50, (groupAvatar)->
            if groupAvatar == $scope.chat._recipient.resource.avatar
              return false
            $scope.chat._recipient.resource.avatar = groupAvatar
            $scope.chat._recipient.resource.$update()


    $scope.$on 'new-message', (event, message)->
      if $scope.chat? && message.cid == $scope.chat.getCid()
        $scope.messages.push(message)
        $scope.$apply()
      else
        #其他窗口的消息, 把消息置顶, 并提示未读消息.


    $scope.sendMessage = ()->
      console.log $scope.message
      if $scope.message == ''

      else
        $scope.chat.sendMessage($scope.message)
        $scope.message = ''

    if WebService.isLoadedPreData
      afterLoadPreData()
    $scope.$on EVENT_PREDATA_LOADED_SUCCESS, ()->
      afterLoadPreData()
  .controller 'AccountCtrl', ($scope)->
    $scope.settings = {
      enableFriends: true
    }

  .controller 'ContactsCtrl', ($scope, UserService)->
    $scope.users = UserService.getUsers()


  .controller 'SignInCtrl', ($scope, AuthService, UserResource, UserService, $location)->
    $scope.user = {}
    $scope.error = ''
    $scope.submit = ()->
      AuthService.login $scope.user.email, $scope.user.password, $scope.user.domain
      .then (res)->
        AuthService.saveAccessToken(res.data.accessToken)
        UserResource.getCurrent {}, (userResource)->
          $scope.afterSignIn userResource
          $location.path('/tab/dash')
          $scope.error = ''
      ,
        (res)->
          $scope.error = res.data.message