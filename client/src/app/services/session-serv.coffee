angular.module 'crm'
.service 'SessionService', ($cookieStore)->
  this.accessToken = $cookieStore.get 'accessToken'

  this.create = (accessToken)->
    this.accessToken = accessToken
    $cookieStore.put 'accessToken', accessToken

  this.destroy = ()->
    this.accessToken = null
    $cookieStore.remove 'accessToken'

  this