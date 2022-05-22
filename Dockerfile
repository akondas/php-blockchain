FROM php:8.1-cli-alpine
RUN apk add --no-cache bash curl git
RUN docker-php-ext-install pcntl
COPY --from=composer:2.1.5 /usr/bin/composer /usr/bin/composer
