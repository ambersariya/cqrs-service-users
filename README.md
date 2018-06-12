# users-service-prooph
Prooph Event Sourcing Example

```shell
# Bash

$ git clone git@github.com:ambersariya/users-service-prooph.git
$ docker run --rm -it --volume $(pwd):/app prooph/composer:7.2 install
$ docker-compose up -d


$ docker-compose exec php sh
$ docker-compose exec php bin/console event-store:event-stream:create
$ docker-compose exec php bin/console doctrine:migrations:migrate --no-interaction

```

Enable JWT

```shell
# The following will grab passphrase from our .env variable
$ openssl genrsa -passout env:JWT_PASSPHRASE -out config/jwt/private.pem -aes256 4096
$ openssl rsa -pubout -in config/jwt/private.pem -out config/jwt/public.pem -passin env:JWT_PASSPHRASE
```
