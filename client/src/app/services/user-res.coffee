angular.module 'crm'
  .factory 'UserResource', ($http, SessionService, API_BASE_URL, $resource)->
    user = $resource API_BASE_URL + '/user/:id?did=:did&access-token=' + SessionService.accessToken, {id:'@id', did:'@did'}, {
      get : {method:'GET', isArray:true},
      update : {method:'PUT'}
    }