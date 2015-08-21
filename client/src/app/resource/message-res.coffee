angular.module 'crm'
  .service 'MessageResource', ($resource, API_BASE_URL, SessionService)->
    resource = $resource API_BASE_URL + '/message?access-token=:token&cid=:cid', {cid:'@cid',token:'@token'}, {
      get : {method:'GET', isArray:true},
    }
    actions = ['get', 'delete', 'query']
    resource = SessionService.wrapActions( resource, actions )
    resource