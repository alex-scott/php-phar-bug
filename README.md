33.phar file contains inside one file test.php

<?php
echo "OK";

index.php just includes this file and we get expected "OK" output in browser.
It works fine on plain PHP without opcache.

With opcache + "opcache.validate_permission=1" configured, we get "OK" on first run,
and error on all following requests. After restart of docker, we get one succesfull
run and then failing again.

To see it:

git clone https://github.com/alex-scott/php-phar-bug
cd php-phar-bug
docker build -t php-bug-test .
docker run -p 80:80 php-bug-test

then open http://localhost/ in browser and refresh
