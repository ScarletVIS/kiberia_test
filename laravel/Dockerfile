# 1. Указываем базовый образ
FROM php:8.2-fpm

# 2. Установка зависимостей для PHP
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    git \
    curl \
    nodejs \
    npm \
    libzip-dev \
    && docker-php-ext-install pdo_mysql mbstring zip exif pcntl

# 3. Установка Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# 4. Устанавливаем рабочую директорию
WORKDIR /var/www/html

# 5. Копируем проект внутрь контейнера
COPY . /var/www/html

# 6. Устанавливаем зависимости Laravel и запускаем сборку Vite
RUN composer install

RUN npm install && npm run build

# 7. Expose порта Laravel
EXPOSE 8000

# 8. Копируем скрипт в контейнер
COPY start.sh /usr/local/bin/start.sh

# 9. Даем права на выполнение скрипта
RUN chmod +x /usr/local/bin/start.sh

# 10. Запускаем миграции и семечки | Команда запуска приложения
CMD ["/usr/local/bin/start.sh"]

# 11. Без этого не работают стили
RUN npm run build
