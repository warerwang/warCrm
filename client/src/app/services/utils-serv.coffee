angular.module 'crm'
  .factory 'UtilsServ', ($modal)->
    timer = {}
    Utils = {
      DATE_FORMAT_MMDDYYY : 1,
      htmlEncode : (str)->
        $('<div/>').text(str).html()
      htmlDecode : (str)->
        $('<div/>').html(str).text()
      isEmail : (email) ->
        if value.match(/^[a-zA-Z0-9!#$%&'*+\/=?^_`{|}~-]+(?:\.[a-zA-Z0-9!#$%&'*+\/=?^_`{|}~-]+)*@(?:[a-zA-Z0-9](?:[a-zA-Z0-9-]*[a-zA-Z0-9])?\.)+[a-zA-Z0-9](?:[a-zA-Z0-9-]*[a-zA-Z0-9])?$/)
          true
        else
          false
      confirm : (content, callback)->
        modalInstance = $modal.open {
          templateUrl: 'confirm-modal.html'
          controller: 'ConfirmModalCtrl'
          resolve: {
            content: ()->
              console.log content
              content
          }
        }
        modalInstance.result.then ()->
          callback()
        false



#        $('#yat-confirm .modal-body .modal-body-content').html(content)
#        $('#yat-confirm').modal('show')
#        callbackOverride = ()->
#          $('#yat-confirm').modal('hide')
#          callback()
#        $('#yat-confirm .btn-primary').unbind('click').click(callbackOverride)

      rebound : (key, callback, time)->
        if typeof timer[key] != 'undefined'
          clearTimeout(timer[key])
        timer[key] = setTimeout( ()->
          callback()
        , time)
    }