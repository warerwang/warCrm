angular.module 'crm'
  .service 'MessageResource', ($resource, API_BASE_URL, SessionService)->
    resource = $resource API_BASE_URL + '/message?access-token=:token&cid=:cid', {cid:'@cid',token:'@token'}, {
      get : {method:'GET', isArray:true},
    }

    actions = ['get', 'save', 'update', 'delete', 'query']
    for i of actions
      action = actions[i]
      resource['_' + action] = resource[action]
      resource[action] = (data, success, error)->
        data = angular.extend {}, data || {}, {token: SessionService.accessToken}
        resource['_' + action](data, success, error)
    resource

