current-dir := $(dir $(abspath $(lastword $(MAKEFILE_LIST))))

composer-install:
	@docker run --rm $(INTERACTIVE) --volume $(current-dir):/app --user $(id -u):$(id -g) \
		composer:2.6.4 install \
			--ignore-platform-reqs \
			--no-ansi

test:
	docker exec registrobr-epp ./vendor/bin/phpunit --testsuite unit

start:
	UID=${shell id -u} GID=${shell id -g} docker compose up --build -d
	@composer-install