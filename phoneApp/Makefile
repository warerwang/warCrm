build-prod:
	mv www/js/app.js www/js/app.js.old
	sed 's/local.gwork.cc/gwork.cc/g' www/js/app.js.old > www/js/app.js
	ionic build
	mv www/js/app.js.old www/js/app.js

build:
	ionic build