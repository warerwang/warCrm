angular.module 'crm'
  .factory 'ConnectService', (SessionService)->
    wsServer = 'ws://127.0.0.1:2345';


#    websocket.onmessage = (messageEvent)->
#      data = $.parseJSON messageEvent.data
#      if data.type == connect.MESSAGE_TYPE
##        $scope.$broadcast('dataloaded');
#        console.log(data)
#      else if data.type == connect.BROADCAST_TYPE
#
#      else if data.type == connect.IQ_TYPE
#
#      else if data.type == connect.AUTH_TYPE
#        connect.sendAuth SessionService.accessToken
#      else
#        throw new Error(messageEvent)

    connect = {
      init: ()->
        websocket = new WebSocket(wsServer)
        websocket.onopen = (evt)->
          console.log("Connected to WebSocket server.")

        websocket.onclose = (evt)->
          console.log('Error occured: ' + evt.data)

        websocket.onerror = (evt)->
          console.log evt
        @websocket = websocket

      MESSAGE_TYPE : 1    # 收到消息
      BROADCAST_TYPE : 2  # 广播信息
      IQ_TYPE : 3         # 请求的信息
      AUTH_TYPE : 4       # 认证的请求
    }
    connect.sendMessage = (cid, content, data)->
      data = {
        cid : cid
        content : content
        data : data
        type : this.MESSAGE_TYPE
      }
      jsonData = JSON.stringify(data)
      @websocket.send(jsonData)

    connect.sendBroadcast = (data)->
      data.type = this.BROADCAST_TYPE
      jsonData = JSON.stringify(data)
      @websocket.send(jsonData)

    connect.sendIq = (data)->
      data.type = this.MESSAGE_TYPE
      jsonData = JSON.stringify(data)
      @websocket.send(jsonData)

    connect.sendAuth = (accessToken)->
      data = {
        accessToken: accessToken
        type : this.AUTH_TYPE
      }
      jsonData = JSON.stringify(data)
      @websocket.send(jsonData)
      
    connect