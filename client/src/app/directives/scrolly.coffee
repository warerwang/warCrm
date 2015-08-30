angular.module "crm"
  .directive 'scrolly', ()->
    {
      restrict: 'A',
      link: (scope, element, attrs)->
        raw = element[0];
        console.log('loading directive')

        element.bind 'scroll', ()->
          if (raw.scrollTop < 50)
            scope.$apply attrs.scrolly
    }