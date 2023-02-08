## Getting started:

Running with docker compose locally:

From the project root, run 
`composer install` then
`./vendor/bin/sails up`

`php artisan migrate:fresh --seed`
`php artisan passport:install`

Make sure to also copy the contents of .env.example into .env within your project root.



Run initial migrations:
