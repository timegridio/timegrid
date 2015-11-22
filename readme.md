<a href="http://www.timegrid.io/">
    <img src="http://i.imgur.com/905Lv7L.png" alt="timegrid.io logo"
         title="timegrid.io" align="right" />
</a>

timegrid
============

[![Code Climate](https://codeclimate.com/github/alariva/timegrid/badges/gpa.svg)](https://codeclimate.com/github/alariva/timegrid)
[![Test Coverage](https://codeclimate.com/github/alariva/timegrid/badges/coverage.svg)](https://codeclimate.com/github/alariva/timegrid/coverage)
[![Join the chat at https://gitter.im/alariva/timegridDevelopment](https://badges.gitter.im/Join%20Chat.svg)](https://gitter.im/alariva/timegridDevelopment?utm_source=badge&utm_medium=badge&utm_campaign=pr-badge&utm_content=badge)
[![ES User Manual](https://readthedocs.org/projects/manual-de-usuario-de-timegridio/badge/?version=latest&style=flat-square)](http://manual-de-usuario-de-timegridio.readthedocs.org/es/latest/?badge=latest)
[![Version Stage](https://img.shields.io/badge/dev--beta-3.4.x-orange.svg?style=flat-square)](http://demo.timegrid.io/)
[![Project Status](https://stillmaintained.com/alariva/timegrid.png)](https://stillmaintained.com/alariva/timegrid)
[![License](https://img.shields.io/:license-AGPL--3.0-blue.svg?style=flat-square)](http://www.gnu.org/licenses/agpl-3.0.txt)

Timegrid is a web application for online reservation of services for business.

It is currently in **beta** stage willing to add some missing functions in the short terms.

It is made under the **Laravel 5** framework for **PHP**.

![Screenshot](http://i.imgur.com/aiG7jlx.png)

## Live Demo

You can try the *beta stage* working [live demo](http://demo.timegrid.io/)

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

A lot of work is taking place here, and counting, please be patient :)

  * [![English Documentation Status](https://readthedocs.org/projects/timegrid-user-manual/badge/?version=latest)](http://manual-de-usuario-de-timegridio.readthedocs.org/en/latest/?badge=latest) English
  * [![Spanish Documentation Status](https://readthedocs.org/projects/manual-de-usuario-de-timegridio/badge/?version=latest)](http://manual-de-usuario-de-timegridio.readthedocs.org/es/latest/?badge=latest) Español

You are welcome to contribute.

-----
## How to install:

* [Step 1: Get the code](#step1)
* [Step 2: Use Composer to install dependencies](#step2)
* [Step 3: Create database](#step3)
* [Step 4: Install](#step4)
* [Step 5: Start Page](#step5)

<a name="step1"></a>
### Step 1: Get the code - Clone the repository

    git clone https://github.com/alariva/timegrid.git
    
If you want to stand on the latest beta-stable version:

    cd timegrid

    git checkout tags/v3.4.2-beta

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
### Step 4: Configure environment

**Copy** the **.env.example** file to **.env**

    cp .env.example .env

Set the application key

    php artisan key:generate

**Edit** all the Primary section parameters (for *local/test/development environment*)

**Change** the storage path in **.env** file to a writeable location

    STORAGE_PATH=/home/username/timegrid/storage

For **local** environment you will need to comment out APP_DOMAIN, to keep it *null*

    #APP_DOMAIN=

Back to your console, migrate database schema

    php artisan migrate

Populate database:

    php artisan db:seed
    
Update [geoip](https://github.com/Torann/laravel-geoip) database:

    php artisan geoip:update

You should be ready to go, now run the server:

    php artisan serve

Type on web browser:

    http://localhost:8000/

-----
<a name="step5"></a>
### Step 5: Start Page

Congrats! You can now register as new user and log-in.

![timegrid Login Screen](http://i.imgur.com/jM8pbGq.png)

## Troubleshooting

I'd like to [hear your feedback](https://timegrid.slack.com/messages/general/).

Let me know if you are facing any inconvenients to install, as I'm working on bringing a more comprehensive installation guide assessing common problems.

## Contributing

Thank you for considering contributing to Timegrid.

Please see CONTRIBUTING doc for further details.
You are welcome to join the core development team and enhance the development process apart from just code :)

[Join the Trello board for development roadmap](https://trello.com/b/VNFqnxhc/timegrid-io-dev)

[Join the Slack for technical discussion](https://timegrid.slack.com/home)

[Stay up-to-date with Twitter](https://twitter.com/timegrid_io/)

[Stay up-to-date with Facebook](https://www.facebook.com/timegrid.io/)

[Dev Newsletter](http://eepurl.com/bF_ARX)

## Special Thanks

  * [PeGa!](http://ar.linkedin.com/in/pabloegonzalez)

### License

Timegrid is open-sourced software licensed under the [AGPL](http://www.gnu.org/licenses/agpl-3.0-standalone.html)
