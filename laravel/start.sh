#!/bin/bash

# Создаем ключ Laravel
php artisan key:generate

# Выполнение миграций и сидеров
php artisan migrate:refresh --seed

# Запуск приложения Laravel
php artisan serve --host=0.0.0.0 --port=8000
