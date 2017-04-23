#!/bin/sh
docker-compose run --rm app vendor/bin/phpunit $@
