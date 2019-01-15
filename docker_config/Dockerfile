FROM php:7.1-apache

LABEL maintainer="arithgrey@gmail.com"
ENV SERVER_NAME "local"
ENV WEBSERVER_USER "www-data"
ENV IDE "PHPSTORM"
ENV ACCESS_USER ="enid"
ENV REMOTE "9000"

RUN useradd  -m -d /home/${ACCESS_USER} -s /bin/bash ${ACCESS_USER}  &&  usermod -g www-data  ${ACCESS_USER}
RUN mkdir /home/$ACCESS_USER/.ssh

RUN apt-get update && apt-get install -y --no-install-recommends locales wget apt-utils tcl build-essential -y
RUN set -x; \
    locale-gen es_MX.UTF-8 && \
    update-locale && \
    echo 'LANG="es_MX.UTF-8"' > /etc/default/locale
RUN echo "en_US.UTF-8 UTF-8" > /etc/locale.gen

RUN docker-php-source extract \
	&& docker-php-source delete

RUN apt-get update && apt-get install -y \
		libfreetype6-dev \
		libjpeg62-turbo-dev \
		libpng-dev \
	&& docker-php-ext-install -j$(nproc) iconv \
	&& docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/ \
	&& docker-php-ext-install -j$(nproc) gd

#RUN pecl install redis-4.0.1 \
#	&& pecl install xdebug-2.6.0 \
#	&& docker-php-ext-enable redis xdebug


RUN pecl install xdebug && docker-php-ext-enable xdebug \
        && echo "xdebug.idekey = ${IDE}" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
        && echo "xdebug.remote_port = ${REMOTE}" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
        && echo "xdebug.remote_enable = on" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
        && echo "xdebug.remote_autostart = on" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
        && echo "xdebug.remote_connect_back = off" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
        && echo "xdebug.remote_handler = dbgp" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
        && echo "xdebug.profiler_output_dir = '/var/www/html'" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
        && echo "xdebug.collect_params = 4" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
        && echo "xdebug.collect_vars = on" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
        && echo "xdebug.dump_globals = on" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
        && echo "xdebug.dump.SERVER = REQUEST_URI" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
        && echo "xdebug.show_local_vars = on" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
        && echo "xdebug.cli_color = 1" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && chmod 666 /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini




RUN chmod +x /usr/local/bin/docker-php-ext-install
RUN docker-php-ext-configure gd --with-jpeg-dir=/usr/include/


RUN apt-get install gnupg2 gnupg -y
RUN apt-get install net-tools openssh-server supervisor nano vim mysql-client -y && apt-get install -y apache2 \
    && a2enmod rewrite \
    && a2enmod proxy \
    && a2enmod proxy_fcgi

#RUN rm /etc/apache2/sites-available/default.conf
ADD extra/default.conf /etc/apache2/sites-available/default.conf
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
ADD extra/php.ini /usr/local/etc/php

ADD extra/entrypoint.sh /usr/local/bin/entrypoint.sh
ADD extra/supervisor.conf /etc/supervisord.conf

RUN chmod +x /usr/local/bin/entrypoint.sh


RUN echo "export LANG=en_US.UTF-8\nexport LANGUAGE=en_US.UTF-8\nexport LC_ALL=en_US.UTF-8\nexport PYTHONIOENCODING=UTF-8" | tee -a /etc/bash.bashrc


RUN apt-get install libmcrypt-dev python-pip libicu-dev libxml2-dev libxslt1-dev libfreetype6-dev \
libjpeg62-turbo-dev libpng-dev git vim openssh-server ocaml expect -y

RUN python2 -m pip install supervisor
RUN mkdir /ssl


RUN apt-get install cron -y
#RUN service crond start
#RUN systemctl status cron

RUN su ${ACCESS_USER}

WORKDIR /var/www/html


EXPOSE 80 443
ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]