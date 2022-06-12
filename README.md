Calculator

Installation

`docker build -t 7shifts .`

Usage 

`docker run -it --rm --name 7shifts-test 7shifts php index.php 1\n,2,3`

Tests

`docker run -it --rm --name 7shifts-test 7shifts vendor/bin/phpunit tests --debug`
