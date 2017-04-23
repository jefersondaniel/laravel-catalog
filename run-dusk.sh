#!/bin/sh
docker-compose start app && docker-compose exec app php artisan dusk
