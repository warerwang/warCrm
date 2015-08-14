angular.module 'crm'
  .factory 'AuthService', ($http, SessionService, API_BASE_URL)->
    authService = {}
    authService.login = (email, password)->
      $http.get API_BASE_URL + '/user/access-token?email=' + email + '&password=' + password

    authService.signUp = (email, password)->
      $http.get API_BASE_URL + '/user/access-token?email=' + email + '&password=' + password

    authService.loginByAccessToken = (accessToken)->
      $http.get API_BASE_URL + '/user/current?access-token=' + accessToken
      .then (res)->
        res.data

    authService.isAuthenticated = ()->
      !!SessionService.accessToken

    authService.saveAccessToken = (accessToken)->
      SessionService.create(accessToken)

    authService;