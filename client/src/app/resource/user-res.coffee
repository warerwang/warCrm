angular.module 'crm'
  .factory 'UserResource', ($http, SessionService, API_BASE_URL, $resource)->
    resource = $resource API_BASE_URL + '/user/:id?did=:did&access-token=:token', {id:'@id', did:'@did', token:'@token'}, {
      save : {method:'POST', url:API_BASE_URL + '/user?did=:did&access-token=:token'},
      update : {method:'PUT'}
      updatePassword : {method:'POST', url:API_BASE_URL + '/user/update-password?access-token=:token'}
      updateAvatar : {method:'POST', url:API_BASE_URL + '/user/update-avatar?access-token=:token'}
      inviteUser : {method:'POST', url:API_BASE_URL + '/user/invite-user?access-token=:token'}
      getCurrent : {method: "GET", url:API_BASE_URL + '/user/current?access-token=:token'}
    }
    actions = ['get','update', 'delete', 'query', 'save', 'updatePassword', 'updateAvatar', 'inviteUser', 'getCurrent']
    resource = SessionService.wrapActions( resource, actions )
    resource

