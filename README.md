## Simple API endpoint to show /products

### How to run the project on local environment (docker dependency):
1. Build and run the project
``docker-compose up -d --build``
2. Install framework dependencies 
``docker-compose run --rm composer install``
3. Generate secret key 
``docker-compose run --rm php php artisan key:generate``
4. copy .env.example .env in ``src`` directory


The application is listening on port ``8085`` so the app full url is: ``localhost:8085``

To run the tests, just execute:
``docker-compose run --rm php ./vendor/bin/phpunit``