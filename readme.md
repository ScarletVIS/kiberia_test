1.
cd laravel
git clone https://github.com/laravel/laravel.git

2.
cd laravel
docker run -v "${pwd}.Path -replace '\\', '/'}:/app" composer install

3.
docker-compose up -d

4.
docker-compose exec app php artisan key:generate

5.
docker-compose exec app php artisan config:cache

6.
docker-compose exec db bash



new 

msyql create users

1.
CREATE USER 'scarlet'@'%' IDENTIFIED BY '12345';
FLUSH PRIVILEGES;

GRANT ALL PRIVILEGES ON `laravel`.* TO 'scarlet'@'%' ;
FLUSH PRIVILEGES;

FLUSH PRIVILEGES;