FROM php:8.2-fpm
RUN apt-get update && apt-get install -y \
  libfreetype6-dev \
  libjpeg62-turbo-dev \
  libpng-dev \
  libzip-dev \
  locales \
  zip \
  jpegoptim optipng pngquant gifsicle \
  nano \
  nodejs \
  npm \
  yarn \
  unzip \
  git \
  curl \
  && docker-php-ext-configure gd --with-freetype --with-jpeg \
  && docker-php-ext-install -j$(nproc) gd \
  && docker-php-ext-install exif

RUN docker-php-ext-configure zip \
  && docker-php-ext-install zip
# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*
#install mysql extension
RUN docker-php-ext-install mysqli pdo pdo_mysql && docker-php-ext-enable pdo_mysql

# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Add user for laravel application
RUN groupadd -g 1000 www
RUN useradd -u 1000 -ms /bin/bash -g www www


# Copy existing application directory contents
COPY . /var/www


# Copy existing application directory permissions
COPY --chown=www:www . /var/www

# Change current user to www
USER www

# Expose port 9000 and start php-fpm server
EXPOSE 8008
