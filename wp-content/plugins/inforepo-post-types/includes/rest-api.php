<?php
if (! defined('ABSPATH')) {
	die('Direct access forbidden.');
}

add_action('rest_api_init', function () {

//PUBLIC -> REST ROUTE FOR PUBLIC RESOURCES
  register_rest_route('ebinforepo/v1', '/resources', [
    'methods' => 'GET',
    'callback' => 'get_public_resources',
    'permission_callback' => '__return_true',
  ]);

  //PRIVATE -> REST ROUTE FOR PRIVATE RESOURCES
  register_rest_route('ebinforepo/v1', '/community-resources', [
    'methods' => 'GET',
    'callback' => 'get_private_resources',
    'permission_callback' => function () {
        return is_user_logged_in() && current_user_can('read_private_posts');
    }
  ]);

});

function get_private_resources() {
  return get_posts([
    'post_type' => 'inforepo_resource',
    'post_status' => ['publish', 'private'],
    'numberposts' => -1,
  ]);
}

function get_public_resources() {

    return get_posts([
        'post_type' => 'inforepo_resource',
        'post_status' => 'publish',
        'numberposts' => -1,
    ]);

}

function inforepo_get_filters()
{
    return rest_ensure_response(get_filters_data());
}


