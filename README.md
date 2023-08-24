# Pet Shop API

> A Laravel Pet Shop API 

## Description
This project was built with Laravel and MySQL.

## Running the Application

### With Docker
To run the Application, you must install:
- **Docker** (https://www.docker.com/products/docker-desktop)

Then run this command in project root - This will install dependencies, migrate and also seed into the database
```console
$ make install
```

You should be able to visit your app at http://localhost:8080

### Environment
An `.env` is auto created from `.env.example` on project install you can change any of the values as needed. 

# API documentation:
([Link to Swagger Documentation](http://localhost:8080/api/documentation))

Generate swagger docs:
```console
$ make generate-docs
```

## Testing
To run tests:
```console
$ make run-tests
```

## Code Insights
To run code insight:
```console
$ make php-insights
```

# Restart application
```console
$ make restart
```

# Re-Install Project
```console
$ make re-install
```

## Additional commands

```console
$ make down
$ make up
$ make down
$ make migrate
```
