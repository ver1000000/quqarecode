#syntax=docker/dockerfile:1.4

FROM php:8.2-fpm-alpine

# Install packages needed for PHP extensions
RUN apk add --no-cache \
    acl \
    fcgi \
    file \
    gettext \
    git \
    gnu-libiconv \
    linux-headers \
    brotli-dev \
    $PHPIZE_DEPS

# Install PHP extensions
RUN set -eux; \
    docker-php-ext-install -j$(nproc) \
        pdo_mysql \
        opcache \
    ;

# Install Swoole
RUN pecl install swoole && docker-php-ext-enable swoole

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set up php.ini
RUN mv "$PHP_INI_DIR/php.ini-development" "$PHP_INI_DIR/php.ini"

WORKDIR /var/www/html

# Install Caddy (used as web server)
COPY --from=caddy:2-alpine /usr/bin/caddy /usr/bin/caddy

# Copy composer files first
COPY composer.json ./

# Create Symfony directory structure
RUN mkdir -p \
    var/cache \
    var/log \
    var/sessions \
    config \
    public

# Set permissions for Symfony
RUN chown -R www-data:www-data var

# Install dependencies
RUN composer install --no-scripts --no-autoloader --no-interaction

# Copy the rest of the application
COPY . .

# Generate autoloader and run scripts
RUN composer dump-autoload --optimize && \
    composer run-script post-install-cmd --no-interaction

# Create directory for logs
RUN mkdir -p /var/log/caddy && \
    chown -R www-data:www-data /var/log/caddy

# Copy the Caddy configuration
COPY docker/Caddyfile /etc/caddy/Caddyfile

# Make entrypoint script executable
COPY docker/entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh

# Use entrypoint script
ENTRYPOINT ["/usr/local/bin/entrypoint.sh"] 