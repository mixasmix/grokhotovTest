#!/bin/bash
if [ -f .env ]; then
  source .env
fi

if [ -f .env.local ]; then
  source .env.local
fi

docker compose up -d
docker exec php-test php bin/console d:m:m --no-interaction
docker exec php-test php bin/console user:create --login=admin --password=admin --roles=ROLE_ADMIN
docker exec php-test php bin/console books:load-from-file $BOOKS_SOURCE
