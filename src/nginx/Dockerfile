FROM nginx:latest

RUN mkdir -p /var/www/html/

COPY src/nginx/default.conf /etc/nginx/conf.d/default.conf
COPY src/www/html/ /var/www/html/