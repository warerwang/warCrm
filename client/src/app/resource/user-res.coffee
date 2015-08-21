angular.module 'crm'
  .factory 'UserResource', ($http, SessionService, API_BASE_URL, $resource)->
    resource = $resource API_BASE_URL + '/user/:id?did=:did&access-token=:token', {id:'@id', did:'@did', token:'@token'}, {
      get : {method:'GET', isArray:true},
      save : {method:'POST', url:API_BASE_URL + '/user?did=:did&access-token=:token'},
      update : {method:'PUT'}
    }
    actions = ['get','update', 'delete', 'query', 'save']
    resource = SessionService.wrapActions( resource, actions )
    resource

