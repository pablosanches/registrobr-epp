current-dir := $(dir $(abspath $(lastword $(MAKEFILE_LIST))))

composer-install:
	docker exec registrobr-epp composer install

test:
	docker exec registrobr-epp ./vendor/bin/phpunit --testsuite unit

start:
	UID=${shell id -u} GID=${shell id -g} docker compose up --build -d
	@composer-install