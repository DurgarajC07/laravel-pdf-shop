# Laravel PDF Shop Docker Setup

This repository contains a Docker setup for running the Laravel PDF Shop application.

## Prerequisites

- Docker
- Docker Compose

## Directory Structure

After running the setup script, your project should have the following structure:

```
laravel-shop/
├── app/
├── bootstrap/
├── config/
├── database/
├── public/
├── resources/
├── routes/
├── storage/
├── tests/
├── docker-compose.yml
├── Dockerfile
├── nginx/
│   └── conf.d/
│       └── app.conf
├── php/
│   └── local.ini
├── mysql/
│   └── my.cnf
├── setup.sh
└── .env.docker
```

## Getting Started

# Install dependencies
docker-compose exec app composer install

# Generate key
docker-compose exec app php artisan key:generate

# Run migrations
docker-compose exec app php artisan migrate:fresh --seed

# Set permissions
docker-compose exec app chmod -R 775 storage bootstrap/cache
docker-compose exec app chown -R www-data:www-data storage bootstrap/cache

# Create storage link AFTER permissions have been set
docker-compose exec app php artisan storage:link