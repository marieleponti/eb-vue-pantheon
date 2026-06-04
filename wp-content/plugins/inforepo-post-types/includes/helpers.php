<?php

/**
 * Get Filters data (optimized).
 */
function get_filters_data(): array
{
    return [
        build_taxonomy_tree('topic', 'Topics'),
        build_taxonomy_tree('source', 'Source'),
        build_taxonomy_tree('format', 'Format'),
        build_taxonomy_tree('country', 'Countries'),
        build_taxonomy_tree('language', 'Language'),
    ];
}

/**
 * Build hierarchical taxonomy tree (FAST).
 */
function build_taxonomy_tree(string $taxonomy, string $label): array
{
    $terms = get_terms([
        'taxonomy'   => $taxonomy,
        'hide_empty' => true,
    ]);

    if (is_wp_error($terms) || empty($terms)) {
        return [
            'label'    => $label,
            'slug'     => $taxonomy,
            'children' => [],
        ];
    }

    // Agrupar por parent
    $grouped = [];
    foreach ($terms as $term) {
        $grouped[$term->parent][] = $term;
    }

    // Construir árbol recursivo
    $build_tree = function ($parent_id) use (&$build_tree, $grouped) {
        $branch = [];

        if (!isset($grouped[$parent_id])) {
            return $branch;
        }

        foreach ($grouped[$parent_id] as $term) {
            $item = [
                'label' => $term->name,
                'slug'  => $term->slug,
                'value' => $term->term_id,
            ];

            $children = $build_tree($term->term_id);

            if (!empty($children)) {
                $item['children'] = $children;
            }

            $branch[] = $item;
        }

        return $branch;
    };

    return [
        'label'    => $label,
        'slug'     => $taxonomy,
        'children' => $build_tree(0),
    ];
}


function get_private_resources()
{
    return get_posts([
        'post_type' => 'inforepo_resource',
        'post_status' => ['publish', 'private'],
        'numberposts' => -1,
    ]);
}

function get_public_resources()
{

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

function get_resources_handler($request)
{

    $params = $request->get_params();

    $user = wp_get_current_user();

    error_log('USER ID: ' . $user->ID);
    error_log('LOGGED IN: ' . (is_user_logged_in() ? 'YES' : 'NO'));

    $paged = isset($params['page']) ? (int) $params['page'] : 1;
    $per_page = isset($params['per_page']) ? (int) $params['per_page'] : 16;

    $args = [
        'post_type'      => 'inforepo_resource',
        'post_status' => ['publish', 'private'],
        'posts_per_page' => $per_page,
        'paged'          => $paged,
    ];

    if (!is_user_logged_in()) {
        $args['post_status'] = 'publish';
    }

    $tax_query = [];

    foreach (
        [
            'topic',
            'country',
            'format',
            'source',
            'language',
            'research-team',
            'special-content',
            'authoring-organization'
        ] as $tax
    ) {
        if (!empty($params[$tax])) {
            $tax_query[] = [
                'taxonomy' => $tax,
                'field'    => 'slug',
                'terms' => array_map('sanitize_title', explode(',', $params[$tax])),
            ];
        }
    }

    if (!empty($tax_query)) {
        $args['tax_query'] = $tax_query;
    }

    error_log('FINAL ARGS: ' . print_r($args, true));
    $query = new WP_Query($args);

    error_log(print_r($params, true));
    error_log(print_r($args, true));

    $items = array_map(function ($post) {

        return [
            'id'         => $post->ID,
            'title'      => get_the_title($post),
            'excerpt'    => get_the_excerpt($post),
            'date'       => get_the_date('', $post),
            'permalink'  => get_permalink($post),
            'featuredImage' => get_the_post_thumbnail_url($post->ID, 'large'),
        ];
    }, $query->posts);

    return rest_ensure_response([
        // 'debug' => [
        //     'user_id' => $user->ID,
        //     'logged_in' => is_user_logged_in(),
        //     'roles' => $user->roles ?? [],
        // ],
        // 'items' => $items,
        // 'total' => $query->found_posts,
        // 'total_pages' => $query->max_num_pages,
        'TEST' => 'PHP MODIFICADO',
    ]);
}
