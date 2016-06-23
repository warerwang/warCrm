WARPHP_starter
  .factory 'AuthService', ($http, SessionService, API_BASE_URL, UserResource, GlobalService)->
    authService = {}
    authService.currentUser = null
    authService.login = (email, password, domain)->
      if !domain?
        domain = GlobalService.preDomain
      $http.get API_BASE_URL + '/user/access-token?email=' + email + '&password=' + password + '&domain=' + domain

    authService.signUp = (email, password)->
      $http.get API_BASE_URL + '/user/access-token?email=' + email + '&password=' + password

    authService.isAuthenticated = ()->
      !!SessionService.accessToken

    authService.saveAccessToken = (accessToken)->
      SessionService.create(accessToken)

    authService