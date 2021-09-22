FROM php:8-fpm-alpine

RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" && \
    php composer-setup.php --quiet && \
    rm composer-setup.php && \
    mv composer.phar /usr/local/bin/composer

RUN addgroup -S application && \
    adduser --disabled-password -u 1000 -S application -G application

RUN chown application:application /usr/local/bin/composer

RUN set -ex && apk --no-cache add postgresql-dev
RUN docker-php-ext-install pdo pdo_pgsql

USER application
WORKDIR /app

EXPOSE 9000
CMD ["php-fpm"]