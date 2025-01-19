FROM dunglas/frankenphp:latest
WORKDIR /app

COPY . /app

RUN composer install --no-dev --optimize-autoloader

RUN cp $PHP_INI_DIR/php.ini-production $PHP_INI_DIR/php.ini
ENV FRANKENPHP_CONFIG="worker /app/docker/php-franken-worker/bin/worker.php 4"

CMD ["frankenphp", "php-server"]
