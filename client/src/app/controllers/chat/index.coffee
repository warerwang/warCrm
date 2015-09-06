angular.module "crm"
.controller "ChatCtrl", (
  $scope,
  UserService,
  $stateParams,
  EVENT_PREDATA_LOADED_SUCCESS,
  WebService,
  toastr,
  $location,
  $modal,
  $http,
  API_BASE_URL,
  SessionService,
  $timeout,
  UtilsServ
)->
  id = $stateParams.id
  if id == ''
    $scope.showRight = false
  else
    $scope.showRight = true
  $scope.orderBy = '-getSort()'

  afterLoadPreData = ()->
    UserService.getChats().then (chats)->
      $scope.chats = chats
      $scope.message = ''
      if id != ''
        $scope.currentUser.lastChatId = id
        $scope.chat = UserService.getChat id
        if !$scope.chat?
          $location.path('/')
          return false
        if !$scope.chat.tabActive?
          $scope.chat.tabActive = 1
        $scope.activeFileTab = $scope.chat.tabActive == 1
        $scope.activeMemberTab = $scope.chat.tabActive == 2

        $scope.chat.getHistoryMessage().then (messages)->
          $scope.messages = messages

        $scope.chat.getAttachments().then (attachs)->
          $scope.attachs = attachs

        $scope.chat.resource.unReadCount = 0
        $scope.chat.resource.$update (res)->
          $scope.chat.resource = res
        if $scope.chat.isGroup()
          members = $scope.chat.getMembers()
          if members?
            avatars = (member.getAvatar() for member, i in members when i < 9)
            UtilsServ.combineAvatar avatars, 50, (groupAvatar)->
              if groupAvatar == $scope.chat._recipient.resource.avatar
                return false
              $scope.chat._recipient.resource.avatar = groupAvatar
              $scope.chat._recipient.resource.$update()

      else if $scope.currentUser.lastChatId?
        $location.path('/chat/' + $scope.currentUser.lastChatId)
        return false

  if WebService.isLoadedPreData
    afterLoadPreData()
  $scope.$on EVENT_PREDATA_LOADED_SUCCESS, ()->
    afterLoadPreData()

  $scope.sendMessage = ()->
    if $scope.message == ''
      toastr.warning '不能发送空子符'
    else
      $scope.chat.sendMessage($scope.message)
      $scope.message = ''

  $scope.enterSubmit = (event)->
#    不清楚是10 还是 13了。晕
    if event.keyCode == 10 && event.ctrlKey
      $scope.message += "\n"
      event.preventDefault()
    else if event.keyCode == 13
      $scope.sendMessage()
      event.preventDefault()

  $scope.$on 'new-message', (event, message)->
    if $scope.chat? && message.cid == $scope.chat.getCid()
      $scope.messages.push(message)
      $scope.$apply()
    else
      #其他窗口的消息, 把消息置顶, 并提示未读消息.

  $scope.addMembers = (chat)->
    modalInstance = $modal.open {
      templateUrl: 'add-members-modal.html',
      controller: 'addMembersModalCtrl'
      resolve: {
        members: ()->
          chat.getMembers()
        chat: ()->
          chat
      }
    }
    modalInstance.result.then (resData)->

  $scope.removeChat = (id, event)->
    chat = UserService.getChat id
    index = $scope.chats.indexOf(chat)
    $scope.chats.splice index,1
    chat.resource.$delete()
    if chat.isActive()
      if $scope.chats[0]?
        cid = $scope.chats[0].id
        $location.path('/chat/'+cid)
      else
        $location.path('/chat/')
    event.preventDefault()

  fileToken = ''
  $scope.openFilePicker = ()->
    $timeout ()->
      document.getElementById('file-upload').click()
    ,
      0
    ,
      false
    $http.get(API_BASE_URL+'/user/file-token?access-token='+SessionService.accessToken)
    .success (token)->
      fileToken = token

  $scope.openCodeModal = ()->
    $modal.open {
      templateUrl: 'code-modal.html',
      controller: 'CodeModalCtrl'
      resolve: {
        chat: ()->
          $scope.chat
      }
    }

  $scope.fileNameChanged = (files)->
    fileName = 'chat-attachment-' + id + '-' + (new Date()).valueOf()
    extIndex = files[0].name.lastIndexOf('.')
    if extIndex > 0
      ext = files[0].name.substr(extIndex)
    else
      ext = ''
    fileName += ext
    formData = new FormData()
    formData.append('token', fileToken)
    formData.append('key', fileName)
    formData.append('file', files[0])

    $http.post('http://upload.qiniu.com/', formData, {
      withCredentials: false
      headers: {
        'Content-Type': undefined
      }
      transformRequest: angular.identity
    }).success (res)->
      $scope.chat.sendMessage(res.key, {
        type:'attach',
        data:{
          name: files[0].name
          size    : files[0].size
          key     : res.key
          ext     : ext
          ownerId: $scope.currentUser.id
          chatId : $scope.chat.getCid()
        }
      })
  $scope.showMore = ()->
    $scope.chat.loadMoreMessage().then (messages)->
      $scope.messages = messages
      $timeout ()->
        $scope.$broadcast 'load-history-success'
#        ,
#          0