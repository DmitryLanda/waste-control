FROM php:8-fpm-alpine

RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" && \
    php composer-setup.php --quiet && \
    rm composer-setup.php && \
    mv composer.phar /usr/local/bin/composer

RUN addgroup -S application && \
    adduser --disabled-password -u 1000 -S application -G application

USER application
WORKDIR /app

EXPOSE 9000
CMD ["php-fpm"]