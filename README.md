
## Installation

Start the containers. Note that it assumes no service is listening to 8000 and 3306 ports.
The 3306 port is optional and can be removed from the docker-compose.yml assuming that the
`php artisan` commands are executed via `docker-compose`.

	docker-compose up -d

Copy .env.example to .env and modify the credentials if necessary.

Run the following commands:

    docker-compose exec carsguide composer install
    docker-compose exec carsguide php artisan migrate
    docker-compose exec carsguide php artisan test
    docker-compose exec carsguide php artisan db:seed

If you chose to bind to the local 3306 port, alternatively could run the following:

    php artisan migrate
    php artisan test
    php artisan db:seed

## ToDo

- API authentication via JWT Token
- Implement Redis cache
- Implement a proper cache eviction

## Routes
* [List of the routes](apidocument.md)


