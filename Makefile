build:
	docker-compose build

up:
	docker-compose up -d

down:
	docker-compose down

rebuild:
	docker-compose up -d --build

restart:
	docker-compose stop
	docker-compose up -d

php:
	docker-compose exec web bash

cache:
	docker-compose exec php php artisan cache:clear
