FROM php:7.3-fpm

WORKDIR /var/www

RUN docker-php-ext-install pdo_mysql mbstring \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
    && groupadd -g 1000 www \
    && useradd -u 1000 -ms /bin/bash -g www www

COPY --chown=www:www . /var/www

RUN composer install

USER www

EXPOSE 9000
CMD ["php-fpm"]
