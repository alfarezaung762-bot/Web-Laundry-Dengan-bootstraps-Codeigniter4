FROM php:8.2-apache

# Install ekstensi yang dibutuhkan CI4 (termasuk intl yang kemarin sempat error)
RUN apt-get update && apt-get install -y libicu-dev \
    && docker-php-ext-configure intl \
    && docker-php-ext-install intl mysqli pdo pdo_mysql

# Aktifkan mod_rewrite Apache (wajib agar routing CI4 berjalan)
RUN a2enmod rewrite

# Arahkan pintu masuk web langsung ke folder /public
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# Copy semua file project kamu ke dalam server Render
COPY . /var/www/html/

# Berikan izin akses untuk folder writable CI4
RUN chown -R www-data:www-data /var/www/html/writable