## Symfony dev setup using NGINX Unit

### Usage

```
git clone https://github.com/valtzu/symfony-nginx-unit-example
cd symfony-nginx-unit-example
docker-compose up
```

App should then respond at http://localhost:8080

## Configuration

### NGINX Unit

NGINX Unit configuration file is stored at [config/nginx-unit/nginx-unit-php-symfony.json](config/nginx-unit/nginx-unit-php-symfony.json).

### Logging

When using `APP_ENV=prod`, all logs except NGINX error logs (mostly startup & shutdown related) are in JSON format.

#### Example:

```
nginx_1  | {"channel":"php","level":"notice","message":"The \"Monolog\\Logger\" class is considered final. It may change without further notice as of its next major version. You should not extend it from \"Symfony\\Bridge\\Monolog\\Logger\".","file":"/app/vendor/symfony/error-handler/DebugClassLoader.php:331","request":{"id":null}}
nginx_1  | {"channel":"http","level":"info","request":{"method":"GET","host":"localhost","path":"/","ipAddress":"172.25.0.1","userAgent":"Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/107.0.0.0 Safari/537.36"},"response":{"bodyLength":1700,"status":200}}
```
