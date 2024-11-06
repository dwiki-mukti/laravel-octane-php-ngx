FROM ubuntu:24.04
ARG DEBIAN_FRONTEND=noninteractive

# preinstall php
RUN apt-get update -yqq && apt-get install -yqq software-properties-common > /dev/null

# install php
RUN LC_ALL=C.UTF-8 add-apt-repository ppa:ondrej/php > /dev/null && \
    apt-get update -yqq > /dev/null && apt-get upgrade -yqq > /dev/null

# install php extension
RUN apt-get update -yqq > /dev/null && \
    apt-get install -yqq wget git libxml2-dev systemtap-sdt-dev \
    zlib1g-dev libpcre3-dev libargon2-dev libsodium-dev libkrb5-dev \
    php8.3-cli php8.3-dev libphp8.3-embed php8.3-zip > /dev/null

# install nginx + php-ngx
RUN git clone -b v0.0.29 --single-branch --depth 1 https://github.com/rryqszq4/ngx-php.git > /dev/null
ENV NGINX_VERSION=1.26.0
RUN wget -q http://nginx.org/download/nginx-${NGINX_VERSION}.tar.gz && \
    tar -zxf nginx-${NGINX_VERSION}.tar.gz && \
    cd nginx-${NGINX_VERSION} && \
    export PHP_LIB=/usr/lib && \
    ./configure --user=www --group=www \
    --prefix=/nginx \
    --with-ld-opt="-Wl,-rpath,$PHP_LIB" \
    --add-module=/ngx-php/third_party/ngx_devel_kit \
    --add-module=/ngx-php > /dev/null && \
    make > /dev/null && make install > /dev/null
RUN sed -i "s|opcache.jit=off|;opcache.jit=off|g" /etc/php/8.3/embed/conf.d/10-opcache.ini

# copy app
ENV APP_DIR=app
COPY . /$APP_DIR
COPY ./docker/php-ngx/plugin/Ngx /$APP_DIR/app/Ngx

# install laravel dependencies
COPY --from=composer:2.2 /usr/bin/composer /usr/bin/composer
RUN cd /$APP_DIR && composer install --no-interaction --prefer-dist --no-dev

# multi worker
RUN export WORKERS=$(( 4 * $(nproc) )) && \
    sed -i "s|worker_processes  auto|worker_processes $WORKERS|g" /$APP_DIR/docker/php-ngx/configs/nginx.conf

# launch
EXPOSE 8000
CMD /nginx/sbin/nginx -c /$APP_DIR/docker/php-ngx/configs/nginx.conf
# CMD cd $APP_DIR && php artisan serve --host=0.0.0.0 --port=8000