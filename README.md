## Getting Started

Simple web application built with laravel and vue for checking if the bakery is open or not.

### Prerequisites

* [Composer](https://getcomposer.org/)
* [Node.js](https://nodejs.org)

### Installation

1. Install composer dependencies ```composer install```
2. Install npm dependencies ```npm install```
3. Compile front end assets and scripts ```npm run dev```
4. Setup ```.env``` file
5. Generate an app encryption key ```php artisan key:generate```
6. Migrate database ```php artisan migrate```
7. Seed database ```php artisan db:seed```

## Technologies used
* [Laravel 10](https://laravel.com/)
* [MySQL](https://www.mysql.com/)
* [Vue](https://vuejs.org/)
* [Inertia.js](https://inertiajs.com/)


## Assumptions & Challenges

The app can be more improve if applied with websockets for realtime data response to check the status of the bakery if it is open or closed.
