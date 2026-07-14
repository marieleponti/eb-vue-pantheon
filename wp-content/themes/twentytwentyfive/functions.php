<?php

/**
 * Twenty Twenty-Five functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package WordPress
 * @subpackage Twenty_Twenty_Five
 * @since Twenty Twenty-Five 1.0
 */

/*-----------------------------------------------------------------------------------------------
Info Repo Custom code start
-------------------------------------------------------------------------------------------------*/
/**
 * Setup site
 */
function inforepo_setup() {
    add_theme_support('post-thumbnails');
    add_theme_support('title-tag');
}
add_action('after_setup_theme', 'inforepo_setup');

$location_picker_assets = get_stylesheet_directory() . '/inc/enqueue-location-picker-assets.php';
if (file_exists($location_picker_assets)) {
	require_once $location_picker_assets;
}

/**
 * Add custom user roles
 * 
 * This function defines user roles for EB Team members, assigned the same privledges 
 * as Wordpress admin, and org members role, assigned contributor roles. 
 * 
 * @param none
 * @return void
 * 
 * @author marieleponti
 * @package inforepo
 * 
 * 
 */
function inforepo_roles_caps() {

  // EB TEAM
  $team = get_role('eb_team');
  if ($team) {
    $team->add_cap('read_private_posts');
    $team->add_cap('edit_posts');
    $team->add_cap('edit_published_posts');
    $team->add_cap('publish_posts');
  }

  // COMMUNITY MEMBER
  $community = get_role('eb_community_member');
  if ($community) {
    $community->add_cap('read_private_posts'); 
  }

}
add_action('init', 'inforepo_roles_caps');


/**
 * Set private
 * 
 * This function sets a page as private when called. 
 *
 * @param null
 * @param null
 * @return void
 * 
 * @author marieleponti
 * @package inforepo for Divi
 * 
 * 
 */


/**
 * Set posts default visibility to private
 * 
 * This function makes the default visibility of a post private. 
 *
 * @param null
 * @param null
 * @return void
 * 
 * @author marieleponti
 * @package inforepo for Divi
 * 
 * 
 */
function default_post_visibility_private()
{
  global $post;

  if ($post->post_status == 'publish') {
    $visibility = 'public';
    $visibility_trans = __('Public');
  } elseif (!empty($post->post_password)) {
    $visibility = 'password';
    $visibility_trans = __('Password protected');
  } elseif ($post->post_type == 'post' && is_sticky($post->ID)) {
    $visibility = 'public';
    $visibility_trans = __('Public, Sticky');
  } else {
    $post->post_password = '';
    $visibility = 'private';
    $visibility_trans = __('Private');
  } ?>

  <script type="text/javascript">
    (function($) {
      try {
        $('#post-visibility-display').text('<?php echo $visibility_trans; ?>');
        $('#hidden-post-visibility').val('<?php echo $visibility; ?>');
        $('#visibility-radio-<?php echo $visibility; ?>').attr('checked', true);
      } catch (err) {}
    })(jQuery);
  </script>
<?php
}
add_action('post_submitbox_misc_actions', 'default_post_visibility_private');


/**
 * Wordpress's default is to precede the title of a private post with 
 * 'Private:'. This function removes this default behavior so that only
 * the title itself appears
 * @package inforepo
 * @author marieleponti
 */
function inforepo_remove_private_protected_titles($title)
{
  // Return only the title portion as defined by %s, not the additional 
  // 'Protected: ' as added in core
  return "%s";
}
add_filter('protected_title_format', 'inforepo_remove_private_protected_titles');
add_filter('private_title_format', 'inforepo_remove_private_protected_titles');


/**
 * Get Filter Ids with their title.
 *
 * @param array $filters_data Filter's data.
 *
 * @return array filter ids.
 */
function get_filter_ids(array $filters_data = []): array
{
  if (empty($filters_data) || !is_array($filters_data)) {
    return [];
  }

  $filter_ids = [];

  foreach ($filters_data as $filter_data) {
    if (
      empty($filter_data['slug'])
      || empty($filter_data['children'])
      || !is_array($filter_data['children'])
    ) {
      continue;
    }

    // Build Data.
    $key = $filter_data['slug'];
    $filter_ids[$key] = [];

    // Parent.
    foreach ($filter_data['children'] as $parent_item) {
      $filter_ids[$key][$parent_item['value']] = [
        'slug' => $parent_item['slug'] ?? '',
        'text' => $parent_item['label'] ?? '',
      ];

      if (empty($parent_item['children']) || !is_array($parent_item['children'])) {
        continue;
      }

      // Children.
      foreach ($parent_item['children'] as $child_item) {
        $filter_ids[$key][$child_item['value']] = [
          'slug' => $child_item['slug'] ?? '',
          'text' => $child_item['label'] ?? '',
        ];

        if (empty($child_item['children']) || !is_array($child_item['children'])) {
          continue;
        }

        // Grand Children.
        foreach ($child_item['children'] as $grand_child_item) {
          $filter_ids[$key][$grand_child_item['value']] = [
            'slug' => $grand_child_item['slug'] ?? '',
            'text' => $grand_child_item['label'] ?? '',
          ];

          if (empty($grand_child_item['children']) || !is_array($grand_child_item['children'])) {
            continue;
          }

          // Great Grand Children.
          foreach ($grand_child_item['children'] as $great_grand_child_item) {
            $filter_ids[$key][$great_grand_child_item['value']] = [
              'slug' => $great_grand_child_item['slug'] ?? '',
              'text' => $great_grand_child_item['label'] ?? '',
            ];
          }
        }
      }
    }
  }

  return $filter_ids;
}


/**
 * Main endpoint inforepo API get resources
 * 
 * This functions replaces legacy loadmore, search, filter by creating an endpoint for the API
 * 
 * @param request
 * @return api response
 * 
 * @author marieleponti
 * @package inforepo
 * 
 * 
 */
function inforepo_api_get_resources($request)
{
  $params = $request->get_params();

  $paged = isset($params['page']) ? intval($params['page']) : 1;
  $per_page = isset($params['per_page']) ? intval($params['per_page']) : 12;
  $post_status = ['publish'];
  if (current_user_can('read_private_posts')) {
    $post_status[] = 'private';
  }
  $args = [
    'post_type'      => 'inforepo_resource',
    'post_status' => $post_status,
    'posts_per_page' => $per_page,
    'paged'          => $paged,
  ];

  /* -------------------------
   * SEARCH
   * ------------------------- */
  if (!empty($params['search'])) {
    $args['s'] = sanitize_text_field($params['search']);
  }

  /* -------------------------
   * TAX FILTERS
   * ------------------------- */
  $tax_query = [];

  $taxonomies = ['topic', 'source', 'format', 'country', 'language'];

  foreach ($taxonomies as $tax) {
    if (!empty($params[$tax])) {

      $terms = explode(',', sanitize_text_field($params[$tax]));

      $tax_query[] = [
        'taxonomy' => $tax,
        'field'    => 'slug',
        'terms'    => $terms,
      ];
    }
  }

  if (!empty($tax_query)) {
    $args['tax_query'] = $tax_query;
  }

  /* -------------------------
   * QUERY
   * ------------------------- */
  $query = new WP_Query($args);

  $items = [];

  while ($query->have_posts()) {
    $query->the_post();

    $id = get_the_ID();

    $items[] = [
      'id'      => $id,
      'title'   => get_the_title(),
      'excerpt' => get_the_excerpt(),
      'date'    => get_the_date('Y-m-d'),
      'permalink'      => get_permalink($id),
      'featured_image' => get_the_post_thumbnail_url($id, 'large') ?: '',
      // ACF limpio (mejor que get_fields completo)
      'acf' => [
        'description' => get_field('description', $id),
        'author'      => get_field('author', $id),
        'link'        => get_field('link_to_resource', $id),
      ],

      'taxonomies' => [
        'topic'    => wp_get_post_terms($id, 'topic', ['fields' => 'slugs']),
        'source'   => wp_get_post_terms($id, 'source', ['fields' => 'slugs']),
        'format'   => wp_get_post_terms($id, 'format', ['fields' => 'slugs']),
        'country'  => wp_get_post_terms($id, 'country', ['fields' => 'slugs']),
        'language' => wp_get_post_terms($id, 'language', ['fields' => 'slugs']),
      ]
    ];
  }

  return rest_ensure_response([
    'items' => $items,
    'total' => $query->found_posts,
    'pages' => $query->max_num_pages,
    'page'  => $paged,
  ]);
}


  /***
   * This function embeds the native Wordpress <Content> field in ACF field group for 
   * more logial organization of ACF fields and native Wordpress fields (the latter
   * are title and content). Also improves UI.
   */
  add_action('acf/input/admin_head', 'embed_content_field_in_acf_field_group');
  function embed_content_field_in_acf_field_group()
  {

    ?>
    <script type="text/javascript">
      (function($) {

        $(document).ready(function() {

          $('.acf-field-671144244c1c8 .acf-input').append($('#postdivrich'));

        });

      })(jQuery);
    </script>
    <style type="text/css">
      .acf-field #wp-content-editor-tools {
        background: transparent;
        padding-top: 0;
      }
    </style>
  <?php

  }

  /***
   * This function embeds the native Wordpress <Content> field in ACF field group for 
   * more logial organization of ACF fields and native Wordpress fields (the latter
   * are title and content). Also improves UI.
   */
  add_action('acf/input/admin_head', 'embed_content_field_in_acf_field_group_frontendform');
  function embed_content_field_in_acf_field_group_frontendform()
  {

  ?>
    <script type="text/javascript">
      (function($) {
        $(document).ready(function() {
          $('.acf-field-671144244c1c8 .acf-input').append($('.acf-field-wysiwyg'));
        });

      })(jQuery);
    </script>
    <style type="text/css">
      .acf-field #wp-content-editor-tools {
        background: transparent;
        padding-top: 0;
      }
    </style>
  <?php

  }

/*********************************************************************** 
 * CORS config to allow access to frontend app via API
 ***********************************************************************/
add_action('rest_api_init', function () {
  remove_filter('rest_pre_serve_request', 'rest_send_cors_headers');

  add_filter('rest_pre_serve_request', function ($value) {

    $origin = $_SERVER['HTTP_ORIGIN'] ?? '';

    $allowed =
      $origin === 'http://127.0.0.1:8080' ||
      $origin === 'http://127.0.0.1:5173' ||
      str_contains($origin, 'netlify.app');

    if ($allowed) {
      header("Access-Control-Allow-Origin: $origin");
      header('Vary: Origin');
    }

    header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
    header('Access-Control-Allow-Headers: Authorization, Content-Type');

    if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
      exit;
    }

    return $value;
  });
});

//  Create namespace for API
add_action('rest_api_init', function () {

  register_rest_route('inforepo/v1', '/resources', [
    'methods'  => 'GET',
    'callback' => 'inforepo_api_get_resources',
    'permission_callback' => '__return_true'
  ]);

});


/**
 * Set the JWT token expiration to 2 hours.
 * Adjust the duration as needed (e.g. 4 hours if the team
 * prefers not to log in again too frequently).
 */
add_filter('jwt_auth_expire', function ($expire, $issuedAt) {
    return $issuedAt + (4 * HOUR_IN_SECONDS);
}, 10, 2);

  ?>