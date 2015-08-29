angular.module "crm"
  .filter 'nl2br', ()->
    span = document.createElement('span');
    return (input)->
      if !input?
        reutrn ''
      lines = input.split('\n')
      newLines = for line in lines
        span.innerText = line
        span.textContent = line
        span.innerHTML

      return newLines.join('<br />')