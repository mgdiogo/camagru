FROM php:8.4.13-fpm

RUN apt-get update && apt-get install -y \
    msmtp msmtp-mta ca-certificates gettext-base \
    && docker-php-ext-install pdo pdo_mysql

RUN touch /var/log/msmtp.log \
	&& chown www-data:www-data /var/log/msmtp.log \
	&& chmod 664 /var/log/msmtp.log

RUN mkdir -p /var/www/html/public/uploads \
    && chmod -R 775 /var/www/html/public/uploads \
    && chown -R www-data:www-data /var/www/html/public/uploads

RUN cp /usr/local/etc/php/php.ini-production /usr/local/etc/php/php.ini

COPY ./docker/php/mail.ini /usr/local/etc/php/conf.d/
COPY ./docker/php/msmtprc.template /etc/msmtprc.template
COPY ./docker/php/entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh

WORKDIR /var/www/html

ENTRYPOINT ["/entrypoint.sh"]
CMD ["php-fpm"]