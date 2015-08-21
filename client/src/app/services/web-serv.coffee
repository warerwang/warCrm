angular.module 'crm'
  .factory 'WebService', ($http, API_BASE_URL, $location, BASE_DOMAIN, $q, UserResource, GlobalService, NotificationService, AuthService, ConnectService)->
    host = $location.$$host
    index = host.length - BASE_DOMAIN.length - 1
    preDomain = host.substr(0, index).toLowerCase()
    loadedCount = 0
    preDataCount = 1
    web = {
      isLoadConfig : false
      isLoadedPreData: false
      preData:{
        users : null
      }
      preDomain: preDomain
      loadWebConfig: ()->
        $http.get(API_BASE_URL + '/config/'+ preDomain)
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

        UserResource.get {did:GlobalService.config.id},
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

        NotificationService.send('新消息', message.getContent(), message.getSender().getAvatar(), ()->
            $location.path('/chat/' + message.cid)
        )

      resetSystem : ()->
        @isLoadConfig = false
        @isLoadedPreData = false
        ConnectService.close()
    }
    web