#!/bin/bash

php artisan route:cache
php artisan config:clear

php artisan migrate:fresh --seed

php-fpm
