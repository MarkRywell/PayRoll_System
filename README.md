![image](https://github.com/Phnumbahwan/bondocker/assets/52746589/3358da38-dc69-461e-8b31-928f69753a68)
# BONDOCKER (Bondak/Smash)

This is a basic docker setup. You can use this to your PHP project (Laravel || codeIgniter).

## Prerequisites

Before you begin, make sure you have the following installed on your system:

- [Docker desktop](https://www.docker.com/products/docker-desktop/) (If you are using windows)

## How to use

1. Copy all of this file
2. Paste this to your [laravel](https://laravel.com/) app
3. Run this command to build
```bash
docker-compose build
```
4. Run this command to up your container
```bash
docker-compose up
```
```bash
docker-compose up -d # if you want detachable mode you can run this.
```
5. To run `composer install` you can go to your php container's bash shell just run this command
```bash
docker-compose exec php-fpm bash
```
6. Make sure you are in the correct path
```bash
cd /var/www/html
```
7. Once you're inside the PHP container and in the correct path, run the following commands to set up your Laravel application.
```bash
composer install
php artisan key:generate
php artisan migrate --seed
```
8. You can now visit your app in `localhost` or `127.0.0.1`
9. To stop your container run this command.
```bash
docker-compose stop
```
10. To stop and remove your container
```bash
docker-compose down
```

## Thank you

If you have some questions you can contact me directly: `gilpacturan@gmail.com`
