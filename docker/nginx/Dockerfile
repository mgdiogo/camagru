FROM nginx:latest

RUN mkdir -p /var/www/html/public

WORKDIR /var/www/html

COPY src/nginx/default.conf /etc/nginx/conf.d/default.conf