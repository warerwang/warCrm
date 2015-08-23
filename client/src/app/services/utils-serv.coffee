angular.module 'crm'
  .factory 'UtilsServ', ($modal)->
    timer = {}
    Utils = {
      DATE_FORMAT_MMDDYYY : 1,
      htmlEncode : (str)->
        $('<div/>').text(str).html()
      htmlDecode : (str)->
        $('<div/>').html(str).text()
      confirm : (content, callback)->
        modalInstance = $modal.open {
          templateUrl: 'confirm-modal.html'
          controller: 'ConfirmModalCtrl'
          resolve: {
            content: ()->
              content
          }
        }
        modalInstance.result.then ()->
          callback()
        false


      rebound : (key, callback, time)->
        if typeof timer[key] != 'undefined'
          clearTimeout(timer[key])
        timer[key] = setTimeout( ()->
          callback()
        , time)
    }