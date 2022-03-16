
init:
	docker volume create --name=pg_stack_lgs_data || true

start:
	docker-compose up --force-recreate --build -d lgs_api lgs_cli

stop:
	docker-compose down --remove-orphans

build:
	docker-compose build --force-recreate

bash:
	docker-compose exec --user=www-data lgs_php /bin/bash

fixture:
	docker-compose run --rm lgs_cli bash -c "bin/console doctrine:database:create --if-not-exists"
	docker-compose run --rm lgs_cli bash -c "bin/console doctrine:schema:update --force"
	docker-compose run --rm lgs_cli bash -c "bin/console hautelook:fixtures:load --env=dev"
