FROM php:8.3-apache

RUN apt-get update && apt-get install -y \
    libpq-dev \
    unzip \
    git \
    && docker-php-ext-install pdo pdo_pgsql pgsql \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

RUN a2enmod rewrite headers

RUN sed -i 's|/var/www/html|/var/www/html|g' /etc/apache2/sites-available/000-default.conf \
    && sed -i 's|AllowOverride None|AllowOverride All|g' /etc/apache2/apache2.conf

COPY . /var/www/html/

RUN composer install --no-dev --optimize-autoloader --no-interaction --prefer-dist

RUN chown -R www-data:www-data /var/www/html \
    && find /var/www/html/backend/storage -type d -exec chmod 755 {} \; \
    && find /var/www/html/backend/storage -type f -exec chmod 644 {} \;

RUN sed -i 's|/rentease/|/|g' /var/www/html/.htaccess \
    && sed -i "s|\$basePath = '/rentease';|\$basePath = '';|g" /var/www/html/index.php

EXPOSE 80

CMD ["apache2-foreground"]
