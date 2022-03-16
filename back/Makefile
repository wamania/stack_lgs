
network:
	docker network create smallable.com || true
	docker volume create --name=pg_stack_lgs_data || true

init: network
init: install

start:
	docker-compose up --force-recreate --build -d api

stop:
	docker-compose down --remove-orphans

build:
	docker-compose build --force-recreate

bash:
	docker-compose exec --user=www-data php /bin/bash

db:
	docker-compose run --rm cli bash -c "bin/console doctrine:database:create --if-not-exists"
	docker-compose run --rm cli bash -c "bin/console doctrine:migrations:migrate --no-interaction"

fixtures: db
fixtures:
	docker-compose run --rm cli bash -c "bin/console hautelook:fixtures:load --env=dev"
