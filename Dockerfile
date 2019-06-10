FROM php:7.3.6-apache-stretch

# Override with custom opcache settings
COPY config/opcache.ini /usr/local/etc/php/conf.d

COPY *.php /var/www/html/
COPY *.phar /var/www/html/
