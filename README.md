# Food Hut

[![Quality Score](https://img.shields.io/scrutinizer/quality/g/ikechukwukalu/foodhut/main?style=flat-square)](https://scrutinizer-ci.com/g/ikechukwukalu/foodhut/)
[![Code Quality](https://img.shields.io/codefactor/grade/github/ikechukwukalu/foodhut?style=flat-square)](https://www.codefactor.io/repository/github/ikechukwukalu/foodhut)
[![Vulnerability](https://img.shields.io/snyk/vulnerabilities/github/ikechukwukalu/foodhut?style=flat-square)](https://snyk.io/test/github/ikechukwukalu/foodhut)
[![Github Workflow Status](https://img.shields.io/github/actions/workflow/status/ikechukwukalu/foodhut/foodhut.yml?branch=main&style=flat-square)](https://github.com/ikechukwukalu/foodhut/actions/workflows/foodhut.yml)

This is a sample REST API that returns JSON as a response.

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
```

### Run development server

```shell
php artisan serve
```

### Run queue worker

```shell
php artisan cache:clear
php artisan queue:work
```

### Run tests

```shell
php artisan test
```

### Generate documentation

```shell
php artisan scribe:generate
```

## Note

- Login credentials

```php
email: testuser@foodhut.com
password: 12345678
```

- After generating the documentation, navigate to `/docs` to view and test the APIs within the generated documentation by clicking on the `TRY IT OUT` button. A POSTMAN collection can also be exported from the documentation.
