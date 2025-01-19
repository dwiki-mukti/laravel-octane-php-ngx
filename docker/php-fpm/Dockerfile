FROM php:8.3-fpm-alpine AS base

RUN apk add bash
RUN apk add libpng-dev
RUN apk add libjpeg-turbo-dev 
RUN apk add freetype-dev
RUN apk add libzip-dev
# RUN apk add zlib-dev
RUN apk add libxml2-dev
RUN apk add oniguruma-dev
RUN apk add curl git
RUN apk add libwebp-dev

RUN docker-php-ext-configure gd --with-freetype --with-jpeg --with-webp --enable-gd
RUN docker-php-ext-install gd pdo pdo_mysql mbstring xml zip opcache

WORKDIR /var/www
COPY . .
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache

COPY --from=composer:2.2 /usr/bin/composer /usr/bin/composer
RUN composer install --no-dev --optimize-autoloader --prefer-dist

COPY --from=nginx:alpine /usr/sbin/nginx /usr/sbin/nginx
COPY --from=nginx:alpine /etc/nginx /etc/nginx
COPY --from=nginx:alpine /usr/share/nginx /usr/share/nginx

COPY ./docker/php-fpm/config/default.conf /etc/nginx/conf.d/
COPY ./docker/php-fpm/config/nginx.conf /etc/nginx/
RUN addgroup -g 101 nginx && adduser -u 101 -G nginx -D nginx
RUN mkdir -p /var/log/nginx
RUN mkdir -p /var/cache/nginx/client_temp

EXPOSE 80

CMD php-fpm & nginx -g "daemon off;"
