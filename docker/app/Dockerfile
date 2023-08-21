FROM php:8.2-fpm

WORKDIR /var/www/html

RUN rm -rf /var/www/html

RUN apt-get update && apt-get install -y \
    build-essential \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    locales \
    zip \
    vim \
    unzip \
    git \
    curl \
    libzip-dev \
    apt-utils \
    libonig-dev

RUN docker-php-ext-install zip pdo_mysql mbstring exif
RUN docker-php-ext-configure gd --with-freetype=/usr/include/ --with-jpeg=/usr/include/
RUN docker-php-ext-install gd

# install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
    && composer --ansi --version --no-interaction

RUN groupadd -g 1000 laravel
RUN useradd -u 1000 -ms /bin/bash -g laravel user

COPY --chown=user:laravel . /var/www/html

USER user

EXPOSE 9000

CMD ["php-fpm"]
