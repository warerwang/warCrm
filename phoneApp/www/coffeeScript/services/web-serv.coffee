WARPHP_starter
.factory 'WebService', ($http,
                        API_BASE_URL,
                        $location,
                        $rootScope,
                        BASE_DOMAIN,
                        $q,
                        UserResource,
                        GlobalService,
                        NotificationService,
                        AuthService,
                        ConnectService
)->
  loadedCount = 0
  preDataCount = 1
  web = {
    isLoadConfig : false
    isLoadedPreData: false
    preData:{
      users : null
    }
    loadWebConfig: ()->
      $http.get(API_BASE_URL + '/config/'+ GlobalService.preDomain)
    loadData: ()->
      _this = this
      #加载用户信息
      deferred = $q.defer()

      deferred.promise.then ()->
        loadedCount = 0
        this.preData
      ,
      (data)->
        data

      UserResource.query {did:GlobalService.config.id},
      (users)->
        _this.preData.users = users
        if ++loadedCount == preDataCount
          deferred.resolve()
      ,
      (data)->
        deferred.reject(data)

      deferred.promise


    checkIfSendNotification: (message)->
      if !document.hidden?
        return false

      if AuthService.currentUser.id == message.getSender().id
        return false

      this.playSound('ding-dong')
      NotificationService.send('新消息', message.getContent(), message.getSender().getAvatar(), ()->
        if message.cid.indexOf('-') > -1
          cids = message.cid.split('-')
          chatId = (cid for cid in cids when cid != AuthService.currentUser.id)
          $location.path('/chat/' + chatId)
        else
          $location.path('/chat/' + message.cid)
        if !$rootScope.$$phase?
          $rootScope.$apply()
      )

    playSound: (type)->
      filePath = '/assets/sounds/'
      $("#sounds").html('<audio autoplay="autoplay"><source src="' +
          filePath +
          type +
          '.mp3" type="audio/mpeg" /><embed hidden="true" autostart="true" loop="false" src="' +
          filePath +
          type +
          '.mp3" /></audio>')

    resetSystem : ()->
      @isLoadConfig = false
      @isLoadedPreData = false
      ConnectService.close()
  }
  web