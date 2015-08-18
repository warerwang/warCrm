angular.module 'crm'
  .factory 'WebService', ($http, API_BASE_URL, $location, BASE_DOMAIN, $q, UserResource, GlobalService)->
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
    }
    web