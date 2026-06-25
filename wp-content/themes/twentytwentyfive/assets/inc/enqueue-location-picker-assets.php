<?php
/**
 * Carga Leaflet + nuestro JS/CSS de admin SOLO en la pantalla de edición
 * de inforepo_resource (no en todo wp-admin).
 *
 * v3: en vez de escribir a debug.log (que no siempre es accesible),
 * muestra un aviso visible arriba de la pantalla de edición con lo que
 * detectó. Borrá este archivo aviso temporal una vez que el mapa
 * funcione — es solo para diagnosticar.
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

	$base_path = get_stylesheet_directory() . '/assets/admin';
	$js_exists = file_exists($base_path . '/location-picker.js');
	$css_exists = file_exists($base_path . '/location-picker.css');

	// Aviso visible en pantalla, no en logs.
	add_action('admin_notices', function () use ($post_type, $js_exists, $css_exists, $base_path) {
		echo '<div class="notice notice-info"><p><strong>[location-picker debug]</strong> ';
		echo 'post_type detectado: <code>' . esc_html(var_export($post_type, true)) . '</code> | ';
		echo 'location-picker.js existe: <code>' . ($js_exists ? 'SÍ' : 'NO') . '</code> | ';
		echo 'location-picker.css existe: <code>' . ($css_exists ? 'SÍ' : 'NO') . '</code> | ';
		echo 'ruta buscada: <code>' . esc_html($base_path) . '</code>';
		echo '</p></div>';
	});

	if ($post_type !== 'inforepo_resource') {
		return;
	}

	wp_enqueue_style('leaflet', 'https://unpkg.com/leaflet@1.9.4/dist/leaflet.css', [], '1.9.4');
	wp_enqueue_script('leaflet', 'https://unpkg.com/leaflet@1.9.4/dist/leaflet.js', [], '1.9.4', true);

	$base_uri = get_stylesheet_directory_uri() . '/assets/admin';

	wp_enqueue_style(
		'inforepo-location-picker',
		$base_uri . '/location-picker.css',
		[],
		$css_exists ? filemtime($base_path . '/location-picker.css') : null
	);

	wp_enqueue_script(
		'inforepo-location-picker',
		$base_uri . '/location-picker.js',
		['acf-input', 'jquery', 'leaflet'],
		$js_exists ? filemtime($base_path . '/location-picker.js') : null,
		true
	);
});