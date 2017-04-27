phpunit:
	docker-compose run --rm app vendor/bin/phpunit

coverage:
	docker-compose run --rm app phpdbg -qrr vendor/bin/phpunit

dusk:
	docker-compose start app && docker-compose exec app php artisan dusk
