# Uses the latest Ubuntu base image
FROM ubuntu:latest
MAINTAINER Igor Santos <konato@igorsantos.com.br>

# Silences debconf's endless prattle
ENV DEBIAN_FRONTEND noninteractive

# Adds the official Zend repository
RUN echo "deb http://repos.zend.com/zend-server/early-access/php7/repos ubuntu/" >> /etc/apt/sources.list

# Installs basic stuff
RUN apt-get update && \
	apt-get install  -y --force-yes \
		curl \
		vim

# Installs Nginx and PHP7
RUN apt-get install -y --force-yes \
	nginx \
	php7-beta1

# Configures PHP-FPM
COPY usr_local_php7_etc_php-fpm.conf /usr/local/php7/etc/php-fpm.conf
COPY etc_init.d_php7-fpm /etc/init.d/php7-fpm
COPY etc_init_php7-fpm /etc/init/php7-fpm
COPY usr_local_lib_php7-fpm-checkconf /usr/local/lib/php7-fpm-checkconf
RUN chmod +x \
	/etc/init.d/php7-fpm \
	/usr/local/lib/php7-fpm-checkconf \
	/etc/init/php7-fpm
RUN update-rc.d php7-fpm defaults #needed?

# Sets Composer variables and the correct PATH
ENV COMPOSER_BINARY /usr/local/bin/composer
ENV COMPOSER_HOME /usr/local/composer
ENV PATH $PATH:$COMPOSER_HOME:/usr/local/php7/bin

# Installs Composer system-wide
RUN curl -sS https://getcomposer.org/installer | php && \
    mv composer.phar $COMPOSER_BINARY && \
    chmod +x $COMPOSER_BINARY
RUN mkdir $COMPOSER_HOME && chmod a+rw $COMPOSER_HOME

# Exposes ports that can be used
EXPOSE 80
EXPOSE 8080
EXPOSE 443

# And finally, starts Nginx and PHP-FPM for your enjoyment
CMD service php7-fpm start; \
	service php7-fpm status; \
	service nginx start; \
	service nginx status