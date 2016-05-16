# Uses the latest Ubuntu base image
FROM ubuntu:trusty
MAINTAINER Igor Santos <konato@igorsantos.com.br>

# Silences debconf's endless prattle
ENV DEBIAN_FRONTEND noninteractive

# Installs basic stuff
RUN apt-get update && \
	apt-get install  -y --force-yes \
		curl \
		vim \
		wget

# Installs HTTP, DB and process manager
RUN apt-get install -y --force-yes \
	nginx \
	redis-server \
    postgresql-9.3 \
    postgresql-client-9.3 \
	supervisor

# Installs PHP7 compile dependencies
# based on: https://www.howtoforge.com/tutorial/install-php-7-on-debian-8-jessie/#compilenbspphp-with-phpfpm-and-fastcgi and http://www.hashbangcode.com/blog/compiling-and-installing-php7-ubuntu
RUN apt-get install -y --force-yes  \
    build-essential \
    autoconf \
    bison \
    libbz2-dev \
    libc-client2007e \
    libc-client2007e-dev \
    libcurl4-openssl-dev \
    libfcgi0ldbl \
    libfcgi-dev \
    libfreetype6-dev \
    libgdbm-dev \
    libicu-dev \
    libiodbc2-dev \
    libjpeg62 \
    libjpeg62-dev \
    libkrb5-dev \
    libmcrypt-dev \
    libpng12-0 \
    libpng12-dev \
    libpq-dev \
    libssl-dev \
    libxml2-dev \
    libxslt1-dev \
    openssl \
    pkg-config \
    systemtap-sdt-dev

# Compiling PHP7
RUN wget http://br1.php.net/get/php-7.0.6.tar.xz/from/this/mirror -O - | tar -xJf - \
    && cd php-7.0.6/ \
    && ./configure \
        --prefix=/usr/local/php7 \
        --disable-rpath \
        --enable-bcmath \
        --enable-calendar \
        --enable-exif \
        --enable-fpm \
        --enable-ftp \
        --enable-gd-native-ttf \
        --enable-inline-optimization \
        --enable-mbregex \
        --enable-mbstring \
        --enable-opcache \
        --enable-pcntl \
        --enable-soap \
        --enable-sockets \
        --enable-sysvsem \
        --enable-sysvshm \
        --enable-zip \
        --with-bz2 \
        --with-curl \
        --with-fpm-group=www-data \
        --with-fpm-user=www-data \
        --with-freetype-dir \
        --with-gd \
        --with-gettext \
        --with-jpeg-dir=/usr \
        --with-kerberos \
        --with-libdir=/lib/x86_64-linux-gnu \
        --with-libxml-dir=/usr \
        --with-mcrypt \
        --with-mhash \
        --with-openssl \
        --with-pcre-regex \
        --with-pdo-pgsql \
        --with-pgsql \
        --with-png-dir=/usr \
        --with-xmlrpc \
        --with-xsl \
        --with-zlib \
        --with-zlib-dir \
    && make -j"$(nproc)" \
    && make install

# Installs the project locales on the system
RUN locale-gen pt_BR.UTF-8 en_CA.UTF-8

# Configures PHP-FPM
COPY usr_local_php7_etc_php-fpm.conf /usr/local/php7/etc/php-fpm.conf
COPY php.ini-development /usr/local/php7/etc/
COPY php.ini-production  /usr/local/php7/etc/
VOLUME /var/www

# Configures supervisord
COPY etc_supervisor_conf.d_supervisord.conf /etc/supervisor/conf.d/supervisord.conf

# Configures the database
USER postgres
RUN /etc/init.d/postgresql start &&\
    createuser -DRS konato &&\
    createdb -O konato konato &&\
    psql -c "ALTER USER konato WITH PASSWORD 'konato'"
# Back again to root
USER root
VOLUME /var/lib/postgresql
# fixes a bug(?) in AUFS - https://github.com/nimiq/docker-postgresql93/issues/2#issuecomment-218165914
RUN mkdir /etc/ssl/private-copy; \
    mv /etc/ssl/private/* /etc/ssl/private-copy/; \
    rm -r /etc/ssl/private; \
    mv /etc/ssl/private-copy /etc/ssl/private; \
    chmod -R 0700 /etc/ssl/private; \
    chown -R postgres /etc/ssl/private

# Sets Composer variables and the correct PATH
ENV COMPOSER_BINARY /usr/local/bin/composer
ENV COMPOSER_HOME /usr/local/composer
ENV PATH $PATH:$COMPOSER_HOME:/usr/local/php7/bin

# Installs Composer system-wide
RUN curl -sS https://getcomposer.org/installer | php && \
    mv composer.phar $COMPOSER_BINARY && \
    chmod +x $COMPOSER_BINARY
RUN mkdir -p $COMPOSER_HOME && chmod a+rw $COMPOSER_HOME

# Exposes ports that can be used
EXPOSE 80 8080 443 5432

# And finally, starts Nginx and PHP-FPM for your enjoyment
CMD /usr/bin/supervisord
