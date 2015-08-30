angular.module 'crm'
  .service 'MessageResource', ($resource, API_BASE_URL, SessionService)->
    resource = $resource API_BASE_URL + '/message?access-token=:token&cid=:cid&id=:id', {cid:'@cid',token:'@token', id:'@id'}, {
      get : {method:'GET', isArray:true},
    }
    actions = ['get', 'delete', 'query']
    resource = SessionService.wrapActions( resource, actions )
    resource