WARPHP_starter
.service 'SessionService', ($cookieStore)->
  this.tokenWrapper = ( resource, action )->
    _this = this
    resource['_' + action] = resource[action]
    resource[action] = (data, a2, a3, a4)->
      data = angular.extend({}, data, {token: _this.accessToken})
      resource['_' + action](data, a2, a3, a4)
    resource

  this.accessToken = $cookieStore.get 'accessToken'

  this.create = (accessToken)->
    this.accessToken = accessToken
    $cookieStore.put 'accessToken', accessToken

  this.destroy = ()->
    this.accessToken = null
    $cookieStore.remove 'accessToken'


  this.wrapActions = ( resource, actions )->
    wrappedResource = resource
    this.tokenWrapper wrappedResource, action for action in actions
    wrappedResource
  this