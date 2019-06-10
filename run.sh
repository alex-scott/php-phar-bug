#!/bin/bash

docker build -t php-bug-test .
docker run -p 80:80 php-bug-test
