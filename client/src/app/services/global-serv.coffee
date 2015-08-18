angular.module 'crm'
  .service 'GlobalService', ()->
    this.config = null
    this.setConfig = (config)->
      @config = config
    this



