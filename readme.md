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
- [Docker]
- [Docker Compose]

## Instalation 

Clone this repository
```sh
$ git clone https://github.com/hsiemon/Laravel_VoucherPool.git
```

Install Docker
https://docs.docker.com/install/

Install Docker Compose
https://docs.docker.com/compose/install/

Copy the .env
```sh
$ cp .env.testing .env
```

Run the container
```sh
$ docker-compose up -d
```

Install dependencies
```sh
$ docker-compose exec app composer install
```

Runs the migration
```sh
$ docker-compose exec app php artisan migrate
```

Access http://localhost:8080

Generate your vouchers!