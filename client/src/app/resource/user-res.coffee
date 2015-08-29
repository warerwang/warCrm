angular.module 'crm'
  .factory 'UserResource', ($http, SessionService, API_BASE_URL, $resource)->
    resource = $resource API_BASE_URL + '/user/:id?did=:did&access-token=:token', {id:'@id', did:'@did', token:'@token'}, {
      get : {method:'GET', isArray:true},
      save : {method:'POST', url:API_BASE_URL + '/user?did=:did&access-token=:token'},
      update : {method:'PUT'}
      query : {method:'GET', isArray:false},
      updatePassword : {method:'POST', url:API_BASE_URL + '/user/update-password?access-token=:token'}
      updateAvatar : {method:'POST', url:API_BASE_URL + '/user/update-avatar?access-token=:token'}
    }
    actions = ['get','update', 'delete', 'query', 'save', 'updatePassword', 'updateAvatar']
    resource = SessionService.wrapActions( resource, actions )
    resource

