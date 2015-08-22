angular.module 'crm'
  .service 'ChatResource', ($resource, API_BASE_URL, SessionService)->
    resource = $resource API_BASE_URL + '/chat/:id?access-token=:token', {id: '@id', token:'@token'}, {
      update : {method:'PUT'}
    }
    actions = ['get', 'delete', 'query', 'update']
    resource = SessionService.wrapActions( resource, actions )
    resource