# Builds the WordPress side of everywhereborder.org for the Droplet.
#
# This repo is a full Pantheon WordPress checkout (core + wp-content
# together), so the image just needs PHP-FPM with the right extensions,
# the code copied in, and this container's own wp-config-local.php.
# wp-config.php already knows to load that file when PANTHEON_ENVIRONMENT
# isn't set — nothing in wp-config.php had to change for this to work.

FROM php:8.2-fpm

RUN apt-get update && apt-get install -y --no-install-recommends \
        libzip-dev libjpeg-dev libpng-dev libwebp-dev libfreetype6-dev \
        libicu-dev default-mysql-client less rsync \
    && docker-php-ext-configure gd --with-jpeg --with-webp --with-freetype \
    && docker-php-ext-install -j"$(nproc)" mysqli gd zip intl exif opcache \
    && rm -rf /var/lib/apt/lists/*

# WP-CLI: used by the entrypoint/ops scripts for `wp cron event run` and,
# once, for `wp search-replace` when the DB dump first lands here.
RUN curl -fsSL -o /usr/local/bin/wp \
        https://raw.githubusercontent.com/wp-cli/builds/gh-pages/phar/wp-cli.phar \
    && chmod +x /usr/local/bin/wp

COPY php.ini-overrides.ini /usr/local/etc/php/conf.d/zz-eb-overrides.ini

# The code is baked in at /usr/src/eb-wp, NOT /var/www/html. /var/www/html is
# a named volume shared with the nginx container, and Docker only fills a
# named volume from the image the first time it is created — later image
# rebuilds would never reach it. The entrypoint rsyncs this copy into the
# volume on every start, so a redeploy actually updates the running code.
WORKDIR /var/www/html
COPY . /usr/src/eb-wp
COPY docker/wp-config-docker.php /usr/src/eb-wp/wp-config-local.php
COPY docker/entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh

ENTRYPOINT ["entrypoint.sh"]
CMD ["php-fpm"]
