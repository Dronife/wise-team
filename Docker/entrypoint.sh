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

echo "Loading fixtures..."
php bin/console doctrine:fixtures:load --no-interaction || {
  echo "Failed to load fixtures"
  exit 1
}

echo "Resetting test database..."
php bin/console doctrine:database:drop --env=test --if-exists --force || {
  echo "Failed to drop test database"
  exit 1
}

php bin/console doctrine:database:create --env=test || {
  echo "Failed to create test database"
  exit 1
}

if ls migrations/*.php 1> /dev/null 2>&1; then
    php bin/console doctrine:migrations:migrate --env=test --no-interaction
else
    echo "No migrations found, skipping"
fi

exec "$@"
