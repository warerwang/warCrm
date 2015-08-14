angular.module 'crm'
.service 'SessionService', ($cookieStore)->
    this.accessToken = $cookieStore.get 'access_token';

    this.create = (accessToken)->
      this.accessToken = accessToken
      $cookieStore.put 'access_token', accessToken

    this.destroy = ()->
      this.accessToken = null
      $cookieStore.remove 'access_token'

    this;