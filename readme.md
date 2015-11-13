[![Join the chat at https://gitter.im/alariva/timegridDevelopment](https://badges.gitter.im/Join%20Chat.svg)](https://gitter.im/alariva/timegridDevelopment?utm_source=badge&utm_medium=badge&utm_campaign=pr-badge&utm_content=badge)

## Timegrid

Timegrid is a web application for online reservation of services for business.

It is currently in **beta** stage willing to add some missing functions in the short terms.

It is made under the **Laravel 5** framework for **PHP**.

## Features

These are the current features so far:

  * User SignUp process (with email notification)
  * Business registration
  * Business Contacts registration
  * Business Services registration
  * Business Services Availability management (basic)
  * Service Reservation (with email notification)
  * Search engine (basic)

## Official Documentation

To be available soon.

## Online Demo

[Demo](http://demo.timegrid.io/)

-----
## How to install:

* [Step 1: Get the code](#step1)
* [Step 2: Use Composer to install dependencies](#step2)
* [Step 3: Create database](#step3)
* [Step 4: Install](#step4)
* [Step 5: Start Page](#step5)

<a name="step1"></a>
### Step 1: Get the code - Clone the repository

    $ git clone https://github.com/alariva/timegrid.git
    
If you want to stand on the latest beta-stable version:

    $ cd timegrid

    $ git checkout tags/v3.4.1-beta

-----
<a name="step2"></a>
### Step 2: Use Composer to install dependencies

    composer install

-----
<a name="step3"></a>
### Step 3: Create database

If you finished first three steps, now you can create database on your database server(MySQL). You must create database
with utf-8 collation(uft8_general_ci), to install and application work perfectly.
After that, copy .env.example and rename it as .env and put connection and change default database connection name, only database connection, put name database, database username and password.

-----
<a name="step4"></a>
### Step 4: Configure

**Change** the storage path in **.env** file to a writeable location

    STORAGE_PATH=/home/username/timegrid/storage

Migrate database schema

    php artisan migrate

Populate database:

    php artisan db:seed

Run the server:

    php artisan serve

Type on web browser:

    http://localhost:8000/

-----
<a name="step5"></a>
### Step 5: Start Page

You can now register as new user and login.

## Contributing

Thank you for considering contributing to Timegrid.

Please see CONTRIBUTING doc for further details.
You are welcome to join the core development team and enhance the development process apart from just code :)

### License

Timegrid is open-sourced software licensed under the [AGPL](http://www.gnu.org/licenses/agpl-3.0-standalone.html)
