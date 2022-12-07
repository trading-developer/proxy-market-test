init: up composer_install migrate seed
up:
	docker-compose up -d
composer_install:
	docker-compose run --rm app-php composer install
migrate:
	docker-compose run --rm app-php php artisan migrate --force
seed:
	docker-compose run --rm app-php php artisan db:seed
recreate-php:
	docker-compose up -d --force-recreate --no-deps --build app-php
recreate-pg:
	docker-compose up -d --force-recreate --no-deps --build app-postgres
recreate-nginx:
	docker-compose up -d --force-recreate --no-deps --build app-nginx
gophp:
	docker-compose exec app-php bash
docker-down-clear:
	docker-compose down -v --remove-orphans
tests:
	docker-compose run app-php php artisan test
