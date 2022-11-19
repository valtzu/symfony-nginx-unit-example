FROM nginx/unit:1.28.0-php8.1

RUN \
    apt-get update \
    && apt-get install -y unzip libzip-dev libicu-dev \
    && docker-php-ext-install zip intl

RUN useradd app \
    && mkdir -p /app \
    && echo "/app/bin/console cache:clear" > /docker-entrypoint.d/cache-clear.sh \
    && chmod a+x /docker-entrypoint.d/cache-clear.sh \
    && chown -R app:app /run /app /var/lib/unit

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /app
USER app:app
COPY --chown=app:app composer.json composer.lock symfony.lock ./
RUN composer install --no-interaction --no-scripts
COPY --chown=app:app . .
COPY ./config/nginx-unit/nginx-unit-php-symfony.json /docker-entrypoint.d/nginx-unit-php-symfony.json

ENV APP_ENV=prod
