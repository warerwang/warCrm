angular.module "crm"
  .controller 'inviteModalCtrl', ($scope,
                                  $http,
                                  AuthService,
                                  $uibModalInstance,
                                  toastr,
                                  UserResource) ->
    $scope.inviteMembers = [{email:''}]
    $scope.add = ()->
      $scope.inviteMembers.push({email:''})

    $scope.remove = (index)->
      $scope.inviteMembers.splice(index, 1)

    $scope.isEmail = (email)->
      if email != ''
        /^[a-z0-9!#$%&'*+\/=?^_`{|}~.-]+@[a-z0-9]([a-z0-9-]*[a-z0-9])?(\.[a-z0-9]([a-z0-9-]*[a-z0-9])?)*$/i.test(email);
      else
        return true;

    $scope.confirm = ()->
      emails = (item.email for item in $scope.inviteMembers)
      UserResource.inviteUser {emails:emails}, (res)->
        console.log res
      $uibModalInstance.close()

    $scope.close = ()->
      $uibModalInstance.dismiss('cancel')
