build-prod:
	mv www/coffeeScript/app.coffee www/coffeeScript/app.coffee.old
	sed 's/local.gwork.cc/gwork.cc/g' www/coffeeScript/app.coffee.old > www/coffeeScript/app.coffee
	ionic build
	mv www/coffeeScript/app.coffee.old www/coffeeScript/app.coffee

build:
	ionic build