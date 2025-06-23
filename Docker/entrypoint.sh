#!/bin/bash
set -e

until php bin/console doctrine:query:sql "SELECT 1" >/dev/null 2>&1; do
  echo "Waiting for DB..."
  sleep 2
done

php bin/console doctrine:database:create --if-not-exists || true
if ls migrations/*.php 1> /dev/null 2>&1; then
    php bin/console doctrine:migrations:migrate --no-interaction
else
    echo "No migrations found, skipping"
fi

exec "$@"
