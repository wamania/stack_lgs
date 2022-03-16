#!/bin/sh
set -e

if [ "$APP_ENV" == "dev" ]; then
  /var/www/bin/console cache:clear -e dev
fi

if [ "$APP_ENV" == "prod" ]; then
  /var/www/bin/console cache:clear -e prod
fi

if [ "$APP_TYPE" == "console" ]; then
  # Should be done only by 1 instance
  /var/www/bin/console doctrine:database:create --if-not-exists
  /var/www/bin/console doctrine:migrations:migrate -n
 exit
fi

setfacl -Rm g:www-data:rwX /var/www/var/cache/

exec docker-php-entrypoint "$@"
