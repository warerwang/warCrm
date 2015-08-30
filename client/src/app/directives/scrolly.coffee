angular.module "crm"
  .directive 'scrolly', ()->
    scrollHeight = ''
    isLoading = false
    {
      restrict: 'A',
      link: (scope, element, attrs)->
        raw = element[0];

        element.bind 'scroll', ()->
          if raw.scrollTop < 20
            if isLoading
              return
            isLoading = true
            scrollHeight = raw.scrollHeight
            scope.$apply attrs.scrolly

        scope.$on 'load-history-success', ()->
          isLoading = false
          if raw.scrollHeight == scrollHeight
            element.children().first().html('历史消息加载完毕.')
            element.unbind 'scroll'
          else
            $(raw).scrollTop(raw.scrollHeight - scrollHeight)

    }