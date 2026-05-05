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