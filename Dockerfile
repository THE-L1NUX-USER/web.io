FROM php:8.3.36-apache
RUN docker-php-ext-install mysqli && docker-php-ext-enable mysqli