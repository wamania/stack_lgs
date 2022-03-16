# ############################################################## #
# https://github.com/dunglas/symfony-docker/blob/main/Dockerfile #
# ############################################################## #

# https://docs.docker.com/engine/reference/builder/#understand-how-arg-and-from-interact
ARG PHP_VERSION=8.1
ARG NGINX_VERSION=1.21

# "php" stage
FROM php:${PHP_VERSION}-fpm-alpine AS php_alpine

# install usermod
RUN echo http://dl-2.alpinelinux.org/alpine/edge/community/ >> /etc/apk/repositories
RUN apk --no-cache add shadow

# persistent / runtime deps
RUN apk add --no-cache \
  acl \
  bash \
  curl \
  fcgi \
  file \
  git \
  jq \
  gnu-libiconv \
  libgcc \
  libstdc++ \
  supervisor\
  libmcrypt-dev \
  ;

# install gnu-libiconv and set LD_PRELOAD env to make iconv work fully on Alpine image.
# see https://github.com/api-platform/api-platform/pull/1857
ENV LD_PRELOAD /usr/lib/preloadable_libiconv.so

RUN set -eux; \
  apk add --no-cache --virtual .build-deps \
  $PHPIZE_DEPS \
  icu-dev \
  libzip-dev \
  zlib-dev \
  libmcrypt-dev \
  libxml2-dev \
  libressl-dev \
  libpng-dev \
  jpeg-dev \
  cyrus-sasl-dev \
  libpq-dev \
  ; \
  \
  docker-php-ext-configure zip; \
  docker-php-ext-configure gd --with-jpeg=/usr/lib/; \
  docker-php-ext-configure pdo_pgsql --with-pdo-pgsql; \
  docker-php-ext-install -j$(nproc) \
  intl \
  zip \
  pdo \
  pdo_pgsql \
  bcmath \
  gd \
  ; \
  runDeps="$( \
  scanelf --needed --nobanner --format '%n#p' --recursive /usr/local/lib/php/extensions \
  | tr ',' '\n' \
  | sort -u \
  | awk 'system("[ -e /usr/local/lib/" $1 " ]") == 0 { next } { print "so:" $1 }' \
  )"; \
  apk add --no-cache --virtual .phpexts-rundeps $runDeps; \
  \
  apk del .build-deps

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

RUN ln -s $PHP_INI_DIR/php.ini-production $PHP_INI_DIR/php.ini
COPY .docker/php/conf.d/symfony.prod.ini $PHP_INI_DIR/conf.d/symfony.ini
COPY .docker/php/php-fpm.d/zz-custom.conf /usr/local/etc/php/conf.d/zz-custom.conf

WORKDIR /var/www

ARG WWW_DATA_UID
ARG WWW_DATA_GID

RUN usermod -u ${WWW_DATA_UID} www-data
RUN groupmod -g ${WWW_DATA_GID} www-data
RUN usermod -g ${WWW_DATA_GID} www-data

COPY .docker/php/docker-entrypoint.sh /usr/local/bin/docker-entrypoint
RUN chmod +x /usr/local/bin/docker-entrypoint
RUN chown -R www-data:www-data /var/www/

USER www-data

COPY --chown=www-data:www-data . .

RUN mkdir -p var/cache var/log; \
    composer install --no-interaction --optimize-autoloader;

VOLUME ["/var/www"]

ENTRYPOINT ["docker-entrypoint"]

FROM php_alpine as symfony_php
CMD ["php-fpm"]

FROM php_alpine as cli_php
CMD ["/bin/bash"]

FROM nginx:${NGINX_VERSION} AS symfony_nginx
ARG WWW_DATA_UID
ARG WWW_DATA_GID

WORKDIR /var/www

COPY --from=php_alpine /var/www/public public/

USER root
COPY .docker/nginx/nginx.conf /etc/nginx/nginx.conf
COPY .docker/nginx/rules/rules.prod.conf /etc/nginx/rules.conf
COPY .docker/nginx/templates/prod.conf.template /etc/nginx/templates/default.conf.template
