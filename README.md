<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

# Laravel-Project-Boilerplate

> Simple Boilerplate Laravel Project for Building Web Application or Web Service (API)

## Inside this template?

-   Laravel-backup
-   Larecipe for Create Rest API Documentation
-   [Stisla admin template](https://getstisla.com/)

## Install

Download from branch `master`

```
git clone https://github.com/erpeel-a/Boilerplate-Laravel-Project
```

Install composer dependencies

```
composer install
```

Copy .env.example to .env

```
cp .env.example .env
```

Generate application key

```
php artisan key:generate
```

Create a new Database & setting `.env` then run migration and seeder

```
php artisan migrate --seed
```

---
