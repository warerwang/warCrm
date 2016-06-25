window.WARPHP_starter = angular.module('starter', ['ionic', 'ngCookies', 'ngResource', 'ui.bootstrap', 'starter.modules'])
  .run ($ionicPlatform)->
    $ionicPlatform.ready ()->
      if (window.cordova && window.cordova.plugins && window.cordova.plugins.Keyboard)
        cordova.plugins.Keyboard.hideKeyboardAccessoryBar(true);
        cordova.plugins.Keyboard.disableScroll(true);

      if (window.StatusBar)
        StatusBar.styleLightContent()
  .config ($stateProvider, $urlRouterProvider)->
    $urlRouterProvider.otherwise('/chat')
  .constant('API_BASE_URL', 'http://www.local.gwork.cc')
  .constant('BASE_DOMAIN', 'local.gwork.cc')
  .constant('PRE_PAGE_COUNT', 10)
  .constant('EVENT_CONFIG_LOADED_SUCCESS', 'config-loaded-success')
  .constant('EVENT_SIGN_IN_SUCCESS', 'sign-in-success')
  .constant('EVENT_PREDATA_LOADED_SUCCESS', 'predata-loaded-success')
  .constant('EVENT_DOMAIN_NOT_FOUND', 'domain-not-found')
  .controller "BaseCtrl", ($scope,
    AuthService,
    $location,
    SessionService,
    ConnectService,
    UserService,
    WebService,
    GlobalService,
    EVENT_CONFIG_LOADED_SUCCESS,
    EVENT_SIGN_IN_SUCCESS,
    EVENT_PREDATA_LOADED_SUCCESS,
    API_BASE_URL,
    UserResource
  ) ->
    $scope.currentUser = null
    $scope.absUrl = $location.absUrl()
    $scope.tab = 'default'
    $scope.setTab = (tab)->
      $scope.tab = tab
    $scope.checkAuth = ()->
      if AuthService.isAuthenticated()
        UserResource.getCurrent {}, (userResource)->
          $scope.afterSignIn userResource
        ,
          ()->
            SessionService.destroy()
      else
        $location.path('/auth')
    $scope.checkAuth()


    #  WebService.loadWebConfig().then (res)->
    #    $scope.domainExist = true
    #    config = res.data
    #    GlobalService.setConfig config
    #    WebService.isLoadConfig = true
    #    $scope.$broadcast EVENT_CONFIG_LOADED_SUCCESS, config
    #
    #  ,
    #  ()->
    #    $scope.domainExist = false
    #    $scope.subDomain = WebService.preDomain
    #    $scope.API_BASE_URL = API_BASE_URL
    #    $location.path('/')


    $scope.setCurrentUser = (user) ->
      $scope.currentUser = user
      AuthService.currentUser = user

    $scope.getIsAuthorized = ()->
      AuthService.isAuthenticated()

#    if $scope.getIsAuthorized()
#      UserResource.getCurrent {}, (userResource)->
#        $scope.afterSignIn userResource
#      ,
#        ()->
#          SessionService.destroy()

    handleNewMessage = (message)->
      cid = message.getChatId()
      chat = UserService.getChat cid
      #会话存在.
      if chat?
        chat.messages.push(message) if chat.messages != null
        chat.resource.lastSenderUid = message.sender
        chat.resource.lastMessage = message.content
        if chat.isActive()
          if message.sender != $scope.currentUser.id
            $scope.haveNewMessage = true
        else
          chat.resource.unReadCount++
          chat.sort = ++UserService.maxChatSort
        $scope.$apply()
      else
        UserService.newMessageChat(
          cid,
          message.isGroupMessage(),
          (chat)->

        )
      $scope.$broadcast('new-message', message)
#      WebService.checkIfSendNotification(message)

    regiesterOnMessage = ()->
      ConnectService.websocket.onmessage = (messageEvent)->
        data = $.parseJSON messageEvent.data
        if data.type == ConnectService.MESSAGE_TYPE
          message = UserService.createMessage data.message
          handleNewMessage(message)

        else if data.type == ConnectService.BROADCAST_TYPE
          #处理广播的消息
          broadcast = 'server-' + data.message
          $scope.$broadcast(broadcast, data.data)
          if !WebService.isLoadedPreData
            return false
          if data.message.indexOf('user-') == 0
            uid = data.data['id']
            user = UserService.getUser uid
            if user?
              if data.message == 'user-remove'
                UserService.removeUser uid
                return false
              $.extend(user.resource, data.data)
              if uid == $scope.currentUser.id
                $scope.setCurrentUser user
            else
              UserService.addNewUser data.data

          $scope.$apply()

        else if data.type == ConnectService.IQ_TYPE

        else if data.type == ConnectService.AUTH_TYPE
          ConnectService.sendAuth SessionService.accessToken
        else if data.type != ConnectService.PING_TYPE
          throw new Error(messageEvent.data)

    $scope.afterSignIn = (resData)->
      currentUser = UserService.createUser resData
      $scope.setCurrentUser currentUser
      $scope.$broadcast EVENT_SIGN_IN_SUCCESS, currentUser
      GlobalService.setConfig {id:resData.did}
      WebService.loadData()
      .then ()->
        ConnectService.init()
        regiesterOnMessage()
        WebService.isLoadedPreData = true
        $scope.$broadcast EVENT_PREDATA_LOADED_SUCCESS, currentUser

    $scope.signOut = ()->
      SessionService.destroy()
      AuthService.currentUser = null
      $location.path('/auth')
      WebService.resetSystem()