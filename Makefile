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

ps:
	docker-compose ps

db:
	docker-compose exec db bash

db:
	docker-compose exec db bash

migrate:
	docker-compose exec web php artisan migrate

fresh:
	docker-compose exec web php artisan migrate:fresh --seed