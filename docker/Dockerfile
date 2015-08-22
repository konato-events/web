# Uses the latest Ubuntu base image
FROM ubuntu:latest
MAINTAINER Igor Santos <konato@igorsantos.com.br>

# Silences debconf's endless prattle
ENV DEBIAN_FRONTEND noninteractive

# Adds the official Zend repository
RUN echo "deb http://repos.zend.com/zend-server/early-access/php7/repos ubuntu/" >> /etc/apt/sources.list
RUN apt-get update

# Installs basic stuff
RUN apt-get -y --force-yes install curl vim

# Installs Nginx and PHP7
RUN apt-get -y --force-yes install php7-beta1 nginx

# Configures PHP-FPM
COPY usr_local_php7_etc_php-fpm.conf /usr/local/php7/etc/php-fpm.conf
COPY etc_init.d_php7-fpm /etc/init.d/php7-fpm
COPY etc_init_php7-fpm /etc/init/php7-fpm
COPY usr_local_lib_php7-fpm-checkconf /usr/local/lib/php7-fpm-checkconf
RUN chmod +x /etc/init.d/php7-fpm /usr/local/lib/php7-fpm-checkconf
RUN update-rc.d php7-fpm defaults
RUN service php7-fpm start
RUN service php7-fpm status
RUN service nginx start
RUN service nginx status

# Configures Nginx


# Sets Composer variables and the correct PATH
ENV COMPOSER_BINARY=/usr/local/bin/composer \
    COMPOSER_HOME=/usr/local/composer
ENV PATH $PATH:$COMPOSER_HOME:/usr/local/php7

# Installs Composer system-wide
#RUN curl -sS https://getcomposer.org/installer | php && \
#    mv composer.phar $COMPOSER_BINARY && \
#    chmod +x $COMPOSER_BINARY

# Sets global Composer path
#RUN mkdir $COMPOSER_HOME && chmod a+rw $COMPOSER_HOME

CMD /bin/bash
