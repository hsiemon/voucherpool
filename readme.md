# VoucherPool

VoucherPool is a web application developed to attend a developer test with the following requirements:

## Functionalities:

- For a given Special Offer and an expiration date generate for each Recipient a
Voucher Code
- Provide an endpoint, reachable via HTTP, which receives a Voucher Code and Email
and validates the Voucher Code. In Case it is valid, return the Percentage Discount
and set the date of usage
- Extra: For a given Email, return all his valid Voucher Codes with the Name of the
Special Offer

## Tasks:

- Design a database schema
- Write an application
- Add an API endpoint for verifying and redeeming vouchers
- The code should be covered by tests
- Write a documentation with code examples for the implemented calls (Postman
collection is a nice-to-have)

## Postman API Doc
https://documenter.getpostman.com/view/5138316/RWToQyBR

## Tech

VoucherPool uses a number of open source projects to work properly:

- [Laravel] - The PHP Framework For Web Artisans
- [Laravel Migrations] - "Version control" for database
- [Composer] - Dependency Manager 
- [Bootstrap] - Front-end framework
- [MySQL] - Relational Database
- [PHPUnit] - Testing Framework
- [PHP 7]

## Instalation 

Clone this repository
```sh
$ git clone https://github.com/hsiemon/Laravel_VoucherPool.git
```

Download composer 
https://getcomposer.org/download/

Install dependencies
```sh
$ php composer.phar install
```

Copy the .env
```sh
$ cp .env.testing .env
```

Change the following lines on .env and .env.testing file with your database credentials
> DB_CONNECTION=mysql
> DB_HOST=127.0.0.1
> DB_PORT=3306
> DB_DATABASE=Test_VoucherPool
> DB_USERNAME=root
> DB_PASSWORD=root

Runs the migration
```sh
$ php artisan migrate
```

Generate your vouchers!