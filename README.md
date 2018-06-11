# users-service-prooph
Prooph Event Sourcing Example

```shell
# Bash

$ git clone git@github.com:ambersariya/users-service-prooph.git
$ docker run --rm -it --volume $(pwd):/app prooph/composer:7.2 install
$ docker-compose up -d


$ docker-compose exec php sh
$ bin/console event-store:event-stream:create
$ bin/console doctrine:migrations:migrate

```


