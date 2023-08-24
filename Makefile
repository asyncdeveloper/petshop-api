install:
	@make up
	@make setup-env
	docker compose exec app composer install
	docker compose exec app php artisan key:generate
	docker compose exec app php artisan jwt:secret
	@make migrate-seed
re-install:
	@make destroy
	@make install
restart:
	@make down
	@make up
up:
	docker compose up -d
destroy:
	docker compose down --rmi all --volumes --remove-orphans
	rm -rf vendor/
	rm -rf .env
down:
	docker compose down --remove-orphans
migrate:
	docker compose exec app php artisan migrate
migrate-seed:
	docker compose exec app php artisan migrate --seed
run-tests:
	docker compose exec app composer test
php-insights:
	docker compose exec app php artisan insights
setup-env:
	if ! [ -f .env ];then cp .env.example .env; fi
generate-docs:
	docker compose exec app php artisan l5-swagger:generate

