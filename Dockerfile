FROM php:8.2-cli

# Устанавливаем системные зависимости
RUN apt-get update && apt-get install -y \
    unzip \
    libzip-dev \
    libpng-dev \
    libonig-dev \
    libsqlite3-dev \
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

# Устанавливаем зависимости Laravel
RUN composer install --no-dev --optimize-autoloader

# 📄 Копируем .env
RUN cp .env.example .env

# 🔑 Генерируем APP_KEY
RUN php artisan key:generate

# 🛠️ Настраиваем права
RUN chmod -R 775 storage bootstrap/cache public

# 🚀 Запуск Laravel-сервера
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=10000"]
