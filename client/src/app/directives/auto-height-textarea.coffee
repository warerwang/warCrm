angular.module "crm"
  .directive 'autoHeightTextarea', ($timeout)->
    {
      restrict: 'A'
      link: (scope, element, attr)->
        element.keydown ()->
          $timeout ()->
            $(".chat-activity-list").css('bottom',$("#message-input2").height() + 40)
            $("#message-form").height($("#message-input2").height() + 22)
          ,
            0
          ,
            false
    }