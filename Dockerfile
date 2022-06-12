FROM php:8.1-cli
COPY . /usr/src/app
WORKDIR /usr/src/app
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
CMD [ "php", "./index.php" ]
