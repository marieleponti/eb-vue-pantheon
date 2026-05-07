<?php
if (! defined('ABSPATH')) {
	die('Direct access forbidden.');
}

add_action('rest_api_init', 'inforepo_register_routes');

function inforepo_register_routes() {

    register_rest_route('inforepo/v1', '/filters', [
        'methods'             => 'GET',
        'callback'            => 'inforepo_get_filters',
        'permission_callback' => '__return_true',
    ]);
}

function inforepo_get_filters()
{
    return rest_ensure_response(get_filters_data());
}


