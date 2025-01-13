# Stage pertama: Menggunakan image php:8.3-fpm-alpine sebagai base image
FROM php:8.3-fpm-alpine AS base

# Install dependensi yang diperlukan untuk Laravel
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

# Stage kedua: Meng-copy Composer dari image composer:2.2
FROM composer:2.2 AS composer

# Stage ketiga: Meng-copy Nginx dari image nginx:alpine
FROM nginx:alpine AS nginx

# Stage keempat: Menggabungkan semua komponen dari stage sebelumnya
FROM base

# Copy Composer dari image composer:2.2
COPY --from=composer:2.2 /usr/bin/composer /usr/bin/composer

# Copy Nginx dari image nginx:alpine
COPY --from=nginx:alpine /usr/sbin/nginx /usr/sbin/nginx
COPY --from=nginx:alpine /etc/nginx /etc/nginx
COPY --from=nginx:alpine /usr/share/nginx /usr/share/nginx

# Salin file Laravel ke dalam container
WORKDIR /var/www
COPY . .

# Install dependensi Laravel menggunakan Composer
RUN composer install --no-dev --optimize-autoloader --prefer-dist

# Set permission untuk folder storage dan bootstrap/cache
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache

# Salin konfigurasi Nginx ke dalam container
COPY ./docker/php-fpm/config/default.conf /etc/nginx/conf.d/
COPY ./docker/php-fpm/config/nginx.conf /etc/nginx/

# Tambahkan user nginx ke dalam container
RUN addgroup -g 101 nginx && adduser -u 101 -G nginx -D nginx

# Membuat direktori untuk log Nginx
RUN mkdir -p /var/log/nginx

# Buat direktori cache dan atur izin
RUN mkdir -p /var/cache/nginx/client_temp

# Expose port 80 untuk Nginx
EXPOSE 80

# Jalankan PHP-FPM dan Nginx di background
CMD php-fpm & nginx -g "daemon off;"
