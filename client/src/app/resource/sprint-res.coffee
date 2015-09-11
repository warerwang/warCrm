angular.module 'crm'
.service 'SprintResource', ($resource, API_BASE_URL, SessionService)->
  resource = $resource API_BASE_URL + '/sprint/:id?access-token=:token&pid=:pid', {id: '@id', token:'@token', pid:'@pid'}, {
    update : {method:'PUT'}
    save : {method:'POST', url:API_BASE_URL + '/sprint?access-token=:token'},
  }
  actions = ['get', 'delete', 'query', 'update', 'save']
  resource = SessionService.wrapActions( resource, actions )
  resource