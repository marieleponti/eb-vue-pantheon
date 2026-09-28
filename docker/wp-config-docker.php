<?php
/**
 * Local config used when this codebase runs in the Droplet's Docker
 * containers instead of on Pantheon. wp-config.php already knows to load
 * a file named wp-config-local.php when PANTHEON_ENVIRONMENT is not set
 * (see the top of wp-config.php) — the Dockerfile copies this file to
 * wp-config-local.php inside the image, so nothing in wp-config.php itself
 * needs to change.
 *
 * Every value here comes from the container's environment (set in
 * docker-compose's `environment:` block), never hardcoded, so the same
 * image works for the test subdomain and for production.
 */

define( 'DB_NAME', getenv( 'WORDPRESS_DB_NAME' ) );
define( 'DB_USER', getenv( 'WORDPRESS_DB_USER' ) );
define( 'DB_PASSWORD', getenv( 'WORDPRESS_DB_PASSWORD' ) );
define( 'DB_HOST', getenv( 'WORDPRESS_DB_HOST' ) );
define( 'DB_CHARSET', 'utf8mb4' );
define( 'DB_COLLATE', '' );

define( 'AUTH_KEY', getenv( 'WORDPRESS_AUTH_KEY' ) );
define( 'SECURE_AUTH_KEY', getenv( 'WORDPRESS_SECURE_AUTH_KEY' ) );
define( 'LOGGED_IN_KEY', getenv( 'WORDPRESS_LOGGED_IN_KEY' ) );
define( 'NONCE_KEY', getenv( 'WORDPRESS_NONCE_KEY' ) );
define( 'AUTH_SALT', getenv( 'WORDPRESS_AUTH_SALT' ) );
define( 'SECURE_AUTH_SALT', getenv( 'WORDPRESS_SECURE_AUTH_SALT' ) );
define( 'LOGGED_IN_SALT', getenv( 'WORDPRESS_LOGGED_IN_SALT' ) );
define( 'NONCE_SALT', getenv( 'WORDPRESS_NONCE_SALT' ) );

// getenv('WORDPRESS_DEBUG') is the string "true"/"false", not a real bool.
define( 'WP_DEBUG', getenv( 'WORDPRESS_DEBUG' ) === 'true' );
define( 'WP_DEBUG_LOG', getenv( 'WORDPRESS_DEBUG' ) === 'true' );
define( 'WP_DEBUG_DISPLAY', false );

define( 'WP_HOME', getenv( 'WORDPRESS_HOME_URL' ) );
define( 'WP_SITEURL', getenv( 'WORDPRESS_HOME_URL' ) );

define( 'WP_AUTO_UPDATE_CORE', false );

// wp-config-pantheon.php sets this to true and relies on Pantheon's own
// infra to run `wp cron event run` on a schedule instead. Off Pantheon we
// keep WP's own cron, but drive it from a real system cron hitting
// wp-cron.php on an interval instead of firing on every page load — see
// ops/wp-cron.sh in the infra folder.
define( 'DISABLE_WP_CRON', true );

// The site sits behind the Droplet's nginx, which terminates TLS. WordPress
// needs to be told the original request was HTTPS, otherwise it generates
// http:// links and the login cookie check fails.
if ( isset( $_SERVER['HTTP_X_FORWARDED_PROTO'] ) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https' ) {
	$_SERVER['HTTPS'] = 'on';
}
