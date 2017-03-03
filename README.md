# Shoe Stores

#### Independent project for Epicodus, 03.03.2017

#### By Patrick McGreevy

## Description

This Silex website for keeping track of shoe stores and the brands they carry.


## Setup/Installation Requirements
1. Set project root as working directory in CLI.
2. Run `$ composer install --prefer-source --no-interaction`.
3. Set document root in MAMP > Preferences to `{PROJECT_ROOT}/web`.
4. Click 'Start Servers' in MAMP.
5. Visit **`localhost:8888`** in web browser.

## Database Setup
```sql
CREATE DATABASE shoes_test;
USE shoes_test;
CREATE TABLE stores (id serial PRIMARY KEY, name VARCHAR(255));
CREATE TABLE brands (id serial PRIMARY KEY, name VARCHAR(255));
CREATE TABLE brands_stores (brand_id BIGINT(20), store_id BIGINT(20));
CREATE DATABASE shoes;
USE shoes;
CREATE TABLE stores (id serial PRIMARY KEY, name VARCHAR(255));
CREATE TABLE brands (id serial PRIMARY KEY, name VARCHAR(255));
CREATE TABLE brands_stores (brand_id BIGINT(20), store_id BIGINT(20));
```

## Technologies Used

HTML

CSS

Bootstrap

PHP

SQL

MySQL

Silex

Twig

Composer

JSON


## Known Bugs

_No known bugs or issues_

### License

Copyright (c) 2017 _**Patrick McGreevy**_

This software is licensed under the MIT license.
