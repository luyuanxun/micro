FROM php:7.3.4-fpm-stretch

# Version
ENV PHPREDIS_VERSION 4.3.0
ENV SWOOLE_VERSION src-4.3.2-rc1
ENV PHALCON_VERSION 3.4.3

LABEL maintainer="luyuanxun <test@qq.com>" version="1.0"


# Timezonee
RUN /bin/cp /usr/share/zoneinfo/Asia/Shanghai /etc/localtime \
    && echo 'Asia/Shanghai' > /etc/timezone

# Libs
RUN apt-get update \
    && apt-get install -y \
    curl \
    wget \
    git \
    zip \
    libz-dev \
    libssl-dev \
    libnghttp2-dev \
    libpcre3-dev \
    libjpeg-dev \
    libpng-dev \
    libfreetype6-dev \
    && apt-get clean \
    && apt-get autoremove \
    && docker-php-ext-install -j$(nproc) iconv \
    && docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/ \
    && docker-php-ext-install -j$(nproc) gd \
    && docker-php-ext-install pdo_mysql \
    && docker-php-ext-install bcmath \
    && docker-php-ext-install gettext

# Composer
RUN curl -sS https://getcomposer.org/installer | php \
    && mv composer.phar /usr/local/bin/composer \
    && composer self-update --clean-backups

# Redis extension
COPY ext/redis-${PHPREDIS_VERSION}.tgz redis.tgz
RUN pecl install redis.tgz \
    && rm -rf redis.tgz \
    && docker-php-ext-enable redis

# Swoole extension
COPY ext/swoole-${SWOOLE_VERSION}.tar.gz swoole.tar.gz
RUN mkdir -p swoole \
    && tar -xf swoole.tar.gz -C swoole --strip-components=1 \
    && rm swoole.tar.gz \
    && ( \
    cd swoole \
    && phpize \
    && ./configure --enable-async-redis --enable-mysqlnd --enable-openssl --enable-http2 \
    && make -j$(nproc) \
    && make install \
    ) \
    && rm -r swoole \
    && docker-php-ext-enable swoole

# Phalcon extension
COPY ext/cphalcon-${PHALCON_VERSION}.tar.gz cphalcon.tar.gz
RUN mkdir -p cphalcon \
    && tar -xf cphalcon.tar.gz -C cphalcon --strip-components=1 \
    && rm cphalcon.tar.gz \
    && ( \
    cd cphalcon/build \
    && ./install \
    ) \
    && rm -r cphalcon \
    && docker-php-ext-enable phalcon

EXPOSE 9000 9501

WORKDIR /var/www