angular.module 'crm'
  .service 'AttachResource', ($resource, API_BASE_URL, SessionService)->
    resource = $resource API_BASE_URL + '/attach/:id?access-token=:token&cid=:cid', {id: '@id', token:'@token', cid:'@cid'}, {
      update : {method:'PUT'}
    }
    actions = ['get', 'delete', 'query', 'update']
    resource = SessionService.wrapActions( resource, actions )
    resource