angular.module "crm"
  .directive 'hightLight', ($timeout)->
    {
      restrict: 'A'
      link    :  (scope, element, attr)->
        $timeout ()->
          hljs.highlightBlock(element[0])
        ,
          0
        ,
          false
    }