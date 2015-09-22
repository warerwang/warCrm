WARPHP_starter
  .controller 'DashCtrl', ($scope, UserResource, UserService, EVENT_PREDATA_LOADED_SUCCESS, WebService)->
    afterLoadPreData = ()->
      UserResource.getDashboard {}, (data)->
        $scope.projects = (UserService.createProject project for project in data.projects)
        $scope.tasks = (UserService.createTask task for task in data.tasks)
        console.log $scope.projects
    if WebService.isLoadedPreData
      afterLoadPreData()
    $scope.$on EVENT_PREDATA_LOADED_SUCCESS, ()->
      afterLoadPreData()






  .controller 'ChatsCtrl', ($scope)->
    console.log 111
#    $scope.chats = Chats.all()
#    $scope.remove = (chat)->
#      Chats.remove(chat)



  .controller 'ChatDetailCtrl', ($scope, $stateParams, Chats)->
    $scope.chat = Chats.get $stateParams.chatId


  .controller 'AccountCtrl', ($scope)->
    $scope.settings = {
      enableFriends: true
    }

  .controller 'ContactsCtrl', ($scope)->
    console.log '22222'


  .controller 'SignInCtrl', ($scope, AuthService, UserResource, UserService, $location)->
    $scope.user = {}
    $scope.error = ''
    console.log $scope.absUrl
    $scope.submit = ()->
      AuthService.login $scope.user.email, $scope.user.password
      .then (res)->
        AuthService.saveAccessToken(res.data.accessToken)
        UserResource.getCurrent {}, (userResource)->
          $scope.afterSignIn userResource
          $location.path('/tab/dash')
          $scope.error = ''
      ,
        (res)->
          $scope.error = res.data.message