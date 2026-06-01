<?php
if (! defined('ABSPATH')) {
	die('Direct access forbidden.');
}

add_action('rest_api_init', function () {


register_rest_route('ebinforepo/v1', '/resources', [
  'methods' => 'GET',
  'permission_callback' => '__return_true',
  'callback' => 'get_resources_handler',
]);

  register_rest_field('inforepo_resource', 'featured_image_url', [
  'get_callback' => function($post) {
    return get_the_post_thumbnail_url($post['id'], 'full');
  }
]);

// CREATE REST ENDPOINT IN WP FOR CURRENT USER
  register_rest_route('ebinforepo/v1', '/me', [
    'methods' => 'GET',
    'permission_callback' => function () {
      return is_user_logged_in();
    },
    'callback' => function () {
      $user = wp_get_current_user();

      return [
        'id' => $user->ID,
        'roles' => $user->roles,
        'caps' => $user->allcaps,
      ];
    }
  ]);

// CREATE REST ENDPOINT IN WP FOR FILTERS
  register_rest_route('ebinforepo/v1', '/filters', [
  'methods' => 'GET',
  'permission_callback' => '__return_true',
  'callback' => 'inforepo_get_filters',
]);

});
