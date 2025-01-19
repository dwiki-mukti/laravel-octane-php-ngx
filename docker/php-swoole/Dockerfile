FROM phpswoole/swoole:5.1-php8.3

RUN docker-php-ext-install pcntl

WORKDIR /app

COPY . /app
RUN chown -R www-data:www-data /app

ENTRYPOINT ["php", "artisan", "octane:start", "--server=swoole", "--port=8000", "--host=0.0.0.0"]
