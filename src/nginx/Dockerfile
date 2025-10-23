FROM nginx:latest

RUN mkdir -p /var/www/html/public

COPY src/nginx/default.conf /etc/nginx/conf.d/default.conf
COPY src/php/app/public /var/www/html/public