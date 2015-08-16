angular.module 'crm'
  .service 'MessageResource', ($resource, API_BASE_URL, SessionService)->
    message = $resource API_BASE_URL + '/message?access-token=' + SessionService.accessToken + '&cid=:cid', {cid:'@cid'}, {
      get : {method:'GET', isArray:true},
    }