<?php
/**
 * Carga Leaflet + nuestro JS/CSS de admin SOLO en la pantalla de edición
 * de inforepo_resource (no en todo wp-admin).
 *
 * Esto es independiente de cómo creaste el campo "Ubicación" — funciona
 * igual si lo armaste por código o importando acf-field-group-export.json
 * desde Custom Fields > Tools > Import. Lo único que importa es que las
 * *keys* de los campos sean field_location, field_location_search,
 * field_location_lat, field_location_lng (las del JSON de import ya
 * vienen así).
 */

if (!defined('ABSPATH')) {
	die('Direct access forbidden.');
}

add_action('acf/input/admin_enqueue_scripts', function () {
	global $post;

	if (!$post || $post->post_type !== 'inforepo_resource') {
		return;
	}

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
});