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

/**
 * REST API Handler for Resources Catalogue and Single view
 */
function get_resources_handler($request)
{
    $params = $request->get_params();
    $user = wp_get_current_user();

    $paged = isset($params['page']) ? (int) $params['page'] : 1;
    $per_page = isset($params['per_page']) ? (int) $params['per_page'] : 16;
    $slug = isset($params['slug']) ? sanitize_title($params['slug']) : null;

    $user = wp_get_current_user();

    $can_see_private =
        current_user_can('read_private_posts') ||
        current_user_can('edit_others_posts');

    $args = [
        'post_type'      => 'inforepo_resource',
        'posts_per_page' => $per_page,
        'paged'          => $paged,
    ];

    if ($can_see_private) {
        $args['post_status'] = ['publish', 'private'];
    } else {
        $args['post_status'] = ['publish'];
    }

    $tax_query = [];

    // Ajustamos la verificación de parámetros a los slugs exactos de tu CPT
    foreach (
        [
            'topic',
            'country',
            'format',
            'source', 
            'language',
            'research-team',
            'special-content',
            'authoring-organization',
            'city-community' // Añadido para soportar filtros por URL si lo necesitas después
        ] as $tax
    ) {
        // Soporte dinámico por si el frontend manda el query como 'source' o 'sources'
        $param_key = ($tax === 'sources' && empty($params['sources']) && !empty($params['source'])) ? 'source' : $tax;

        if (!empty($params[$param_key])) {
            $tax_query[] = [
                'taxonomy' => $tax,
                'field'    => 'slug',
                'terms'    => array_map('sanitize_title', explode(',', $params[$param_key])),
            ];
        }
    }

    if (!empty($tax_query)) {
        $args['tax_query'] = $tax_query;
    }

    if (!empty($slug)) {
        $args['name'] = $slug; 
    }

    $query = new WP_Query($args);
    
    // ¡AQUÍ ESTÁ LA MAGIA! Ejecutamos tu formateador optimizado con ACF y Taxonomías
    $formatted_data = inforepo_format_resources_response($query);

    return rest_ensure_response([
        'debug' => [
            'auth_header' => $_SERVER['HTTP_AUTHORIZATION'] ?? 'MISSING',
            'server_auth' => $_SERVER['HTTP_AUTHORIZATION'] ?? 'MISSING',
            'apache_auth' => $_SERVER['REDIRECT_HTTP_AUTHORIZATION'] ?? 'MISSING',
            'user_id'     => $user->ID,
            'logged_in'   => is_user_logged_in(),
            'roles'       => $user->roles ?? [],
        ],
        'items'       => $formatted_data['items'],
        'total'       => $formatted_data['total'],
        'total_pages' => $query->max_num_pages,   
    ]);
}

/**
 * Procesa la colección de recursos y mapea sus taxonomías y campos ACF de forma segura.
 */
function inforepo_format_resources_response($query) {
    if (empty($query->posts)) {
        return ['items' => [], 'total' => 0];
    }

    $items = array_map(function ($post) {
        // Helper interno para taxonomías usando los slugs exactos de tu plugin CPT
        $get_attached_terms = function($post_id, $taxonomy) {
            $terms = get_the_terms($post_id, $taxonomy);
            if (is_wp_error($terms) || empty($terms)) return [];
            return array_map(function($term) {
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
        $acf_file = function_exists('get_field') ? get_field('upload_files', $post->ID) : null;
        $file_url = '';
        if (!empty($acf_file)) {
            $file_url = is_array($acf_file) ? ($acf_file['url'] ?? '') : $acf_file;
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
            'acf' => [
                'description'      => function_exists('get_field') ? get_field('description', $post->ID) : get_post_meta($post->ID, 'description', true),
                'author'           => $author_name,
                'file_url'         => $file_url,
                'link_to_resource' => function_exists('get_field') ? get_field('link_to_resource', $post->ID) : get_post_meta($post->ID, 'link_to_resource', true),
                'video_embed'      => function_exists('get_field') ? get_field('embed_video', $post->ID) : get_post_meta($post->ID, 'embed_video', true),
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