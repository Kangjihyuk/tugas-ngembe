FROM php:8.2-apache

# Instal dependensi sistem yang dibutuhkan untuk curl dan ekstensi PHP
RUN apt-get update && apt-get install -y \
    libcurl4-openssl-dev \
    pkg-config \
    libssl-dev \
    git \
    unzip \
    && docker-php-ext-install curl \
    && a2enmod rewrite \
    && rm -rf /var/lib/apt/lists/*

# Konfigurasi Apache DocumentRoot
ENV APACHE_DOCUMENT_ROOT /var/www/html
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# Salin source code aplikasi
COPY . /var/www/html/

# Atur hak akses kepemilikan file untuk web server
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

EXPOSE 80

CMD ["apache2-foreground"]
