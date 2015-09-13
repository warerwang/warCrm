angular.module 'crm'
.service 'CommentResource', ($resource, API_BASE_URL, SessionService)->
  resource = $resource API_BASE_URL + '/comment/:id?access-token=:token', {id: '@id', token:'@token'}, {
#    update : {method:'PUT'}
    save : {method:'POST', url:API_BASE_URL + '/comment?access-token=:token'},
  }
  actions = ['delete', 'query', 'save']
  resource = SessionService.wrapActions( resource, actions )
  resource