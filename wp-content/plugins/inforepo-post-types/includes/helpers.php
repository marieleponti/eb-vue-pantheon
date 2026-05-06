<?php
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