# Тестовое задание #


1. Клонируем репозиторий
> ```git clone https://github.com/ScarletVIS/kiberia_test.git```

2. Переходим в папку проекта
> `cd kiberia_test/laravel`

.env.example переименовываем в .env

# Для локальной версии #

3. У вас должен быть установлен composer, запущен сервер mysql

4. В файле .env указываем
> `DB_HOST=127.0.0.1`

5. Если база данных laravel не создана то создаем её

6. Устанавливаем зависимости Laravel и запускаем сборку Vite
> `composer install`

> `npm install`

> `npm run build`

7. Запускаем миграции и сиды
> `php artisan migrate --seed`

или

> `php artisan migrate:refresh --seed`

8. Генерируем ключ Laravel
> `php artisan key:generate`

8. Запускаем Laravel
> `php artisan serve`


# Для Docker версии #

3. У вас должен быть установлен и запущен Docker desktop

А также, если у вас запущена служба mysql, то нужно её отключить, так как задействется тот же порт что и в контейнере

4. В файле .env указываем
> `DB_HOST=db`

5. Устанавливаем зависимости Laravel и запускаем сборку Vite
> `composer install`

> `npm install`

> `npm run build`

6. Собираем образы Docker
> `docker-compose build --no-cache`

7. Запускаем контейнеры
> `docker-compose up -d`

8. Переходим по адресу:
> `http://127.0.0.1:8000/`


# Данные для входа #

Администратор, который может видеть заказы всех
> `admin@example.com` `password`

Клиент с балансом 10 000
> `kiberia_test@example.com` `password`


# Если не создался пользователь в БД или не выполнилась миграция #

1. Заходим в БД в конейнере или локально (Пароль 12345)
> `docker-compose exec db mysql -u root -p`

> CREATE USER 'scarlet'@'%' IDENTIFIED BY '12345';

> FLUSH PRIVILEGES;

> GRANT ALL PRIVILEGES ON `laravel`.* TO 'scarlet'@'%' ;

> FLUSH PRIVILEGES;

2. Заново запускаем миграции
> `docker-compose exec app bash`

> `php artisan migrate:refresh --seed`
