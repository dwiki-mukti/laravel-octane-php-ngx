# Use the official PHP image as a base
FROM php:8.3-fpm-alpine
ENV APP_DIR="/var/www"

# Install Composer
COPY --from=composer:2.2 /usr/bin/composer /usr/bin/composer

# Install extension
RUN apk --no-cache add libzip-dev
RUN apk --no-cache add libjpeg-turbo-dev
RUN apk --no-cache add libpng-dev
RUN apk --no-cache add libxml2-dev
RUN apk --no-cache add libwebp-dev
RUN apk --no-cache add freetype-dev
RUN docker-php-ext-configure gd --with-freetype --with-jpeg --with-webp --enable-gd

RUN apk --no-cache add php-gd
RUN apk --no-cache add php-dom 
RUN apk --no-cache add php-fileinfo
RUN apk --no-cache add php-session
RUN apk --no-cache add php-tokenizer
RUN apk --no-cache add php-xml
RUN apk --no-cache add php-simplexml
RUN apk --no-cache add php-xmlwriter
RUN apk --no-cache add php-xmlreader
RUN apk --no-cache add php-pdo

# Clear cache
RUN rm -rf /var/cache/apk/*

# Install PHP extensions
RUN docker-php-ext-install gd
RUN docker-php-ext-install zip

# Driver DB connection
# RUN apk --no-cache add postgresql-dev
# RUN apk --no-cache add php-pgsql
# RUN apk --no-cache add php-pdo_pgsql

# RUN docker-php-ext-install pgsql
# RUN docker-php-ext-install pdo_pgsql

# Set working directory
WORKDIR $APP_DIR

# Copy existing application directory contents
COPY . .

# Install dependensi Laravel
RUN composer install --no-interaction --prefer-dist

# Copy existing application directory permissions
COPY --chown=www-data:www-data . $APP_DIR

# Change current user to www
USER www-data

# Expose the container's port
EXPOSE 8000

# Define the command to run when the container starts
CMD php artisan serve --host=0.0.0.0 --port=8000
