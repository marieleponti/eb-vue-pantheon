<?php
if (!defined('ABSPATH')) die();

/**
 * Get Filters data (optimized).
 */
function get_filters_data(): array
{
    return [
        build_taxonomy_tree('topic', 'Topics'),
        build_taxonomy_tree('source', 'Source'), // Corregido a 'sources' según tu registro de CPT
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

/**
 * REST API Handler for Resources Catalogue and Single view
 */
// function get_resources_handler($request)
// {
//     $current_user = wp_get_current_user();

//     $can_see_private =
//         !empty($current_user->ID) && user_can($current_user, 'read_private_posts');

//     $paged = (int) ($request['page'] ?? 1);
//     $per_page = (int) ($request['per_page'] ?? 16);
//     $slug = sanitize_text_field($request['slug'] ?? '');
//     $source = sanitize_text_field($request['source'] ?? '');
//     $research_team = sanitize_text_field($request['research-team'] ?? '');

//     $args = [
//         'post_type'      => 'inforepo_resource',
//         'posts_per_page' => min($per_page, 50),
//         'paged'          => $paged,
//         'post_status'    => $can_see_private ? ['publish', 'private'] : ['publish'],
//         'orderby'        => 'date',
//         'order'          => 'DESC',
//     ];

//     $tax_query = [];

//     if (!empty($source)) {
//         $tax_query[] = [
//             'taxonomy' => 'source',
//             'field'    => 'slug',
//             'terms'    => $source,
//         ];
//     }

//     if (!empty($research_team)) {
//         $tax_query[] = [
//             'taxonomy' => 'research-team',
//             'field'    => 'slug',
//             'terms'    => $research_team,
//         ];
//     }

//     if (!empty($tax_query)) {
//     $tax_query = array_merge(
//         ['relation' => 'AND'],
//         $tax_query
//     );
//         $args['tax_query'] = $tax_query;
//     }

//     if (!empty($slug)) {
//         $args['name'] = $slug;
//         $args['posts_per_page'] = 1;
//     }

//     $query = new WP_Query($args);

//     $formatted = inforepo_format_resources_response($query);

//     $items = $formatted['items'] ?? [];
//     $total = $formatted['total'] ?? 0;

//     return rest_ensure_response([
//         'items'       => array_values($items),
//         'total'       => (int) $total,
//         'total_pages' => (int) $query->max_num_pages,
//         'item'        => $items[0] ?? null,
//     ]);
// }
function get_resources_handler($request)
{
    $current_user = wp_get_current_user();

    $can_see_private =
        !empty($current_user->ID) && user_can($current_user, 'read_private_posts');

    $paged = (int) ($request['page'] ?? 1);
    $per_page = (int) ($request['per_page'] ?? 16);
    $slug = sanitize_text_field($request['slug'] ?? '');
    $source = sanitize_text_field($request['source'] ?? '');
    $research_team = sanitize_text_field($request['research-team'] ?? '');

    $args = [
        'post_type'      => 'inforepo_resource',
        'posts_per_page' => min($per_page, 50),
        'paged'          => $paged,
        'post_status'    => $can_see_private ? ['publish', 'private'] : ['publish'],
        'orderby'        => 'date',
        'order'          => 'DESC',
    ];

    $tax_query = ['relation' => 'AND'];

    if (!empty($source)) {
        $tax_query[] = [
            'taxonomy' => 'source',
            'field'    => 'slug',
            'terms'    => $source,
        ];
    }

    if (!empty($research_team)) {
        $tax_query[] = [
            'taxonomy' => 'research-team',
            'field'    => 'slug',
            'terms'    => $research_team,
        ];
    }

    if (count($tax_query) > 1) {
        $args['tax_query'] = $tax_query;
    }

    if (!empty($slug)) {
        $args['name'] = $slug;
        $args['posts_per_page'] = 1;
    }

    $query = new WP_Query($args);

    $formatted = inforepo_format_resources_response($query);

    return rest_ensure_response([
        'items'       => $formatted['items'],
        'total'       => (int) $formatted['total'],
        'total_pages' => (int) $query->max_num_pages,
        'item'        => $formatted['items'][0] ?? null,
    ]);
}

/**
 * Procesa la colección de recursos y mapea sus taxonomías y campos ACF de forma segura.
 */
function inforepo_format_resources_response($query)
{
    if (empty($query->posts)) {
        return ['items' => [], 'total' => 0];
    }

    $items = array_map(function ($post) {
        // Helper interno para taxonomías usando los slugs exactos de tu plugin CPT
        $get_attached_terms = function ($post_id, $taxonomy) {
            $terms = get_the_terms($post_id, $taxonomy);
            if (is_wp_error($terms) || empty($terms)) return [];
            return array_map(function ($term) {
                return [
                    'name' => $term->name,
                    'slug' => $term->slug
                ];
            }, $terms);
        };

        // --- PROCESAR AUTOR DE ACF ('author') ---
        $acf_author = function_exists('get_field') ? get_field('author', $post->ID) : get_post_meta($post->ID, 'author', true);
        $author_name = '';
        if (!empty($acf_author)) {
            if (is_array($acf_author)) {
                $author_name = $acf_author['display_name'] ?? $acf_author['post_title'] ?? '';
            } elseif (is_object($acf_author)) {
                $author_name = $acf_author->display_name ?? $acf_author->post_title ?? '';
            } else {
                $author_name = $acf_author;
            }
        }

        // --- PROCESAR ARCHIVO DE ACF ('upload_files') ---
        $acf_file_raw = function_exists('get_field') ? get_field('upload_files', $post->ID) : null;

        $file_url = '';
        if (is_array($acf_file_raw)) {
            $first = $acf_file_raw[0] ?? null;
            $file_url = is_array($first) ? ($first['url'] ?? '') : ($acf_file_raw['url'] ?? '');
        } elseif (is_string($acf_file_raw)) {
            $file_url = $acf_file_raw;
        }

        return [
            'id'            => $post->ID,
            'slug'          => $post->post_name,
            'title'         => get_the_title($post),
            'date'          => get_the_date('', $post),
            'permalink'     => get_permalink($post),
            'excerpt'       => get_the_excerpt($post), // Mantenido por si tu grid lo usa
            'featuredImage' => get_the_post_thumbnail_url($post->ID, 'large'),

            // Campos Personalizados de ACF sincronizados con tus nombres reales
            // 'acf' => [
            //     'description'      => function_exists('get_field') ? get_field('description', $post->ID) : get_post_meta($post->ID, 'description', true),
            //     'author'           => $author_name,
            //     'file_url'         => $file_url,
            //     'link_to_resource' => function_exists('get_field') ? get_field('link_to_resource', $post->ID) : get_post_meta($post->ID, 'link_to_resource', true),
            //     'video_embed'      => function_exists('get_field') ? get_field('embed_video', $post->ID) : get_post_meta($post->ID, 'embed_video', true),
            // ],

            'acf' => [
                'description' => function_exists('get_field') ? get_field('description', $post->ID) : get_post_meta($post->ID, 'description', true),
                'author' => $author_name,
                'file_url' => $file_url,
                'upload_files_raw' => $acf_file_raw, // <-- AGREGA ESTO
                'link_to_resource' => function_exists('get_field') ? get_field('link_to_resource', $post->ID) : get_post_meta($post->ID, 'link_to_resource', true),
                'video_embed' => function_exists('get_field') ? get_field('embed_video', $post->ID) : get_post_meta($post->ID, 'embed_video', true),
            ],


            // Taxonomías vinculadas con los slugs reales declarados en tu plugin
            'taxonomies' => [
                'authoring_organization' => $get_attached_terms($post->ID, 'authoring-organization'),
                'country'                => $get_attached_terms($post->ID, 'country'),
                'topic'                  => $get_attached_terms($post->ID, 'topic'),
                'source'                 => $get_attached_terms($post->ID, 'source'),
                'format'                 => $get_attached_terms($post->ID, 'format'),
                'city_community'         => $get_attached_terms($post->ID, 'city-community'), // Cambiado a 'city-community'
                'language'               => $get_attached_terms($post->ID, 'language'),
            ]
        ];
    }, $query->posts);

    return [
        'items' => $items,
        'total' => (int) $query->found_posts
    ];
}
