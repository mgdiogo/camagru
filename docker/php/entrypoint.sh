#!/bin/bash
set -e

envsubst < /etc/msmtprc.template > /etc/msmtprc
chown www-data:www-data /etc/msmtprc
chmod 600 /etc/msmtprc

exec "$@"