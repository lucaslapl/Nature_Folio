FROM php:8.3-apache

RUN docker-php-ext-install pdo_mysql

RUN a2enmod rewrite headers expires

# Permet la prise en compte du .htaccess à la racine du site
RUN printf '<Directory /var/www/html>\n    AllowOverride All\n</Directory>\n' \
    > /etc/apache2/conf-available/override.conf \
    && a2enconf override \
    && echo "ServerName localhost" >> /etc/apache2/apache2.conf

# Uploads : le site refuse les images > 2 Mo, on garde de la marge
RUN { \
    echo "upload_max_filesize = 6M"; \
    echo "post_max_size = 14M"; \
} > /usr/local/etc/php/conf.d/uploads.ini

COPY . /var/www/html/

# En local (Docker), autorise aussi localhost comme referer pour les images,
# sinon la règle anti-hotlinking du .htaccess bloque les images en navigation.
RUN if [ -f /var/www/html/.htaccess ]; then \
    sed -i 's#nature\\.lucaslaplanche\\.fr \[NC\]#(nature\\.lucaslaplanche\\.fr\|localhost\|127\\.0\\.0\\.1)(:[0-9]+)? [NC]#' /var/www/html/.htaccess; \
    fi
