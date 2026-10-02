#!/usr/bin/env bash
#
# Runs once each time the WordPress container starts.
#
#   - Waits for MariaDB to accept connections (docker-compose's
#     depends_on only waits for the container to start, not for MySQL
#     inside it to actually be ready).
#   - Fixes ownership on wp-content/uploads, which lives on a named volume
#     and starts out owned by root.
#   - Hands off to the command in the Dockerfile (php-fpm).

set -euo pipefail

echo "Waiting for the database at ${WORDPRESS_DB_HOST}..."
until php -r "
    \$parts = explode(':', getenv('WORDPRESS_DB_HOST'));
    \$host = \$parts[0];
    \$port = \$parts[1] ?? 3306;
    \$c = @fsockopen(\$host, (int) \$port, \$errno, \$errstr, 2);
    if (!\$c) { exit(1); }
    fclose(\$c);
" ; do
  sleep 2
done
echo "Database is reachable."

echo "Syncing code into /var/www/html..."
# --delete drops files removed from the repo; uploads live on their own
# volume and are excluded so they are never touched.
rsync -a --delete --chown=www-data:www-data \
    --exclude 'wp-content/uploads' \
    /usr/src/eb-wp/ /var/www/html/

mkdir -p /var/www/html/wp-content/uploads
chown -R www-data:www-data /var/www/html/wp-content/uploads

exec "$@"
