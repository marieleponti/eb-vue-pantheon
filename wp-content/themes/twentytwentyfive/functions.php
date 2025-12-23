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

// Adds theme support for post formats.
if ( ! function_exists( 'twentytwentyfive_post_format_setup' ) ) :
	/**
	 * Adds theme support for post formats.
	 *
	 * @since Twenty Twenty-Five 1.0
	 *
	 * @return void
	 */
	function twentytwentyfive_post_format_setup() {
		add_theme_support( 'post-formats', array( 'aside', 'audio', 'chat', 'gallery', 'image', 'link', 'quote', 'status', 'video' ) );
	}
endif;
add_action( 'after_setup_theme', 'twentytwentyfive_post_format_setup' );

// Enqueues editor-style.css in the editors.
if ( ! function_exists( 'twentytwentyfive_editor_style' ) ) :
	/**
	 * Enqueues editor-style.css in the editors.
	 *
	 * @since Twenty Twenty-Five 1.0
	 *
	 * @return void
	 */
	function twentytwentyfive_editor_style() {
		add_editor_style( get_parent_theme_file_uri( 'assets/css/editor-style.css' ) );
	}
endif;
add_action( 'after_setup_theme', 'twentytwentyfive_editor_style' );

// Enqueues style.css on the front.
if ( ! function_exists( 'twentytwentyfive_enqueue_styles' ) ) :
	/**
	 * Enqueues style.css on the front.
	 *
	 * @since Twenty Twenty-Five 1.0
	 *
	 * @return void
	 */
	function twentytwentyfive_enqueue_styles() {
		wp_enqueue_style(
			'twentytwentyfive-style',
			get_parent_theme_file_uri( 'style.css' ),
			array(),
			wp_get_theme()->get( 'Version' )
		);
	}
endif;
add_action( 'wp_enqueue_scripts', 'twentytwentyfive_enqueue_styles' );

// Registers custom block styles.
if ( ! function_exists( 'twentytwentyfive_block_styles' ) ) :
	/**
	 * Registers custom block styles.
	 *
	 * @since Twenty Twenty-Five 1.0
	 *
	 * @return void
	 */
	function twentytwentyfive_block_styles() {
		register_block_style(
			'core/list',
			array(
				'name'         => 'checkmark-list',
				'label'        => __( 'Checkmark', 'twentytwentyfive' ),
				'inline_style' => '
				ul.is-style-checkmark-list {
					list-style-type: "\2713";
				}

				ul.is-style-checkmark-list li {
					padding-inline-start: 1ch;
				}',
			)
		);
	}
endif;
add_action( 'init', 'twentytwentyfive_block_styles' );

// Registers pattern categories.
if ( ! function_exists( 'twentytwentyfive_pattern_categories' ) ) :
	/**
	 * Registers pattern categories.
	 *
	 * @since Twenty Twenty-Five 1.0
	 *
	 * @return void
	 */
	function twentytwentyfive_pattern_categories() {

		register_block_pattern_category(
			'twentytwentyfive_page',
			array(
				'label'       => __( 'Pages', 'twentytwentyfive' ),
				'description' => __( 'A collection of full page layouts.', 'twentytwentyfive' ),
			)
		);

		register_block_pattern_category(
			'twentytwentyfive_post-format',
			array(
				'label'       => __( 'Post formats', 'twentytwentyfive' ),
				'description' => __( 'A collection of post format patterns.', 'twentytwentyfive' ),
			)
		);
	}
endif;
add_action( 'init', 'twentytwentyfive_pattern_categories' );

// Registers block binding sources.
if ( ! function_exists( 'twentytwentyfive_register_block_bindings' ) ) :
	/**
	 * Registers the post format block binding source.
	 *
	 * @since Twenty Twenty-Five 1.0
	 *
	 * @return void
	 */
	function twentytwentyfive_register_block_bindings() {
		register_block_bindings_source(
			'twentytwentyfive/format',
			array(
				'label'              => _x( 'Post format name', 'Label for the block binding placeholder in the editor', 'twentytwentyfive' ),
				'get_value_callback' => 'twentytwentyfive_format_binding',
			)
		);
	}
endif;
add_action( 'init', 'twentytwentyfive_register_block_bindings' );

// Registers block binding callback function for the post format name.
if ( ! function_exists( 'twentytwentyfive_format_binding' ) ) :
	/**
	 * Callback function for the post format name block binding source.
	 *
	 * @since Twenty Twenty-Five 1.0
	 *
	 * @return string|void Post format name, or nothing if the format is 'standard'.
	 */
	function twentytwentyfive_format_binding() {
		$post_format_slug = get_post_format();

		if ( $post_format_slug && 'standard' !== $post_format_slug ) {
			return get_post_format_string( $post_format_slug );
		}
	}
endif;



/*-----------------------------------------------------------------------------------------------
Info Repo Custom code start
-------------------------------------------------------------------------------------------------*/


function eb_enqueue_styles()
{

  $theme = wp_get_theme();
  wp_enqueue_style(
    get_template_directory_uri() . '/style.css',
    array(),  
    $theme->parent()->get('Version')
  );
  wp_enqueue_style(
    'child-style',
    get_stylesheet_uri(),
    array('bootstrap-css'),
    $theme->get('Version')
  );

  wp_enqueue_style('bootstrap-css', get_home_url() . '/wp-content/themes/twentytwentyfive/assets/build/library/css/bootstrap.min.css', [], false, 'all');
  wp_enqueue_script('bootstrap-js', get_home_url() . '/wp-content/themes/twentytwentyfive/assets/build/library/js/bootstrap.min.js', ['jquery'], false, true);
}
add_action('wp_enqueue_scripts', 'eb_enqueue_styles');


/** Define path constants 
 * 
 */
if (!defined('INFOREPO_DIR_PATH')) {
  define('INFOREPO_DIR_PATH', untrailingslashit(get_theme_file_path()));
}
if (!defined('INFOREPO_DIR_URI')) {
  define('INFOREPO_DIR_URI', untrailingslashit(get_theme_file_uri()) . './divi-child');
}
if (!defined('INFOREPO_BUILD_URI')) {
  define('INFOREPO_BUILD_URI', untrailingslashit(get_theme_file_uri()) . '/assets/build');
}
if (!defined('INFOREPO_BUILD_PATH')) {
  define('INFOREPO_BUILD_PATH', untrailingslashit(get_theme_file_path()) . '/assets/build');
}
if (!defined('INFOREPO_BUILD_JS_URI')) {
  define('INFOREPO_BUILD_JS_URI', untrailingslashit(get_theme_file_uri()) . '/assets/build/js');
}
if (!defined('INFOREPO_BUILD_JS_DIR_PATH')) {
  define('INFOREPO_BUILD_JS_DIR_PATH', untrailingslashit(get_theme_file_path()) . '/assets/build/js');
}
if (!defined('INFOREPO_BUILD_CSS_URI')) {
  define('INFOREPO_BUILD_CSS_URI', untrailingslashit(get_theme_file_uri()) . '/assets/build/css');
}
if (!defined('INFOREPO_BUILD_CSS_DIR_PATH')) {
  define('INFOREPO_BUILD_CSS_DIR_PATH', untrailingslashit(get_theme_file_path()) . '/assets/build/css');
}
if (!defined('INFOREPO_BUILD_LIB_URI')) {
  define('INFOREPO_BUILD_LIB_URI', untrailingslashit(get_theme_file_uri()) . '/assets/build/library');
}

function inforepo_scripts_styles()
{
  wp_enqueue_style('style', get_stylesheet_uri(), array(), filemtime(INFOREPO_BUILD_CSS_DIR_PATH . '/main.css'), 'all');
  wp_enqueue_style('main-css', INFOREPO_BUILD_CSS_URI . '/main.css', ['bootstrap-css'], filemtime(INFOREPO_BUILD_CSS_DIR_PATH . '/main.css'), 'all');
  wp_enqueue_style('bootstrap-css', INFOREPO_BUILD_LIB_URI . '/css/bootstrap.min.css', [], false, 'all');

  wp_register_style('search-css', INFOREPO_BUILD_CSS_URI . '/search.css', [], filemtime(INFOREPO_BUILD_CSS_DIR_PATH . '/search.css'), 'all');
  wp_register_style('leaflet-css', INFOREPO_BUILD_LIB_URI . '/css/leaflet.css', [], false, 'all');
  wp_register_style('leaflet-css-cld', 'https://unpkg.com/leaflet@1.9.4/dist/leaflet.css', [], false, 'all');
  wp_register_style('eb-research-page-template', 'https://use.fontawesome.com/releases/v5.3.1/css/all.css', [], false, 'all');


  wp_register_script('bootstrap-js', INFOREPO_BUILD_LIB_URI . '/js/bootstrap.min.js', ['jquery'], false, true);
  // wp_register_script('leaflet-js', INFOREPO_BUILD_LIB_URI . '/js/leaflet.js', ['jquery'], false, true);
  wp_register_script('leaflet-js-cld', 'https://unpkg.com/leaflet@1.9.4/dist/leaflet.js', ['jquery'], false, true);
  wp_register_script('main-js', INFOREPO_BUILD_JS_URI . '/main.js', ['jquery'], filemtime(INFOREPO_BUILD_JS_DIR_PATH . '/main.js'), true);
  wp_register_script('search-js', INFOREPO_BUILD_JS_URI . '/search.js', ['main-js', 'jquery'], filemtime(INFOREPO_BUILD_JS_DIR_PATH . '/search.js'), true);
  wp_register_script('map-search-js', INFOREPO_BUILD_JS_URI . '/mapSearch.js', ['jquery'], filemtime(INFOREPO_BUILD_JS_DIR_PATH . '/mapSearch.js'), true);
  wp_register_script('post-map-js', INFOREPO_BUILD_JS_URI . '/postMap.js', ['jquery'], filemtime(INFOREPO_BUILD_JS_DIR_PATH . '/postMap.js'), true);
  wp_register_script('jquery', INFOREPO_BUILD_LIB_URI . '/jquery-3.7.1.min.js', [], false, true);
  wp_register_script('js-cookie', 'https://cdnjs.cloudflare.com/ajax/libs/js-cookie/3.0.1/js.cookie.min.js', [], false, true);
  wp_register_script('loadmore-js', INFOREPO_BUILD_JS_URI . '/loadMore.js', ['jquery'], filemtime(INFOREPO_BUILD_JS_DIR_PATH . '/loadMore.js'), true);




  wp_enqueue_style('leaflet-css');
  wp_enqueue_style('leaflet-css-cld');
  wp_enqueue_style('eb-research-page-template');
  // wp_enqueue_script('leaflet-js');
  wp_enqueue_script('leaflet-js-cld');
  wp_enqueue_script('js-cookie');
  wp_enqueue_script('boostrap-js');


  //styles and scripts needed for map search page
  if (!is_single()) {
    wp_enqueue_script('map-search-js');
    // styles and scripts needed for search page (archive page = Library of Conent/Resources/Cases)
    // if(is_page('resources')){
    wp_enqueue_style('search-css');
    wp_enqueue_script('search-js');
    wp_enqueue_script('loadmore-js');
  }

  if (is_single()) {
    wp_enqueue_script('post-map-js');
  }
}
add_action('wp_enqueue_scripts', 'inforepo_scripts_styles');


/**
 * Setup site
 */
function inforepo_setup()
{
  add_theme_support('post-thumbnails');
  add_theme_support('title-tag');
  add_theme_support('menus');
  add_theme_support('custom-logo', [
    'height'               => 100,
    'width'                => 400,
    'flex-height'          => true,
    'flex-width'           => true,
    'header-text'          => ['site-title', 'site-description'],
    'unlink-homepage-logo' => true
  ]);
}
add_action('after_setup_theme', 'inforepo_setup');

/**
 * Menus
 * 
 * In the first version of InfoRepo, menus were custom.
 * Commented out after switch to using Divi as them and inforepo as 
 * child theme. Likely not needed in future. 
 * 
 * @package inforepo
 * @author marieleponti
 */
// function inforepo_menus()
// {
// 	register_nav_menus(array(
// 		'main-menu-private' => __('Main Menu Private', 'inforepo'),
// 		'main-menu-public' => __('Main Menu Public', 'inforepo'),
//     'private-footer-menu' => __('Private Footer Menu', 'inforepo'),
//     'public-footer-meernu' => __('Public Footer Menu', 'inforepo'),
// 	));
// }
// add_action('init', 'inforepo_menus');


/* -------------  Implement Bootstrap Menus     -------------*/
function inforepo_add_class_li($classes, $item, $args)
{
  if (isset($args->li_class)) {
    $classes[] = $args->li_class;
  }
  return $classes;
  if (isset($args->active_class) && in_array('current-menu-item', $classes)) {
    $classes[] = $args->active_class;
  }
  return $classes;
}
add_filter('nav_menu_css_class', 'inforepo_add_class_li', 10, 3);


function inforepo_add_anchor_class($attr, $item, $args)
{
  if (isset($args->a_class)) {
    $attr['class'] = $args->a_class;
  }
  return $attr;
}
add_filter('nav_menu_link_attributes', 'inforepo_add_anchor_class', 10, 3);
/* ------------- end Implement Bootstrap Menus     -------------*/



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
function add_custom_roles()
{
  add_role('eb_team', __('EB Team'), get_role('administrator')->capabilities);
  add_role(
    'eb_community_member',
    __('EB Community Member'),
    array(
      'delete_posts' => true,
      'edit_posts'   => true,
      'read'         => true,
      'read_private_pages' => true,
      'read_private_posts' => true,
      'manage_terms' => true
    )
  );
}
add_action('init', 'add_custom_roles');



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
function inforepo_set_private()
{
  if (!is_user_logged_in() || !current_user_can('edit_posts')) {
    auth_redirect();
  }
}



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
 * Functions for Search by taxonomy
 * Filter data
 * start
 * 
 */
/**
 * Get hierarchical term items.
 *
 * @param string $taxonomy  Taxonomy.
 * @param int    $parent_id Parent term ID.
 *
 * @return array
 */
function get_hierarchical_term_items(string $taxonomy = '', int $parent_id = 0): array
{

  // Build query args.
  $query_args = array(
    'post_type'              => 'inforepo_resource',
    'post_status' => array('publish', 'private'),
    'fields'                 => 'ids',
    'posts_per_page'         => 1,
    'no_found_rows'          => true,
    'update_post_meta_cache' => false,
    'update_post_term_cache' => false,
  );

  $items = [];

  // 1. Add Parent Terms.
  $the_terms = get_terms(
    [
      'taxonomy'   => $taxonomy,
      'hide_empty' => false,
      'parent'     => $parent_id,
    ]
  );
  $the_terms = !is_wp_error($the_terms) && !empty($the_terms) ? $the_terms : [];

  foreach ($the_terms as $the_term) {

    $query_args['tax_query'] = [
      [
        'taxonomy' => $taxonomy,
        'field'    => 'slug',
        'terms'    => [$the_term->slug],
      ],
    ];

    $posts_with_the_term = new WP_Query($query_args);


    if (empty($posts_with_the_term->posts)) {
      continue;
    }

    $term_data = [
      'label' => $the_term->name,
      'value' => $the_term->term_id,
      'slug'  => $the_term->slug,
    ];

    // 2. Add Child Terms if they exist.
    $term_children = get_terms(
      [
        'taxonomy'     => $taxonomy,
        'hierarchical' => 1,
        'hide_empty'   => 0,
        'parent'       => $the_term->term_id ?? 0,
      ]
    );

    if (!empty($term_children) && !is_wp_error($term_children)) {
      $term_data['children'] = [];

      foreach ($term_children as $term_child) {
        if (!empty($term_child) && $term_child instanceof WP_Term) {

          $query_args['tax_query'] = [
            [
              'taxonomy' => $taxonomy,
              'field'    => 'slug',
              'terms'    => [$term_child->slug],
            ],
          ];

          $posts_with_term_child = new WP_Query($query_args);

          if (empty($posts_with_term_child->posts)) {
            continue;
          }

          $term_child_data = [
            'label' => $term_child->name ?? '',
            'value' => $term_child->term_id ?? '',
            'slug'  => $term_child->slug,
          ];

          // 3. Add grandchildren terms if they exist.
          $term_grand_children = get_terms(
            [
              'taxonomy'     => $taxonomy,
              'hierarchical' => 1,
              'hide_empty'   => 0,
              'parent'       => $term_child->term_id ?? 0,
            ]
          );

          if (!empty($term_grand_children) && !is_wp_error($term_grand_children)) {
            $term_child_data['children'] = [];

            foreach ($term_grand_children as $term_grand_child) {
              if (!empty($term_grand_child) && $term_grand_child instanceof WP_Term) {

                $query_args['tax_query'] = [
                  [
                    'taxonomy' => $taxonomy,
                    'field'    => 'slug',
                    'terms'    => [$term_grand_child->slug],
                  ],
                ];

                $posts_with_term_grand_child = new WP_Query($query_args);

                if (empty($posts_with_term_grand_child->posts)) {
                  continue;
                }

                $term_grand_child_data = [
                  'label' => $term_grand_child->name ?? '',
                  'value' => $term_grand_child->term_id ?? '',
                  'slug'  => $term_grand_child->slug ?? '',
                ];

                // 4. Add great-grandchildren terms if they exist.
                $term_great_grand_children = get_terms(
                  [
                    'taxonomy'     => $taxonomy,
                    'hierarchical' => 1,
                    'hide_empty'   => 0,
                    'parent'       => $term_grand_child->term_id ?? 0,
                  ]
                );

                if (!empty($term_great_grand_children) && !is_wp_error($term_great_grand_children)) {
                  foreach ($term_great_grand_children as $term_great_grand_child) {
                    if (!empty($term_great_grand_child) && $term_great_grand_child instanceof WP_Term) {

                      $query_args['tax_query'] = [
                        [
                          'taxonomy' => $taxonomy,
                          'field'    => 'slug',
                          'terms'    => [$term_great_grand_child->slug],
                        ],
                      ];

                      $posts_with_term_great_grand_child = new WP_Query($query_args);

                      if (empty($posts_with_term_great_grand_child->posts)) {
                        continue;
                      }

                      $term_grand_child_data['children'][] = [
                        'label' => $term_great_grand_child->name ?? '',
                        'value' => $term_great_grand_child->term_id ?? '',
                        'slug'  => $term_great_grand_child->slug ?? '',
                      ];
                    }
                  }
                }

                $term_child_data['children'][] = $term_grand_child_data;
              }
            }
          }

          $term_data['children'][] = $term_child_data;
        }
      }
    }

    $items[] = $term_data;
  }

  return $items;
}

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
 * Get Filters data.
 *
 * @return array[]
 */
function get_filters_data(): array
{
  // $topic_terms_temp = get_hierarchical_term_items('topic');
  // if (!empty($topic_terms_temp)) {
  //   $topic_terms = [];
  //   foreach ($topic_terms_temp as $term) {
  //       // $term = esc_html__($term, 'inforepo');
  //       array_push($topic_terms, esc_html__($term, 'inforepo'));
  //   }
  // }
  $topic_terms = get_hierarchical_term_items('topic');
  $source_terms = get_hierarchical_term_items('source');
  $format_terms = get_hierarchical_term_items('format');
  $countries_terms = get_hierarchical_term_items('country');
  $language_terms = get_hierarchical_term_items('language');

  return [
    [
      'label'    => __('Topics', 'inforepo'),
      'slug'     => 'topic',
      'children' => $topic_terms,
    ],
    [
      'label'    => __('Source', 'inforepo'),
      'slug'     => 'source',
      'children' => $source_terms,
    ],
    [
      'label'    => __('Format', 'inforepo'),
      'slug'     => 'format',
      'children' => $format_terms,
    ],
    [
      'label'    => __('Countries', 'inforepo'),
      'slug'     => 'country',
      'children' => $countries_terms,
    ],
    [
      'label'    => __('Language', 'inforepo'),
      'slug'     => 'language',
      'children' => $language_terms,
    ]
  ];
}



/**
 * 
 * Functions to enable shortcodes for Divi UI 
 * 
 */


/**
 * 
 * This function is necessary for the ACF form that is used on the 
 * <Submit resource> page. 
 * 
 */
add_action('get_header', 'inforepo_add_acf_form_head');
function inforepo_add_acf_form_head()
{
  if (is_page('submit-resource')) {
    acf_form_head();
  }
}

/***
 * Allows for shortcode to be used with ACF frontend form.
 */
add_shortcode('acf_form_head', 'inforepo_set_acf_form_head');
function inforepo_set_acf_form_head()
{
  acf_form_head();
}

/**
 * Allows for shortcode used with ACF frontend form.
 * Defines the post type as inforepo_resource. 
 * post_status means that when a user submits a post (resource) via
 * the acf frontend form, this resource will be a draft in Resources,
 * and must be officially published by an admin or EB Team member. 
 */
add_shortcode('frontend_resource_submission_form', 'inforepo_display_resource_frontend_form');
function inforepo_display_resource_frontend_form()
{
  ob_start();

  acf_form(array(
    'post_id'       => 'new_post',
    'post_title'    => true,
    'post_content'  => true,
    'form' => true,
    'new_post'      => array(
      'post_type'     => 'inforepo_resource',
      'post_status'   => 'draft'
    ),
    'submit_value'  => 'Submit',
    'return' => add_query_arg('updated', 'true', home_url() . '/submission-received')
  ));
?>
<?php
  return ob_get_clean();
}


/**
 * Function for defining shortcode for the submission received page. 
 * The code that is called for this shortcode is found in the file
 * /template-parts/submission-received
 */
add_shortcode('submission_received', 'inforepo_submission_received');
function inforepo_submission_received()
{
  ob_start();
  get_template_part('template-parts/submission-received');
  return ob_get_clean();
}

/**
 * Function that defines the shortcode 'resource_library' to call
 * the file resource-library
 */
add_shortcode('resource_library', 'inforepo_display_resource_library');
function inforepo_display_resource_library()
{
  ob_start();
  get_template_part('template-parts/resource-library');
  return ob_get_clean();
}

add_shortcode('minibrief_border_ext_mex_ntc', 'inforepo_display_minibrief_border_ext_mex_ntc');
function inforepo_display_minibrief_border_ext_mex_ntc()
{
  ob_start();
  get_template_part('template-parts/EBMinibriefBorderexternalizationMXandNTC');
  return ob_get_clean();
}

/**
 * Function that defines the shortcode 'resource_search_results' to call
 * the file resource-search-results
 */
add_shortcode('resource_search_results', 'inforepo_display_resource_search_results');
function inforepo_display_resource_search_results()
{
  ob_start();
  get_template_part('template-parts/resource-search-results');
  return ob_get_clean();
}

/**
 * Function that defines the shortcode 'resource_search_results_library' to call
 * the file library-resource-search-results
 */
add_shortcode('resource_search_results_library', 'inforepo_display_resource_search_results_library');
function inforepo_display_resource_search_results_library()
{
  ob_start();
  get_template_part('template-parts/library-resource-search-results');
  return ob_get_clean();
}

/**
 * Function that defines the shortcode 'eb-public-records-requests' to call
 * the file to display EB Public Records Requests
 */
add_shortcode('display_eb_records_requests', 'inforepo_eb_public_records_requests');
function inforepo_eb_public_records_requests()
{
  ob_start();
  get_template_part('template-parts/eb-records-requests');
  return ob_get_clean();
}
/**
 * Function that defines the shortcode to display individual user post of EB Team
 * Public Records Requests
 */
add_shortcode('display_eb_public_records_request_post', 'inforepo_eb_public_records_requests_post');
function inforepo_eb_public_records_requests_post()
{
  ob_start();
  get_template_part('template-parts/eb-records-requests-post');
  return ob_get_clean();
}
/**
 * Function that defines the shortcode to display EB Research page
 */
add_shortcode('display_eb_research_page', 'inforepo_eb_research_page_display');
function inforepo_eb_research_page_display()
{
  ob_start();
  get_template_part('template-parts/eb-research-page');
  return ob_get_clean();
}



/**
 * Function that defines the shortcode 'resource_search_results_map' to call
 * the file resource-search-results-map
 */
add_shortcode('resource_search_results_map', 'inforepo_display_resource_search_results_map');
function inforepo_display_resource_search_results_map()
{
  ob_start();

  get_template_part('template-parts/resource-search-results-map');

  return ob_get_clean();
}

/**
 * Function that defines the shortcode 'resource_library_without_filter' to call
 * the file resource-library-no-filter
 */
add_shortcode('resource_library_without_filter', 'inforepo_display_resource_library_no_filter');
function inforepo_display_resource_library_no_filter()
{
  ob_start();

  get_template_part('template-parts/resource-library-no-filter');

  return ob_get_clean();
}

/**
 * Function that defines the shortcode 'inforepo_title_display' 
 * to call the Wordpress native function that returns the current
 * post's title.
 */
add_shortcode('inforepo_title_display', 'inforepo_display_post_title');
function inforepo_display_post_title()
{
  ob_start();
  the_title();
  return ob_get_clean();
}

/**
 * Function that defines the shortcode 'inforepo_description_display' 
 * to call the Wordpress native function that returns the current
 * post's description.
 */
add_shortcode('inforepo_description_display', 'inforepo_display_post_description');
function inforepo_display_post_description()
{
  ob_start();
?>
  <div class="single-post-description-display">
    <?php the_field('description'); ?>
  </div>
<?php
  return ob_get_clean();
}

/**
 * Function that defines the shortcode 'inforepo_featured_photo_display' 
 * to call the file image-display-single-post
 * 
 */
add_shortcode('inforepo_featured_photo_display', 'inforepo_display_post_thumbnail');
function inforepo_display_post_thumbnail()
{
  ob_start();
  get_template_part('template-parts/image-display-single-post');
  return ob_get_clean();
}

/**
 * Function that defines the shortcode 'inforepo_content_display' 
 * to call the Wordpress native function that returns the current
 * post's content.
 */
add_shortcode('inforepo_content_display', 'inforepo_display_post_content');
function inforepo_display_post_content()
{
  ob_start();
  the_content();
  return ob_get_clean();
}

/**
 * Function that defines the shortcode 'inforepo_datetime_display' 
 * to call the Wordpress native function that returns the current
 * post's date of publish.
 */
add_shortcode('inforepo_datetime_display', 'inforepo_display_post_datetime');
function inforepo_display_post_datetime()
{
  ob_start();
  the_date();
  return ob_get_clean();
}


/**
 * Function that defines the shortcode 'inforepo_author_display' 
 * to call the Wordpress native function that returns the current
 * post's author, with labeling in a paragraph.
 */
add_shortcode('inforepo_author_display', 'inforepo_display_post_author');
function inforepo_display_post_author()
{
  ob_start();
?>
  <p> <?php esc_html_e('Submitted by:', 'inforepo') ?> <php the_author(); ?>
  </p>
  <?php
  return ob_get_clean();
}

/**
 * Function that defines the shortcode 'inforepo_source_author_display' 
 * to display the user-defined acf field 'author' entry. This differs from
 * <the_author> because <the_author>, the Wordpress native function, will
 * always return the user responsible for the post. 
 * get_field('author') will return whatever the user entered in the ACF field
 * called author. For example, if user1 posts an research paper written by 
 * self (user1) and Researcher2 (who may or may not be registered on the site), 
 * <the_author> will return <user1>. If user1 entered 'Researcher2 and user1'
 * in the ACF field 'Author', then that is what get_field('author) will return.
 * This function also returns the organization author, the text input by user
 * for the ACF field defined by 'organization_author.'
 */
add_shortcode('inforepo_source_author_display', 'inforepo_display_author_source');
function inforepo_display_author_source()
{
  ob_start();
  $source_author = get_field('author');
  $source_author_org = get_field('organization_author');
  if ($source_author != null && $source_author != '') {
  ?>
    <p> Source author: <?php the_field('author'); ?> </p>
  <?php
  }

  if ($source_author_org != null && $source_author_org != '') {
  ?>
    <p> Authoring Organization: <?php the_field('organization_author'); ?> </p>

  <?php
  }
  return ob_get_clean();
}

/**
 * Function that defines shortcode inforepo_file_display to display the file array
 * if any files were uploaded in the ACF repeater field 'upload_files'
 * Also used for Legal Filings and Production for Public Records Requests posts
 */
add_shortcode('inforepo_file_display', 'inforepo_display_post_file');
function inforepo_display_post_file()
{
  ob_start();
  ?>
  <div class="legal-filings-prod-list single-post-categories-files-display">

    <?php
    if (have_rows('upload_files')):
      while (have_rows('upload_files')) : the_row();
        $file = get_sub_field('upload_file');

        if ($file) :
          $url = $file['url'];
          $title = $file['title'];
          $caption = $file['caption'];
          $date = $file['date'];
          $description = $file['description'];
    ?>

          <div class="legal-filings-production-prr-post"> 
            <?php if ($caption) : ?>
              <div class="filings-caption-date">
                <p class="flp-caption-date"><?php echo esc_html($caption); ?></p>
              </div>
            <?php endif; ?>

            <div class="filing-title flp-title">
              <?php echo esc_attr($title); ?>
            <div class="download-button-container">
                <a href="<?php echo esc_attr($url); ?>" class="download-button">
                  <span class="download-button__text"><?php echo esc_html__('Download') ?></span>
                </a>
            </div>
            </div>
          </div> <!-- legal-filings-production-prr-post -->

    <?php endif;
      endwhile;
    endif;


    return ob_get_clean();
  }



  /**
   * Function that defines shortcode for Legal Filings and Production for Public Records Requests posts
   */
  add_shortcode('inforepo_file_display_public_records', 'inforepo_display_public_records_file');
  function inforepo_display_public_records_file()
  {
    ob_start();
    ?>
    <div class="single-post-categories-display">
      <?php
      if (have_rows('upload_files')):
        while (have_rows('upload_files')) : the_row();
          $file = get_sub_field('upload_file');

          if ($file) :
            $url = $file['url'];
            $title = $file['title'];
            $caption = $file['caption'];
            $date = $file['date'];
            $description = $file['description'];
      ?>

            <div class="file-list-container">
              <?php
              if (have_rows('upload_files')):
                while (have_rows('upload_files')) : the_row();
                  $file = get_sub_field('upload_file');
                  if ($file) : ?>
                    <div class="file-entry">
                      <?php if ($file['caption']) : ?>
                        <span class="file-caption"><?php echo esc_html($file['caption']); ?></span>
                      <?php endif; ?>
                      <a href="<?php echo esc_attr($file['url']); ?>" class="file-link"><?php echo esc_html($file['title']); ?></a>
                      <?php if ($file['description']) : ?>
                        <div class="file-description"><?php echo esc_html($file['description']); ?></div>
                      <?php endif; ?>
                    </div>
              <?php endif;
                endwhile;
              endif;
              ?>
            </div>

      <?php endif;
        endwhile;
      else :
      // no rows found
      endif;
      ?>
    </div>
    <?php
    return ob_get_clean();
  }




  /**
   * Function that defines shortcode inforepo_link_display to display 
   * the link, if one was entered by user, in ACF field 'link_to_resource'
   */
  add_shortcode('inforepo_link_display', 'inforepo_display_link');
  function inforepo_display_link()
  {
    ob_start();
    $link = get_field('link_to_resource');
    if ($link) : ?>
      <div class="single-post-categories-display media-display">
        <a class="button view-original-posting" href="<?php echo esc_url($link); ?>">View original posting</a>
      </div>
    <?php endif;
    return ob_get_clean();
  }

  /**
   * Function that defines shortcode inforepo_video_display to display 
   * the embedded video, if one was entered by user, in ACF field 'embed_video'
   */
  add_shortcode('inforepo_video_display', 'inforepo_display_video');
  function inforepo_display_video()
  {
    ob_start();
    $video = get_field('embed_video');
    if ($video):
    ?>
      <div class="single-post-categories-display embed-video-display">
        <p> <?php the_field('embed_video'); ?> </p>
      </div>

    <?php endif;
    return ob_get_clean();
  }


  /**
   * TODO 
   * Test whether inforepo_source_author_display is the shortcode in use.
   * If so, remove inforepo_manually_added_author_display and inforepo_org_author_display
   */
  add_shortcode('inforepo_manually_added_author_display', 'inforepo_display_manually_added_author');
  function inforepo_display_manually_added_author()
  {
    ob_start();
    $author = get_field('author');
    if ($author):
    ?>
      <div class="single-post-categories-display author-display">
        <p> <?php the_field('author'); ?> </p>
      </div>

    <?php endif;
    return ob_get_clean();
  }

  /**
   * TODO 
   * Test whether inforepo_source_author_display is the shortcode in use.
   * If so, remove inforepo_manually_added_author_display and inforepo_org_author_display
   */
  add_shortcode('inforepo_org_author_display', 'inforepo_display_org_author');
  function inforepo_display_org_author()
  {
    ob_start();
    get_template_part('template-parts/authoring-orgs-single-post');
    return ob_get_clean();
  }

  /**
   * Function that defines shortcode inforepo_countries_city_display to display 
   * the list of countries and cities associated with posts. 
   * The countries and cities labeled as relevant taxonomies to post. 
   */
  add_shortcode('inforepo_countries_city_display', 'inforepo_display_countries_cities');
  function inforepo_display_countries_cities()
  {
    ob_start();
    get_template_part('template-parts/countries-city-single-post');
    return ob_get_clean();
  }

  /**
   * Function that defines shortcode single_post_map_display to display 
   * the Leaflet map for single post page. 
   */
  add_shortcode('single_post_map_display', 'inforepo_display_map_single_post');
  function inforepo_display_map_single_post()
  {
    ob_start();
    get_template_part('template-parts/map-display-single-post');
    return ob_get_clean();
  }


  /**
   * Function that defines shortcode inforepo_terms_display to display 
   * the list of <topics> associated with posts. 
   * The topics labeled as relevant taxonomies to post. 
   */
  add_shortcode('inforepo_terms_display', 'inforepo_display_post_terms');
  function inforepo_display_post_terms()
  {
    ob_start();
    get_template_part('template-parts/taxonomy-terms-single-post');
    return ob_get_clean();
  }

  /**
   * Function that defines shortcode inforepo_terms_display to display 
   * the list of <sources> associated with posts. 
   * The sources labeled as relevant taxonomies to post. 
   */
  add_shortcode('inforepo_sources_display', 'inforepo_display_sources');
  function inforepo_display_sources()
  {
    ob_start();
    get_template_part('template-parts/taxonomy-sources-single-post');
    return ob_get_clean();
  }

  /**
   * Function that defines shortcode inforepo_format_display to display 
   * the list of <formats> associated with posts. 
   * <Format> is a taxonomy of post type Resource (<inforepo_resource>).
   */
  add_shortcode('inforepo_format_display', 'inforepo_display_post_format');
  function inforepo_display_post_format()
  {
    ob_start();
    get_template_part('template-parts/formats-single-post');
    return ob_get_clean();
  }

  /**
   * Function that defines shortcode inforepo_language_display to display 
   * the list of <languages> associated with posts. 
   * <Language> is a taxonomy of post type Resource (<inforepo_resource>).
   */
  add_shortcode('inforepo_language_display', 'inforepo_display_post_language');
  function inforepo_display_post_language()
  {
    ob_start();
    get_template_part('template-parts/languages-single-post');
    return ob_get_clean();
  }

  /**
   * Function that defines shortcode search_results_banner to display 
   * the code implemented in file search-results-banner.
   */
  add_shortcode('search_results_banner', 'inforepo_display_search_results_banner');
  function inforepo_display_search_results_banner()
  {
    ob_start();
    get_template_part('template-parts/search-results-banner');
    return ob_get_clean();
  }


  /**
   * Function that defines shortcode display_footer to display 
   * wordpress footer
   */
  add_shortcode('display_footer', 'inforepo_display_footer');
  function inforepo_display_footer()
  {
    ob_start();
    get_footer();
    return ob_get_clean();
  }



  /**
   * Function that defines shortcode further reading
   * on mini brief post human impacts
   */
  add_shortcode('further_reading_for_human_impacts', 'display_further_reading_human_impacts');
  function display_further_reading_human_impacts()
  {
    ob_start();
    get_template_part('template-parts/mini-brief-further-reading-human-impacts');
    return ob_get_clean();
  }

  /**
   * Function that defines shortcode further reading
   * on mini brief post border externalization
   */
  add_shortcode('further_reading_for_border_ext', 'display_further_reading_border_ext');
  function display_further_reading_border_ext()
  {
    ob_start();
    get_template_part('template-parts/mini-brief-further-reading-border-ext');
    return ob_get_clean();
  }


  /**
   * Function that defines shortcode further reading
   * on mini brief post biometrics
   */
  add_shortcode('further_reading_for_biometrics', 'display_further_reading_biometrics');
  function display_further_reading_biometrics()
  {
    ob_start();
    get_template_part('template-parts/mini-brief-further-reading-biometrics');
    return ob_get_clean();
  }


  /**
   * Function to set image submitted by user via ACF Form
   * as featured image in post
   * 
   * @package inforepo
   * 
   */
  function inforepo_set_featured_image($value, $post_id, $field)
  {
    if ($value != '') {
      //Add the value which is the image ID to the _thumbnail_id meta data for the current post
      add_post_meta($post_id, '_thumbnail_id', $value);
    }
    return $value;
  }
  // acf/update_value/name={$field_name} - filter for a specific field based on it's name
  add_filter('acf/update_value/name=set_featured_image', 'inforepo_set_featured_image', 10, 3);



  // add_action('pre_get_posts', 'change_posts_per_page_archive');
  // function change_posts_per_page_archive($query)
  // {
  //   if (!is_admin() && $query->is_main_query() && is_post_type_archive('inforepo_resource')) {
  //     // $query->set('posts_per_page', 80);
  //     $query->set('nopaging', true);
  //   }
  // }


  /***
   * Function to implement pagination on archive pages.
   */
  function inforepo_pagination()
  {

    $allowed_tags = [
      'span' => [
        'class' => []
      ],
      'a' => [
        'class' => [],
        'href' => [],
      ]
    ];

    $args = [
      'before_page_number' => '<span class="btn border border-secondary mr-2 mb-2">',
      'after_page_number' => '</span>',
    ];

    printf('<nav class="inforepo-pagination clearfix">%s</nav>', wp_kses(paginate_links($args), $allowed_tags));
  }

  /***
   * Function to implement pagination on archive pages.
   */
  function inforepo_pagination_docket($query)
  {

    $allowed_tags = [
      'span' => [
        'class' => []
      ],
      'a' => [
        'class' => [],
        'href' => [],
      ]
    ];

    $args = [
      'before_page_number' => '<span class="btn border border-secondary mr-2 mb-2">',
      'after_page_number' => '</span>',
      'total'        => $query->max_num_pages,
      'current'      => max(1, get_query_var('paged')),
      'base'         => str_replace(999999999, '%#%', esc_url(get_pagenum_link(999999999))) . '#docket',
      //  'format'       => '?paged=%#%',
      'show_all'     => false,
      //  'type'         => 'plain',
      //  'end_size'     => 2,
      //  'mid_size'     => 1,
      //  'prev_next'    => true,
      //  'prev_text'    => sprintf( '<i></i> %1$s', __( 'Newer Posts', 'text-domain' ) ),
      //  'next_text'    => sprintf( '%1$s <i></i>', __( 'Older Posts', 'text-domain' ) ),
      //  'add_args'     => false,
      //  'add_fragment' => '',
    ];

    printf('<nav class="inforepo-pagination clearfix">%s</nav>', wp_kses(paginate_links($args), $allowed_tags));
  }


  /***
   * Set default featured image for post thumbnail. 
   * 
   */
  function inforepo_set_default_featured_image($html, $post_id, $post_thumbnail_id, $size, $attr)
  {
    if (empty($post_thumbnail_id)) {
      $default_image_url = get_home_url() . '/wp-content/themes/divi-child/assets/images/pic_post.jpg';
      $html = '<img src="' . esc_url($default_image_url) . '" class="wp-post-image" alt="Default Image"/>';
    }
    return $html;
  }
  add_filter('post_thumbnail_html', 'inforepo_set_default_featured_image', 10, 5);

  function inforepo_set_default_featured_image_url($url, $post_id)
  {
    if (empty(get_post_thumbnail_id($post_id))) {
      $url = get_home_url() . '/wp-content/themes/divi-child/assets/images/default_thumbnail.jpg';
    }
    return $url;
  }
  add_filter('default_post_thumbnail_url', 'inforepo_set_default_featured_image_url', 10, 2);



  function inforepo_filter_thumbnail_id($thumbnail_id, $post = null)
  {
    if (! $thumbnail_id) {
      $thumbnail_id = 1804;
    }

    return  $thumbnail_id;
  }
  add_filter('post_thumbnail_id', 'inforepo_filter_thumbnail_id', 20, 5);

  add_filter('trp_force_search', '__return_true');


  /**
   * Function get posts with geocodes (mapster map field location)
   * using localize scripts
   *  
   * @package inforepo
   * 
   */
  function get_geocoded_posts_mapster()
  {
    if (is_page('resources-map')) {
      $args = array(
        'posts_per_page'    => -1,
        'post_type'     => 'inforepo_resource',
        'meta_query'    => array(
          'relation'      => 'AND',
          array(
            'key'       => 'mapster_map',
            'value'     => null,
            'compare'   => '!='
          ),
          array(
            'key'       => 'mapster_map',
            'value'     => '',
            'compare'   => '!='
          )
        )
      );

      $the_query = new WP_Query($args);
      if ($the_query->have_posts()) {
        $i = 0;
        $geoPostsMapster = array();
        while ($the_query->have_posts()) : $the_query->the_post();
          $pinLink = get_permalink();
          $mapLocation = get_field('mapster_map');
          $pinTitle = get_field('acf_title');
          if ($mapLocation) {
            $mapPost = array(
              'pinLink' => $pinLink,
              'pinTitle' => $pinTitle,
              'pinPoint' => $mapLocation
            );
            array_push($geoPostsMapster, $mapPost);
          }
          $i = $i + 1;
        endwhile;
        setcookie("quantityEntries", $i, time() + 60);

        wp_reset_query();
        wp_localize_script('map-search-js', 'myMapDataMapster', $geoPostsMapster);
      }
    }
  }
  add_action('wp_enqueue_scripts', 'get_geocoded_posts_mapster');


  function get_geo_single_post()
  {
    if (is_single()) {

      $mapLocation = get_field('mapster_map');
      if ($mapLocation) {
        $mapLocationArray = array(
          'pinPoint' => $mapLocation
        );
        wp_localize_script('post-map-js', 'mapLocationData', $mapLocationArray);
      }
    }
  }
  add_action('wp_enqueue_scripts', 'get_geo_single_post');

  function inforepo_loadmore()
  {
    wp_localize_script('loadmore-js', 'ajax_object', array('ajax_url' => admin_url('admin-ajax.php')));
  }
  add_action('wp_enqueue_scripts', 'inforepo_loadmore');

  function inforepo_load_more()
  {
    $args = array(
      'post_type' => 'inforepo_resource',
      'posts_per_page' => 3,
      'paged' => $_POST['paged'],
      'tax_query' =>  array(
        'relation' => 'AND',
        array(
          'taxonomy' => 'source',
          'field' => 'slug',
          'terms' => array('public-records-requests'),
        ),
        // array(
        //     'taxonomy' => 'research-team',
        //     'field' => 'slug',
        //     'terms' => array('eb-research'),
        // ),
        array(
          'taxonomy' => 'special-content',
          'field' => 'slug',
          'terms' => array('featured')
        )
      ),
    );
    $ajaxposts = new WP_Query($args);

    $response = '';
    $max_pages = $ajaxposts->max_num_pages;

    if ($ajaxposts->have_posts()) {
      ob_start();
      while ($ajaxposts->have_posts()) : $ajaxposts->the_post();
        $response .= get_template_part('template-parts/case-item-card');
      endwhile;
      $output = ob_get_contents();
      ob_end_clean();
    } else {
      $response = '';
    }

    $result = [
      'max' => $max_pages,
      'html' => $output,
    ];
    echo json_encode($result);
    exit;
  }
  add_action('wp_ajax_inforepo_load_more', 'inforepo_load_more');
  add_action('wp_ajax_nopriv_inforepo_load_more', 'inforepo_load_more');



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

  function debug_to_console($data)
  {
    $output = $data;
    if (is_array($output))
      $output = implode(',', $output);

    echo "<script>console.log('Debug Objects: " . $output . "' );</script>";
  }




  /*************************    Register strings for internationalization   *****************************/
//   uncomment when WPML is up and running @marieleponti
//   function register_theme_strings()
//   {
//     // Only proceed if WPML is active
//     if (!function_exists('icl_register_string')) return;

//     // Register each string with context
//     icl_register_string(
//       'inforepo',                   // Text domain
//       'Card Date Format',           // String name (context)
//       __('F j, Y', 'inforepo')      // String value (with translation wrapper)
//     );
//   }
//   // Hook early to ensure strings are registered
//   add_action('wp_loaded', 'register_theme_strings', 20);

  /************************    Register strings for internationalization end  ***************************/


  ?>