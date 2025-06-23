FROM php:8.2-fpm

# Set working directory
WORKDIR /var/www

# Tambah sources.list manual karena image Debian minimal tidak menyertakan default sources
RUN echo "deb https://deb.debian.org/debian bookworm main" > /etc/apt/sources.list && \
    echo "deb https://deb.debian.org/debian bookworm-updates main" >> /etc/apt/sources.list && \
    echo "deb https://deb.debian.org/debian-security bookworm-security main" >> /etc/apt/sources.list

# Install utilitas dasar dan MSSQL ODBC driver + ekstensi PHP sqlsrv
RUN apt-get update && apt-get install -y \
        gnupg2 \
        curl \
        unixodbc-dev \
    && curl https://packages.microsoft.com/keys/microsoft.asc | apt-key add - \
    && curl https://packages.microsoft.com/config/ubuntu/20.04/prod.list > /etc/apt/sources.list.d/mssql-release.list \
    && apt-get update && ACCEPT_EULA=Y apt-get install -y --no-install-recommends msodbcsql18 \
    && pecl install sqlsrv pdo_sqlsrv \
    && docker-php-ext-enable sqlsrv pdo_sqlsrv

# Install PHP extensions dan dependencies umum Laravel
RUN apt-get update && apt-get install -y \
        cron \
        procps \
        supervisor\
        libonig-dev \
        libxml2-dev \
        libzip-dev \
        libpng-dev \
        libjpeg-dev \
        libfreetype-dev \
        libcurl4-openssl-dev \
        libpq-dev \
        supervisor \
        zip unzip \
        postgresql-client \
        smbclient \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd pdo_mysql mbstring exif pcntl bcmath zip curl pdo_pgsql \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Bypass OpenSSL sec level untuk kompatibilitas dengan driver tertentu
RUN echo 'legacy = default@secp384r1' >> /etc/ssl/openssl.cnf && \
    echo 'openssl_conf = openssl_init' >> /etc/ssl/openssl.cnf && \
    echo '[openssl_init]' >> /etc/ssl/openssl.cnf && \
    echo 'ssl_conf = ssl_sect' >> /etc/ssl/openssl.cnf && \
    echo '[ssl_sect]' >> /etc/ssl/openssl.cnf && \
    echo 'system_default = system_default_sect' >> /etc/ssl/openssl.cnf && \
    echo '[system_default_sect]' >> /etc/ssl/openssl.cnf && \
    echo 'CipherString = DEFAULT:@SECLEVEL=0' >> /etc/ssl/openssl.cnf

# Tambahkan Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy aplikasi dan konfigurasi PHP
COPY ./app ./
COPY ./php/php.ini /usr/local/etc/php/php.ini

# Install dependensi PHP
#RUN composer install --ignore-platform-req=ext-mysql_xdevapi

# Permission untuk Laravel
RUN sed 's_@php artisan package:discover_/bin/true_;' -i composer.json \
    && composer install --ignore-platform-req=php --no-dev --optimize-autoloader \
    && composer clear-cache \
    && php artisan package:discover --ansi \
    && chmod -R 775 storage \
    && chown -R www-data:www-data storage \
    && mkdir -p storage/framework/sessions storage/framework/views storage/framework/cache

COPY ./scripts/php-fpm-entrypoint /usr/local/bin/php-entrypoint

RUN chmod a+x /usr/local/bin/*
# Hapus config default yang masih pakai port 9000
RUN rm -f /usr/local/etc/php-fpm.d/www.conf.default /usr/local/etc/php-fpm.d/zz-docker.conf
ENTRYPOINT ["/usr/local/bin/php-entrypoint"]
EXPOSE 9001

COPY ./php/www.conf /usr/local/etc/php-fpm.d/www.conf

CMD ["php-fpm", "-F"]
