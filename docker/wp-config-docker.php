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

// WP_DEBUG, WP_DEBUG_LOG and WP_DEBUG_DISPLAY are NOT defined here on purpose:
// wp-config.php defines them itself right after loading this file, and a
// second define() makes PHP print "Constant already defined" warnings. With
// display_errors on, those land inside HTTP responses and corrupt the JSON the
// frontend reads from /wp-json/.

define( 'WP_HOME', getenv( 'WORDPRESS_HOME_URL' ) );
define( 'WP_SITEURL', getenv( 'WORDPRESS_HOME_URL' ) );

define( 'WP_AUTO_UPDATE_CORE', false );

// Same as Pantheon's live environment: git is the source of truth for code.
// A plugin installed through wp-admin would be wiped by the next deploy's
// rsync, so the install/update UI is switched off. Set
// WORDPRESS_ALLOW_FILE_MODS=true in .env.eb only for a deliberate, one-off
// exception (e.g. running a migration plugin on the test site).
define( 'DISALLOW_FILE_MODS', getenv( 'WORDPRESS_ALLOW_FILE_MODS' ) !== 'true' );

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
