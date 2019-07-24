FROM composer

FROM surnet/alpine-wkhtmltopdf:3.7-0.12.5-full AS wkhtp

FROM php:7.2-fpm-alpine

COPY --from=composer /usr/bin/composer /usr/local/bin/composer
COPY --from=wkhtp /bin/wkhtmltopdf /usr/bin/wkhtmltopdf-origin

RUN apk add --no-cache \
            xvfb \
            # Additionnal dependencies for better rendering
            ttf-freefont \
            fontconfig \
            dbus \
    && \
    # Wrapper for xvfb
    echo $'#!/usr/bin/env sh\n\
    Xvfb :0 -screen 0 1024x768x24 -ac +extension GLX +render -noreset & \n\
    DISPLAY=:0.0 wkhtmltopdf-origin $@ \n\
    killall Xvfb\
    ' > /usr/bin/wkhtmltopdf && \
    chmod +x /usr/bin/wkhtmltopdf

RUN apk add --no-cache \
        ca-certificates \
        icu-libs \
        git \
        unzip \
        postgresql-dev \
        nodejs \
        libpng-dev \
        libzip \
        libzip-dev \
        zlib-dev

RUN apk add --no-cache --virtual .build-deps \
        $PHPIZE_DEPS \
        icu-dev

RUN docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql  && \
    docker-php-ext-configure zip --with-libzip && \
    docker-php-ext-install zip intl mbstring pdo pdo_pgsql bcmath gd && \
    pecl install apcu && \
    pecl install xdebug && \
    docker-php-ext-enable apcu opcache

RUN echo "short_open_tag = off" >> /usr/local/etc/php/php.ini && \
    echo "memory_limit = 256M" >> /usr/local/etc/php/php.ini && \
    echo "opcache.enable = 1" >> /usr/local/etc/php/php.ini && \
    echo "opcache.enable_cli = 1" >> /usr/local/etc/php/php.ini && \
    echo "opcache.memory_consumption = 256" >> /usr/local/etc/php/php.ini && \
    echo "opcache.interned_strings_buffer = 32" >> /usr/local/etc/php/php.ini && \
    echo "opcache.max_file_size = 100000000" >> /usr/local/etc/php/php.ini && \
    echo "opcache.validate_timestamps = 1" >> /usr/local/etc/php/php.ini && \
    echo "opcache.revalidate_freq = 0" >> /usr/local/etc/php/php.ini && \
    echo "opcache.fast_shutdown = 1" >> /usr/local/etc/php/php.ini && \
    echo "date.timezone = Europe/Paris" >> /usr/local/etc/php/conf.d/symfony.ini && \
    echo "opcache.max_accelerated_files = 20000" >> /usr/local/etc/php/conf.d/symfony.ini && \
    echo "realpath_cache_size=4096K" >> /usr/local/etc/php/conf.d/symfony.ini && \
    echo "realpath_cache_ttl=600" >> /usr/local/etc/php/conf.d/symfony.ini && \
    echo "upload_max_filesize = 20M;" >> /usr/local/etc/php/conf.d/uploads.ini
    apk del .build-deps && \
    apk add gosu --update --no-cache --repository http://dl-3.alpinelinux.org/alpine/edge/testing/ --allow-untrusted && \
    addgroup bar && \
    adduser -D -h /home -s /bin/sh -G bar foo


COPY --from=0 /usr/bin/composer /usr/bin/composer
COPY docker/php/php.ini /usr/local/etc/php/php.ini
COPY docker/php/docker-entrypoint.sh /usr/local/bin/docker-entrypoint
RUN chmod +x /usr/local/bin/docker-entrypoint


WORKDIR /srv/symfony
ENTRYPOINT ["docker-entrypoint"]
CMD ["php-fpm"]