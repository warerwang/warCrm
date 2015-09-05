angular.module 'crm'
  .factory 'ConnectService', (SessionService, $location)->
    wsServer = 'ws://'+$location.host()+':2345'
    connect = {
      init: ()->
        websocket = new WebSocket(wsServer)
        websocket.onopen = (evt)->
          console.log("Connected to WebSocket server.")

        websocket.onclose = (evt)->
          console.log('close occured: ' + evt)
          console.log evt

        websocket.onerror = (evt)->
          console.log evt
        @websocket = websocket

      MESSAGE_TYPE : 1    # 收到消息
      BROADCAST_TYPE : 2  # 广播信息
      IQ_TYPE : 3         # 请求的信息
      AUTH_TYPE : 4       # 认证的请求
      PING_TYPE : 5       # PING 心跳检测
    }
    connect.sendMessage = (cid, content, data = [])->
      data = {
        cid : cid
        content : content
        extra : data
        type : this.MESSAGE_TYPE
      }
      jsonData = JSON.stringify(data)
      @websocket.send(jsonData)

    connect.sendBroadcast = (message, data)->
      data = {
        type : this.BROADCAST_TYPE
        message : message
        data : data
      }
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


    connect.close = ()->
      @websocket.close()

    connect