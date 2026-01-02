.PHONY: tests
all: help
SHELL=bash

# Absolutely awesome: http://marmelab.com/blog/2016/02/29/auto-documented-makefile.html
help: ## show this help
	@grep -E '^[a-zA-Z_-]+:.*?## .*$$' $(MAKEFILE_LIST) | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[36m%-24s\033[0m %s\n", $$1, $$2}'

.env:
	cp .env.example .env

docker-build-images:
	docker compose build

setup: .env docker-build-images up ## initialize the project if something is missing

composer-dump-autoload: ## run composer dump-autoload
	cli/composer dump-autoload

composer-install: ## run composer install
	cli/composer install -n

images=
docker-up:
	docker compose up -d --remove-orphans $(images)

migrate-fresh:
	cli/artisan migrate:fresh --seed

up: docker-up composer-install composer-dump-autoload migrate-fresh ## start the dev server and vendor

