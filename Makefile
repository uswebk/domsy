build:
	docker-compose build
	docker-compose up -d
	docker-compose exec web composer install
	docker-compose exec web php artisan migrate:fresh --seed
	docker-compose exec web npm i
	docker-compose exec web npm run dev

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

migrate:
	docker-compose exec web php artisan migrate

fresh:
	docker-compose exec web php artisan migrate:fresh --seed

mix:
	docker-compose exec web npm run dev

cache:
	docker-compose exec web php artisan cache:clear
	docker-compose exec web php artisan config:clear
