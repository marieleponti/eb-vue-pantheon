<?php
/**
 * Carga Leaflet + nuestro JS/CSS de admin SOLO en la pantalla de edición
 * de inforepo_resource (no en todo wp-admin).
 *
 * v2: usa get_current_screen() en vez de global $post — más confiable,
 * porque global $post no siempre está poblado en el momento exacto en
 * que ACF dispara este hook. Si querés confirmar que esto se está
 * ejecutando, mirá wp-content/debug.log después de recargar la edición
 * de un resource (deja un error_log() temporal abajo).
 */

if (!defined('ABSPATH')) {
	die('Direct access forbidden.');
}

add_action('acf/input/admin_enqueue_scripts', function () {
	$screen = function_exists('get_current_screen') ? get_current_screen() : null;

	$post_type = null;
	if ($screen && !empty($screen->post_type)) {
		$post_type = $screen->post_type;
	} elseif (isset($_GET['post'])) {
		$post_type = get_post_type((int) $_GET['post']);
	}

	error_log('[location-picker] acf/input/admin_enqueue_scripts disparado. post_type detectado: ' . var_export($post_type, true));

	if ($post_type !== 'inforepo_resource') {
		return;
	}

	error_log('[location-picker] Encolando Leaflet + location-picker.js/css');

	wp_enqueue_style('leaflet', 'https://unpkg.com/leaflet@1.9.4/dist/leaflet.css', [], '1.9.4');
	wp_enqueue_script('leaflet', 'https://unpkg.com/leaflet@1.9.4/dist/leaflet.js', [], '1.9.4', true);

	$base_uri = get_stylesheet_directory_uri() . '/assets/admin';
	$base_path = get_stylesheet_directory() . '/assets/admin';

	wp_enqueue_style(
		'inforepo-location-picker',
		$base_uri . '/location-picker.css',
		[],
		file_exists($base_path . '/location-picker.css') ? filemtime($base_path . '/location-picker.css') : null
	);

	wp_enqueue_script(
		'inforepo-location-picker',
		$base_uri . '/location-picker.js',
		['acf-input', 'jquery', 'leaflet'],
		file_exists($base_path . '/location-picker.js') ? filemtime($base_path . '/location-picker.js') : null,
		true
	);

	if (!file_exists($base_path . '/location-picker.js')) {
		error_log('[location-picker] OJO: no se encontró location-picker.js en ' . $base_path);
	}
});