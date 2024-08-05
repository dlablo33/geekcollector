# Use the official PHP 8.1 image
FROM php:8.1.29-zts-alpine3.20

#RUN  apt-get update && apt-get install -y libicu-dev

RUN apk add --no-cache autoconf build-base --virtual build_deps && \
    apk add --no-cache icu-dev libxml2-dev libpng-dev libxslt-dev libzip-dev jpeg-dev libwebp-dev freetype-dev && \
    docker-php-ext-configure gd --with-jpeg --with-webp --with-freetype && \
    docker-php-ext-install bcmath pdo pdo_mysql mysqli intl soap gd xsl zip sockets
#RUN apt-get update && apt-get install -y librabbitmq-dev && pecl install amqp
#RUN docker-php-ext-enable amqp

  # Set the working directory
WORKDIR ../../../

  # Copy the Laravel application files
#COPY ../../.. .

  # Install Composer dependencies
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
#RUN composer install

  # Expose the port on which the application will run (adjust this port if needed)
#EXPOSE 8000

  # Start the Laravel development server
 #CMD php --host=0.0.0.0 --port=8000
ENTRYPOINT ["docker-php-entrypoint"]

CMD ["php", "-a"]
