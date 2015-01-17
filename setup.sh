#!/bin/sh

# Install Composer
curl -sS https://getcomposer.org/installer | php

# Download all required composer packages
./composer.phar install

# Setup Laravel With a new encryption key and migrate the database tables into existence
php artisan key:generate
php artisan optimize

# Build the DB Tables
php artisan migrate:install
php artisan migrate
