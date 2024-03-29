build:
	docker-compose build
	docker-compose up -d
	docker-compose exec web cp -p .env.example .env
	docker-compose exec web cp -p .env.testing.example .env.testing
	docker-compose exec web composer install
	docker-compose exec web php artisan key:generate
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

rollback:
	docker-compose exec web php artisan migrate:rollback

mix:
	docker-compose exec web npm run dev

cache:
	docker-compose exec web php artisan cache:clear
	docker-compose exec web php artisan config:clear
	docker-compose exec web php artisan route:clear
	docker-compose exec web php artisan view:clear
	docker-compose exec web composer dump-autoload

unit:
	docker-compose exec web ./vendor/bin/phpunit  --testsuite Unit
