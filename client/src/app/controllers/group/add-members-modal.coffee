angular.module "crm"
  .controller "addMembersModalCtrl", ($scope, UserService, members, chat, $location, $modalInstance)->
    $scope.users = UserService.getUsers()
    $scope.oldMembersUid = (user.id for user in members)

    $scope.members = []

    $scope.submit = ()->
      chat.addMembers $scope.members, (groupRes)->
        if chat.resource.type == 1
          group = UserService.createGroup groupRes
          
          UserService.openGroupChat group.id, (chat)->
            $modalInstance.close()
            $location.path('/chat/' + chat.id)
        else
          $modalInstance.close()

    $scope.isDisabled = (uid)->
      index = $scope.oldMembersUid.indexOf(uid)
      if index != -1
        return true
      else
        return false

    $scope.isChecked = (user)->
      if $scope.isDisabled(user.id)
        return true
      index = $scope.members.indexOf(user)
      if index != -1
        return true
      else
        return false


    $scope.toggleCheckMember = (user)->
      index = $scope.members.indexOf(user)
      if index > -1
        $scope.members.splice(index, 1)
      else
        $scope.members.push(user)

    $scope.close = ()->
      $modalInstance.dismiss('cancel')