angular.module 'crm'
.service 'TaskResource', ($resource, API_BASE_URL, SessionService)->
  resource = $resource API_BASE_URL + '/task/:id?access-token=:token', {id: '@id', token:'@token'}, {
    update : {method:'PUT'}
    save : {method:'POST', url:API_BASE_URL + '/task?access-token=:token'},
  }
  actions = ['get', 'delete', 'query', 'update', 'save']
  resource = SessionService.wrapActions( resource, actions )
  resource