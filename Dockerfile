FROM node:22-alpine AS assets

WORKDIR /app
COPY package.json ./
RUN npm install
COPY vite.config.js ./
COPY resources ./resources
COPY public ./public
RUN npm run build

FROM php:8.3-cli AS vendor

RUN apt-get update \
    && apt-get install -y --no-install-recommends libonig-dev libpq-dev libxml2-dev unzip \
    && docker-php-ext-install mbstring pdo_pgsql xml \
    && rm -rf /var/lib/apt/lists/*

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer
WORKDIR /app
COPY . .
RUN mkdir -p bootstrap/cache storage/app/public storage/framework/cache/data storage/framework/sessions storage/framework/views storage/logs
RUN composer install --no-dev --no-interaction --prefer-dist --optimize-autoloader

FROM php:8.3-apache

RUN apt-get update \
    && apt-get install -y --no-install-recommends libonig-dev libpq-dev libxml2-dev \
    && docker-php-ext-install mbstring pdo_pgsql xml \
    && sed -i '/^Listen 80$/d' /etc/apache2/ports.conf \
    && a2dissite 000-default \
    && a2enmod rewrite \
    && rm -rf /var/lib/apt/lists/*

WORKDIR /var/www/html
COPY --from=vendor /app ./
COPY --from=assets /app/public/build ./public/build
COPY docker/apache-vhost.conf /etc/apache2/sites-available/app.conf
RUN mkdir -p bootstrap/cache storage/app/public storage/framework/cache/data storage/framework/sessions storage/framework/views storage/logs
RUN ls -la /etc/apache2/sites-available/
RUN a2ensite app
RUN chown -R www-data:www-data storage bootstrap/cache
RUN chmod -R ug+rwX storage bootstrap/cache

EXPOSE 10000

CMD ["sh", "-c", "export APP_URL=\"${APP_URL:-${RENDER_EXTERNAL_URL:-http://localhost}}\" && php artisan migrate --force && php artisan db:seed --force && php artisan optimize && exec apache2-foreground"]
