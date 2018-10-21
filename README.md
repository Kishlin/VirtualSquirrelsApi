Virtual Squirrels Api
=====================


![GitHub package version](https://img.shields.io/badge/package-0.1.0-red.svg)

[![licence](https://img.shields.io/packagist/l/doctrine/orm.svg)](https://spdx.org/licenses/MIT)
[![symfony](https://img.shields.io/badge/symfony-v3.4-yellow.svg)](https://symfony.com/)
[![doctrine](https://img.shields.io/badge/doctrine-v2.5.14-green.svg)](https://www.doctrine.fr/)
[![phpunit](https://img.shields.io/badge/phpunit-v7.0.0-magenta.svg)](https://phpunit.de/)


This project is the api for the guild website of [Oh My Gosh Virtual Squirrels](http://virtualsquirrels.fr/).


TO DO
-----

#### Road map to first release:

* User

Change email / details.

Password reset.

* Events

Events should have a creator.

Creating an event should auto add a participation.

Event creator can force participation.

Event creator can update self events.

Event edition / deletion.

* Notifications

Notification sender API-wise.

Send notifications when need be.

* Applications

Not started yet. Everything is left to do.

Votes and discussion feed for members. With and without the applicant.

Installation & Usage
--------------------

* Clone this repo.

````bash
git clone https://github.com/Kishlin/VirtualSquirrelsApi.git
cd VirtualSquirrelsApi
````

* Set up dependencies.

````bash
composer install
````

* Create your `app/config/parameters.yml` locally.

Use `app/config/parameters.yml.dist` as base template.

* Database

````bash
php bin/console doctrine:database:create
php bin/console doctrine:schema:update --force-sql
````

* Start development server.

````bash
php bin/console server:run
````


Testing
-------

````bash
vendor/bin/phpunit -c path/to/phpunit.xml src/
````


Contributing
------------

- Fork the project locally.
- Make changes to a new branch named after your feature.
- Open a pull request for a merge to the [dev](https://github.com/Kishlin/VirtualSquirrelsApi/tree/dev) branch.


About
-----

This project is a [Virtual Squirrels](http://virtualsquirrels.fr/) initiative.
