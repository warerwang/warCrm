angular.module "crm"
  .controller "ChatCtrl", ($scope) ->
    $scope.users = [
        {
          name: 'Steven.Li'
          status:1
        },
      {
        name: 'Jeff.Luo'
        status:1
      },
      {
        name: 'Yadong.w'
        status:0
      },
      {
        name: '333',
        status: 1
      },
      {
        name: 'Jeff.Luo'
        status:1
      },
      {
        name: 'Yadong.w'
        status:0
      },
      {
        name: '333',
        status: 1
      },
      {
        name: 'Jeff.Luo'
        status:1
      },
      {
        name: 'Yadong.w'
        status:0
      },
      {
        name: '333',
        status: 1
      },
      {
        name: 'Jeff.Luo'
        status:1
      },
      {
        name: 'Yadong.w'
        status:0
      },
      {
        name: '333',
        status: 1
      },
      {
        name: 'Jeff.Luo'
        status:1
      },
      {
        name: 'Yadong.w'
        status:0
      },
      {
        name: '333',
        status: 1
      },
      {
        name: 'Jeff.Luo'
        status:1
      },
      {
        name: 'Yadong.w'
        status:0
      },
      {
        name: '333',
        status: 1
      },
      {
        name: 'Jeff.Luo'
        status:1
      },
      {
        name: 'Yadong.w'
        status:0
      },
      {
        name: '333',
        status: 1
      },
      {
        name: 'Jeff.Luo'
        status:1
      },
      {
        name: 'Yadong.w'
        status:0
      },
      {
        name: '333',
        status: 1
      },
      {
        name: 'Jeff.Luo'
        status:1
      },
      {
        name: 'Yadong.w'
        status:0
      },
      {
        name: '333',
        status: 1
      },
      {
        name: 'Jeff.Luo'
        status:1
      },
      {
        name: 'Yadong.w'
        status:0
      },
      {
        name: '333',
        status: 1
      },
      {
        name: 'Jeff.Luo'
        status:1
      },
      {
        name: 'Yadong.w'
        status:0
      },
      {
        name: '333',
        status: 1
      },
      {
        name: 'Jeff.Luo'
        status:1
      },
      {
        name: 'Yadong.w'
        status:0
      },
      {
        name: '333',
        status: 1
      }
      ]
    $scope.chat = null;
    $scope.chatWith = (index)->
      $scope.chat = $scope.users[index]

