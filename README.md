Calculator

### Installation

To run the project easily, we should have docker installed locally.

`docker build -t 7shifts .`

`docker run -it --rm --name 7shifts-test 7shifts composer install`

### Usage

Once the image gets built, run the following command where INPUT_TO_TEST is going to be any input to sum.

`docker run -it --rm --name 7shifts-test 7shifts php index.php INPUT_TO_TEST`

e.g

`docker run -it --rm --name 7shifts-test 7shifts php index.php '//@\n2@3@8'`

### Tests

`docker run -it --rm --name 7shifts-test 7shifts vendor/bin/phpunit tests --debug`
