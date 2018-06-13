# users-service-prooph
Prooph Event Sourcing Example

### Start
```shell
# Bash

$ git clone git@github.com:ambersariya/users-service-prooph.git
# Bash on Linux/Mac
$ docker run --rm -it --volume $(pwd):/app prooph/composer:7.2 install
# Fish shell
$ docker run --rm -it --volume (pwd):/app prooph/composer:7.2 install
# Git Bash on Windows
$ docker run --rm -it --volume /$(pwd):/app prooph/composer:7.2 install
$ docker-compose up -d


$ docker-compose exec php sh
$ docker-compose exec php bin/console event-store:event-stream:create
$ docker-compose exec php bin/console doctrine:migrations:migrate --no-interaction

```

### Enable JWT

```shell
# The following will grab passphrase from our .env variable
$ mkdir -p config/jwt
$ docker-compose exec php openssl genrsa -passout env:JWT_PASSPHRASE -out config/jwt/private.pem -aes256 4096
$ docker-compose exec php openssl rsa -pubout -in config/jwt/private.pem -out config/jwt/public.pem -passin env:JWT_PASSPHRASE
```

### Create User (Cli)
```shell
docker-compose exec php bin/console app:sign-up
```

### Register
```shell
$ curl -X POST \
  http://[HOST NAME HERE]/register \
  -H 'Content-Type: application/json' \
      -d '{
      "first_name": "John",
      "last_name": "Doe",
      "email": "johndoe@example.org",
      "password": "testpass",
      "id": "fd9999ff-0f13-4c52-a973-915217d591d1"
    }'
 
-> 201 Created
```

### Login
```shell
curl -X POST \
  http://[HOST NAME HERE]/login_check \
  -H 'Cache-Control: no-cache' \
  -H 'Content-Type: application/json' \
      -d '{
      "username": "johndoe@example.org",
      "password": "testpass"
    }'

-> Response: 200
  Body: {"token": "[JWT TOKEN]"}

```

### Access protected route:
```shell
$ curl -H "Authorization: Bearer [TOKEN]" http://[HOST NAME HERE]/api/me
-> {
        "id": "fd9999ff-0f13-4c52-a973-915217d591d1",
        "first_name": "John",
        "last_name": "Doe",
        "email": "johndoe@example.org",
        "created_at": "2018-06-12T11:55:36+00:00",
        "updated_at": "2018-06-12T11:55:36+00:00",
        "_links": {
            "self": {
                "href": "/api/users/fd9999ff-0f13-4c52-a973-915217d591d1"
            }
        }
    }
```
