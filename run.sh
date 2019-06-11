#!/bin/bash

./build-phar/build.sh

docker build -t php-bug-test .
docker run -d -p 8011:80 php-bug-test

sleep 3

curl http://localhost:8011/
curl http://localhost:8011/

docker stop $(docker ps -q --filter ancestor=php-bug-test )
