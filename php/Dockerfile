FROM php:8.1-fpm
RUN docker-php-ext-install pdo_mysql
# mailhog対応
RUN apt-get update
RUN apt-get install -y vim
RUN curl -sSL https://github.com/mailhog/mhsendmail/releases/download/v0.2.0/mhsendmail_linux_amd64 -o mhsendmail
RUN chmod +x mhsendmail
RUN mv mhsendmail /usr/local/bin/mhsendmail
COPY ./mail.ini /usr/local/etc/php/php.ini