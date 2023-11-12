# ShipMonk PHP assignment: SortedLinkedList library

Adam Šánta, adamsanta01@gmail.com

## Requirements & how to run
- PHP 8.2 with Composer, preferably in Docker container (see `docker-compose.yml` and `docker/php/Dockerfile`) 
- Build and run preferably by calling `docker compose up -d`
  - Will call `composer install` for you automatically 

## Tools
- phpstan for static analysis `vendor/bin/phpstan`, see configuration in `phpstan.dist.neon`
- php_codesniffer for formatting `vendor/bin/phpcbf`, see configuration in `phpcs.xml.dist`
- phpunit for simple unit testing `vendor/bin/phpunit tests`

## Remarks
- Possible extensions:
  - `SortedLinkedList` could implement `IteratorAggregate` interface
  - `SortedLinkedList` could implement `Serializable` interface
    - Problem if list elements aren't serializable
