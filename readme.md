# Catalog

Product catalog manager with support to spreadsheet import

## Getting Started

You will need docker and docker-compose installed in your machine:

* [Docker Engine](https://docs.docker.com/engine)
* [Docker Compose](https://docs.docker.com/compose)

Given docker is installed, all you need is to start docker-compose. The project will be acessible at http://localhost:8000

```
$ docker-compose up
```

To access container shell like artisan use the following command:

```
$ docker-compose exec app bash
```

## Testing

You can run browser tests with:

```
$ ./run-dusk.sh
```

```
$ ./run-phpunit.sh
```
