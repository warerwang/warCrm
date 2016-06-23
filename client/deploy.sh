#!/usr/bin
host=`php -r 'echo parse_ini_file("./server.conf")["host"];'`
user=`php -r 'echo parse_ini_file("./server.conf")["user"];'`
port=`php -r 'echo parse_ini_file("./server.conf")["port"];'`
path=`php -r 'echo parse_ini_file("./server.conf")["port"];'`
rm -rf .tmp/*
mv src/app/index.coffee src/app/index.coffee.old
sed 's/local.gwork.cc/gwork.cc/g' src/app/index.coffee.old > src/app/index.coffee
gulp build
tar czf client_upload.tar.gz dist
cp -r src/app/index.coffee.old src/app/index.coffee
rm src/app/index.coffee.old
scp -P $port client_upload.tar.gz $user@$host:$path
rm client_upload.tar.gz
ssh $user@$host -p $port