#!/bin/bash
set -e

envsubst < /etc/msmtprc.template > /etc/msmtprc
chown www-data:www-data /etc/msmtprc
chmod 600 /etc/msmtprc

mkdir -p /var/www/html/public/uploads/avatars
mkdir -p /var/www/html/public/uploads/posts
chown -R www-data:www-data /var/www/html/public/uploads
chmod -R 775 /var/www/html/public/uploads

exec "$@"