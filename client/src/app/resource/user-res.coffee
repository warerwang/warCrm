angular.module 'crm'
  .factory 'UserResource', ($http, SessionService, API_BASE_URL, $resource)->
    resource = $resource API_BASE_URL + '/user/:id?did=:did&access-token=:token', {id:'@id', did:'@did', token:'@token'}, {
      get : {method:'GET', isArray:true},
      save : {method:'POST', url:API_BASE_URL + '/user?did=:did&access-token=:token'},
      update : {method:'PUT'}
    }
    actions = ['get', 'save', 'update', 'delete', 'query']
    for i of actions
      action = actions[i]
      resource['_' + action] = resource[action]
      resource[action] = (data, success, error)->
        data = angular.extend {}, data || {}, {token: SessionService.accessToken}
        resource['_' + action](data, success, error)
    resource