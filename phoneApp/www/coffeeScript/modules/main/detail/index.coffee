angular.module('starter.modules.main.detail', [])

.config ($stateProvider, $urlRouterProvider)->
  $stateProvider.state('chat-detail', {
    url: '/chat/:id',
    templateUrl: 'coffeeScript/modules/main/detail/index.html',
    controller: 'ChatDetailCtrl'
  })
.controller 'ChatDetailCtrl', ($scope, $stateParams, UserService, UtilsServ, AuthService, WebService, EVENT_PREDATA_LOADED_SUCCESS, $location, $ionicNavBarDelegate, $ionicScrollDelegate, $timeout)->
  $ionicNavBarDelegate.showBackButton(true);
  id = null
  $scope.haveNewMessage = false
  afterLoadPreData = ()->
    id = $stateParams.id
    $scope.currentUser.lastChatId = id
    $scope.chat = UserService.getChat id
    if !$scope.chat?
      $location.path('/')
      return false

    $scope.chat.getHistoryMessage().then (messages)->
      $scope.messages = messages
      $ionicScrollDelegate.scrollBottom()

    if $scope.chat.resource.unReadCount != 0
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
    cid = message.getChatId()
    if id == cid
      $scope.chat.resource.unReadCount = 0
      if message.sender == $scope.currentUser.id
        $ionicScrollDelegate.scrollBottom()
      else
        height = $('ion-content .scroll:visible').height() + 20
        scrollPos = $ionicScrollDelegate.getScrollPosition()
        scrollTop = scrollPos.top + $('ion-content:visible').height() + 92
        if height-scrollTop > 80
          $scope.haveNewMessage = true
        else
          $ionicScrollDelegate.scrollBottom()



  $scope.showMore = ()->
    console.log "show more"
    $scope.chat.loadMoreMessage().then (messages)->
      $scope.messages = messages


  $scope.sendMessage = ()->
    if $scope.message
      $scope.chat.sendMessage($scope.message)
    $scope.message = ''

  $scope.enterSubmit = (event)->
    console.log event.keyCode
    if event.keyCode == 13
      $scope.sendMessage()
      event.preventDefault()

  $scope.isSelf = (message)->
    message.sender == $scope.currentUser.id

  if WebService.isLoadedPreData
    afterLoadPreData()
  $scope.$on EVENT_PREDATA_LOADED_SUCCESS, ()->
    afterLoadPreData()