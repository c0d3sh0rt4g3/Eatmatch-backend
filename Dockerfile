# Use an official PHP runtime as a parent image
FROM php:8.2-fpm

# Install dependencies
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    git \
    curl \
    zip \
    unzip \
    supervisor

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip

# Create the directory for Composer
RUN mkdir -p /usr/local/bin

# Install Composer using the official Docker image
COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

# Set the working directory in the container
WORKDIR /usr/src

# Copy the current directory contents into the container at /usr/src
COPY ../../../.. .

# Update Composer dependencies
RUN php /usr/local/bin/composer update --no-interaction --no-dev --prefer-dist

# Make port 9000 available to the world outside this container
EXPOSE 9000

# Run command when the container launches
CMD ["php-fpm"]
