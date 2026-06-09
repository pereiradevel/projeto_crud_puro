FROM php:8.2-apache

RUN apt-get update \
	&& apt-get install -y default-mysql-client libzip-dev zip unzip \
	&& docker-php-ext-install pdo pdo_mysql \
	&& rm -rf /var/lib/apt/lists/*

RUN a2enmod rewrite

COPY docker-entrypoint.sh /usr/local/bin/docker-entrypoint.sh
RUN chmod +x /usr/local/bin/docker-entrypoint.sh

COPY . /var/www/html/

RUN chown -R www-data:www-data /var/www/html

ENTRYPOINT ["/usr/local/bin/docker-entrypoint.sh"]
CMD ["apache2-foreground"]

EXPOSE 80