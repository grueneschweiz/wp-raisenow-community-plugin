FROM wordpress

# Add xdebug
RUN pecl install xdebug
RUN docker-php-ext-enable xdebug