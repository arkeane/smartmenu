FROM php:fpm-alpine

RUN apk update; \
    apk upgrade;
RUN docker-php-ext-install mysqli
RUN mv $PHP_INI_DIR/php.ini-development $PHP_INI_DIR/php.ini && echo "session.save_path = "/var/tmp/"" >> $PHP_INI_DIR/php.ini