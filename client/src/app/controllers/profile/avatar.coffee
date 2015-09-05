angular.module 'crm'
  .controller "ProfileAvatarCtrl", ($scope,
                                    API_BASE_URL,
                                    $http,
                                    SessionService,
                                    $base64
                                    ConnectService)->
    $scope.dupa = "dasdasdas"
    $scope.myCroppedImage = ''
    fileToken = ''
    fileName = ''
    handleFileSelect=(evt)->
      fileName = 'user-avatar-' + $scope.currentUser.id + '.png'
      $http.get(API_BASE_URL+'/user/file-token?key='+fileName+'&access-token='+SessionService.accessToken)
        .success (token)->
          fileToken = token
      file=evt.currentTarget.files[0]
      reader = new FileReader()
      reader.onload = (evt)->
        $scope.$apply ($scope)->
          $scope.myImage=evt.target.result
      reader.readAsDataURL(file)
    angular.element(document.querySelector('#fileInput')).on('change',handleFileSelect)


    $scope.saveAvatar = ()->
      indexD = $scope.myCroppedImage.indexOf(',') + 1
      indexM = $scope.myCroppedImage.indexOf(':') + 1
      indexF = $scope.myCroppedImage.indexOf(';') - indexM
      type = $scope.myCroppedImage.substr(indexM, indexF)
      data = $scope.myCroppedImage.substr(indexD)
      encodedKey = $base64.encode(fileName)
      $http.post('http://upload.qiniu.com/putb64/-1/key/'+encodedKey+'/EncodedMimeType/'+type+'', data, {
        withCredentials: false
        headers: {
          'Content-Type': undefined
          'Authorization' :'UpToken '+fileToken
        }
        transformRequest: angular.identity
      }).success (res)->
        $scope.userRes.$updateAvatar {avatar:res.key}, (resource)->
          $scope.user.resource = resource
          ConnectService.sendBroadcast('user-edit', resource)
#          $scope.setCurrentUser $scope.user