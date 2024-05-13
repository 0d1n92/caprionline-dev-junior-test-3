ARG XDEBUG_VERSION="xdebug-3.3.2"
ARG DEBUG
FROM php:8.3.6-fpm-bookworm
ENV DEBUG = true;
RUN docker-php-ext-install -j$(nproc) pdo_mysql

WORKDIR /tmp
RUN curl -L -o xdebug-3.3.2.tgz https://xdebug.org/files/xdebug-3.3.2.tgz
RUN tar -xzf xdebug-3.3.2.tgz
WORKDIR /tmp/xdebug-3.3.2

RUN phpize \
  && ./configure --enable-xdebug \
  && make \
  && make install

RUN cp modules/xdebug.so /usr/local/lib/php/extensions/no-debug-non-zts-20230831


RUN echo "zend_extension=xdebug.so" >> /usr/local/etc/php/conf.d/xdebug.ini; \
  echo "[xdebug]" >> /usr/local/etc/php/conf.d/xdebug.ini; \
  echo "xdebug.mode=develop,debug" >> /usr/local/etc/php/conf.d/xdebug.ini; \
  echo "xdebug.start_with_request=yes" >> /usr/local/etc/php/conf.d/xdebug.ini;\
  echo "xdebug.client_host=host.docker.internal" >> /usr/local/etc/php/conf.d/xdebug.ini;

WORKDIR /
RUN rm -rf /tmp/xdebug-3.3.2

CMD ["php-fpm"]

RUN curl -1sLf https://dl.cloudsmith.io/public/symfony/stable/setup.deb.sh | bash \
    && apt-get -y update \
    && apt-get -y install symfony-cli default-mysql-client unzip sudo \
    && apt-get -y clean \
    && curl -sSk https://getcomposer.org/installer | php -- --install-dir /usr/local/bin --filename composer

RUN useradd -u 1000 -G sudo -s /bin/bash -m php \
    && echo root:php | chpasswd \
    && echo php:php | chpasswd
