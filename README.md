# Food Hut

## Requirements

- PHP 8.1
- Laravel 10
- MailHog
- Redis
- MySQL

## Project setup

```shell
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
php artisan cache:clear
php artisan queue:work
```

### Run npm server

```shell
npm install && npm run dev
```

### Run development server

```shell
php artisan serve
```

### Run tests

```shell
php artisan test
```

### Generate documentation

```shell
php artisan scribe:generate
```
