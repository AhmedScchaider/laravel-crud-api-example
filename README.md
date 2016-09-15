# laravel-api-example
A simple laravel CRUD operations using API approch

### Setup project settings

Use `--recursive` option during cloning this repo

```
cd ~/project-dir

composer install

cp .env.example .env

php artisan key:generate
```

```
cd ~/project-dir/laradock

docker-compose up -d nginx mysql

docker-compose exec workspace bash

php artisan migrate --seed
```
