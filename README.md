## Symfony dev setup using NGINX Unit

This is an example of Symfony + NGINX Unit using docker & docker-compose. See also the [official NGINX Unit Symfony example](https://unit.nginx.org/howto/symfony/).

### Usage

```
git clone https://github.com/valtzu/symfony-nginx-unit-example
cd symfony-nginx-unit-example
docker-compose up
```

App should then respond at http://localhost:8080

## Configuration

### NGINX Unit

NGINX Unit configuration file is stored in a single json file at [config/nginx-unit/php-symfony.unit.json](config/nginx-unit/php-symfony.unit.json).

### Routing

URLs that do not end with `.php` are first checked in `public/` directory, and if not found, then forwarded to `public/index.php`. Files ending `.php` are always routed to `index.php` so they are likely to never match any route.

### Logging

When using `APP_ENV=prod`, all logs except NGINX error logs (mostly startup & shutdown related) are in JSON format.

#### Example:

```
nginx_1  | {"channel":"php","level":"notice","message":"The \"Monolog\\Logger\" class is considered final. It may change without further notice as of its next major version. You should not extend it from \"Symfony\\Bridge\\Monolog\\Logger\".","file":"/app/vendor/symfony/error-handler/DebugClassLoader.php:331","request":{"id":null}}
nginx_1  | {"channel":"http","level":"info","request":{"method":"GET","host":"localhost","path":"/","ipAddress":"172.25.0.1","userAgent":"Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/107.0.0.0 Safari/537.36"},"response":{"bodyLength":1700,"status":200}}
```

## Things NGINX Unit does not support (as of 2022-11-20)

1. No Docker images for ARM yet (see https://github.com/nginx/unit/issues/606#issuecomment-996536871)
2. No support for `escape=json` in log format – you can break json by providing user agent that has quotation mark in it
3. No support for `$request_time` in log format – not possible to log how long rq/rs took. It is [committed](https://github.com/nginx/unit/issues/749) already though – just not released yet.
4. No automatic request id generation – in regular NGINX `$request_id` is always populated, and you can pass that to php-fpm.
