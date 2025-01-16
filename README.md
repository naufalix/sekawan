<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>


## Information

### Username and Password


| Role  | Username           | Password  |
|-------|--------------------|-----------|
| Admin | admin@naufal.dev  | admin  |
| Approver  | approver1@naufal.dev   | approver1   |


> **Note:** Additional usernames and passwords can be found in the database seeders.

### Technology Information

-   **Database Version:** MySQL 8.0
    
-   **PHP Version:** 8.2
    
-   **Framework:** Laravel 11
    

## Application Usage Guide

### 1. Clone Repository

Clone the repository from remote to local:

```
git clone <repository-url>
```

### 2. Create .env File

Create a `.env` file in the root folder of the application. You can copy it from `.env.example`:


### 3. Create Database

Create a new database according to the configuration in the `.env` file:

-   Ensure the database name, username, and password match.
    

### 4. Install Dependencies with Composer

Run the following command to install all dependencies:

```
composer install
```

### 5. Run Database Migration and Seeder

Run the migrations and seed the database:

```
php artisan migrate:fresh --seed
```

### 6. Access the Web Application

Start the Laravel server:

```
php artisan serve
```

Open a browser and access the URL provided by the server. Login using the username and password listed above.