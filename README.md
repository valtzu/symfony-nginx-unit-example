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

NGINX Unit configuration file is stored in a single json file at [config/unit/php-symfony.unit.json](config/unit/php-symfony.unit.json).

### Routing

URLs that do not end with `.php` are first checked in `public/` directory, and if not found, then forwarded to `public/index.php`. Files ending `.php` are always routed to `index.php` so they are likely to never match any route.

### Logging

When using `APP_ENV=prod`, all logs except NGINX error logs (mostly startup & shutdown related) are in JSON format.

Username is parsed from `Authorization` header for `Basic` auth & `Bearer` JWT tokens (`sub` or `clientId` claim).

#### Example:

```bash
$ docker compose up
unit-1  | {"channel":"php","level":"notice","message":"The \"Monolog\\Logger\" class is considered final. It may change without further notice as of its next major version. You should not extend it from \"Symfony\\Bridge\\Monolog\\Logger\".","file":"/app/vendor/symfony/error-handler/DebugClassLoader.php:331","request":{"id":null}}
unit-1  | {"channel":"http","level":"info","request":{"id":"cf84a2f6726ab5a157b86194b81abaab","method":"GET","host":"localhost","path":"/","ipAddress":"172.29.0.1","user":"foobaz","userAgent":"Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/121.0.0.0 Safari/537.36","duration":0.003},"response":{"bodyLength":82735,"status":200}}
```
