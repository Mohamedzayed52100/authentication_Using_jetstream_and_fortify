## Laravel Jetstream & Fortify - The Complete Guide (Course Files)

**Created By :** Mohamed Ibrahim Zayed
**Email :** mohamedzayed52100@gmail.com

This is the main readme file for the project used in Laravel Jetstream & Fortify for authentication

## Installation

To get started, clone this repository.

```
git clone https://github.com/Mohamedzayed52100/authentication_Using_jetstream_and_fortify.git
```

Next, copy your `.env.example` file as `.env` and configure your Database connection.

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=YOUR-DATABASE-NAME
DB_USERNAME=YOUR-DATABASE-USERNAME
DB_PASSWORD=YOUR-DATABASE-PASSWROD
```

## Run Packages and helpers

You have to all used packages and load helpers as below.

```
composer install
npm install
npm run dev
npm run build
```

## Generate new application key

You have to generate new application key as below.

```
php artisan key:generate
```

## Run Migrations and Seeders

You have to run all the migration files included with the project and also run seeders as below.

```
php artisan migrate
php artisan db:seed
```

## Accessing website

You can access main default page using this url.

```
http://localhost:8000/
```
