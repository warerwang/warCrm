WARPHP_starter
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

      combineAvatar : (srcs, size, callback)->
        count = srcs.length
        if count <2 || count > 9
          return false
        if !size?
          size = 50
        canvas = document.createElement("canvas")
        ctx = canvas.getContext("2d")
        canvas.width = size
        canvas.height = size
        ctx.fillStyle = "#ffffff";
        ctx.fillRect(0, 0, size, size)
        locs = []
        pendingCount = count
        switch count
          when 2 then locs = [
              [0, size/4], [size/2, size/4]
            ]
          when 3 then locs = [
              [size/4, 0],
              [0, size/2], [size/2, size/2]
            ]
          when 4 then locs = [
            [0, 0]     , [size/2, 0],
            [0, size/2], [size/2, size/2]
          ]
          when 5 then locs = [
            [size/3, 0],
            [0, size/3], [size/3, size/3], [size/3*2, size/3]
          ,[size/3, size/3*2]
          ]
          when 6 then locs = [
            [size/3, 0],
            [0, size/3], [size/3, size/3], [size/3*2, size/3],
            [size/6, size/3*2], [size/2, size/3*2]
          ]
          when 7 then locs = [
            [size/6, 0],[size/2, 0],
            [0, size/3], [size/3, size/3], [size/3*2, size/3],
            [size/6, size/3*2], [size/2, size/3*2]
          ]
          when 8 then locs = [
            [size/6, 0],[size/2, 0],
            [0, size/3], [size/3, size/3], [size/3*2, size/3],
            [0, size/3*2], [size/3, size/3*2], [size/3*2, size/3*2]
          ]
          when 9 then locs = [
            [0, 0], [size/3, 0], [size/3*2, 0],
            [0, size/3], [size/3, size/3], [size/3*2, size/3],
            [0, size/3*2], [size/3, size/3*2], [size/3*2, size/3*2]
          ]
        if count > 4
          imageWidth = size/3
        else
          imageWidth = size/2

        onDrawComplete = (pendingCount)->
          if pendingCount == 0
            callback(canvas.toDataURL("image/png"))

        $.each srcs, (k, v)->
          img = new Image()
          img.crossOrigin = '*'
          img.src = v
          img.onload = ()->
            loc = locs[k]
            ctx.drawImage(img, loc[0], loc[1], imageWidth, imageWidth)
            onDrawComplete(--pendingCount)

    }