WARPHP_starter
  .service 'GlobalService', ($location, BASE_DOMAIN)->
    this.config = null
    this.setConfig = (config)->
      @config = config


    host = $location.$$host
    index = host.length - BASE_DOMAIN.length - 1
    this.preDomain = host.substr(0, index).toLowerCase()
    this



