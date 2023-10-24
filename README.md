<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

# Web Development 2 Assignment - Backend in Laravel

This is the backend application for the web development 2 assignment.

## run project:

`docker compose up -d` <br />
`docker-compose-watch`

## Docker compose

`docker compose up -d webdev2_backend_db` <br />
`docker compose up -d phpmyadminpanel`<br />
`docker compose up -d --build webdev2_backend`<br />

## Access database

`docker exec -it webdev2_backend_db mysql -u root -p`<br />
`GRANT ALL PRIVILEGES ON webdev2_backend_db.* TO 'admin'@'%';`<br />
`FLUSH PRIVILEGES;`<br />
`CREATE DATABASE webdev2_backend_db;`<br />
`EXIT;`

## Create model and controller class

`php artisan make:model ModelName -m`
`php artisan make:controller ControllerName -m --resource`

## Migrate database

`docker exec webdev2_backend php artisan migrate`

## Remove containers

`docker compose down -v`
