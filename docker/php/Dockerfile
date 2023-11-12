FROM php:8.2-fpm-bullseye

# Install basic deps via apt-get
RUN apt-get clean && apt-get update --allow-insecure-repositories && \
    apt-get install -y --no-install-recommends curl git unzip && \
    apt-get clean && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

WORKDIR /var/www

# Install composer deps
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer
COPY . /var/www
RUN composer i -o
