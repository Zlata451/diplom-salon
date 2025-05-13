FROM php:8.2-cli

# Устанавливаем системные зависимости
RUN apt-get update && apt-get install -y \
    unzip \
    libzip-dev \
    libpng-dev \
    libonig-dev \
    sqlite3 \
    zip \
    curl \
    git \
    && docker-php-ext-install pdo pdo_sqlite

# Устанавливаем Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Копируем файлы проекта
COPY . /var/www/html
WORKDIR /var/www/html

# Устанавливаем зависимости
RUN composer install --no-dev --optimize-autoloader

# Генерируем APP_KEY
RUN php artisan key:generate

# Запускаем Laravel
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=10000"]
