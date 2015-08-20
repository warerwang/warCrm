angular.module 'crm'
  .factory 'NotificationService', ()->
    n = {
      send: (title, content, icon, callback)->
        if !icon?
          icon = '/logo.png'
        notification = new Notification title, {
            icon: icon
            body: content
          }
        if callback?
          notification.onclick = ()->
            callback()

      isDenied: ()->
        Notification.permission == 'denied'

      isAllow: ()->
        Notification.permission == 'granted'

      isDefault: ()->
        Notification.permission == 'default'

      checkSupport: ()->
        if Notification
          true
        else
          false

      requestPermission: ()->
        Notification.requestPermission (permission)->
          Notification.permission = permission
    }
    n

