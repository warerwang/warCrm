angular.module 'crm'
  .factory 'UserResource', ($http, SessionService, API_BASE_URL, $resource)->
    user = $resource API_BASE_URL + '/user/:id?access-token=' + SessionService.accessToken, {id:'@id'}, {
      get : {method:'GET', isArray:true},
    }