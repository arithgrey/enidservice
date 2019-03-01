FROM php:7.1-apache
LABEL mantainer arithgrey@gmail.com
RUN  apt-get update
RUN  apt-get update && apt-get install -y mysql-client && rm -rf /var/lib/apt
RUN docker-php-ext-install mysqli
RUN docker-php-ext-enable mysqli


RUN  apt-get install apache2
EXPOSE 80 443