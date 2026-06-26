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
 * REEMPLAZO FINAL de get_resources_handler() en tu helpers.php.
 * Incluye los dos fixes: tax_query (topic/format/country/language +
 * soporte multi-selección) y búsqueda por texto (título + ACF description).
 *
 * Por qué la búsqueda mira título Y description por separado:
 * el post_content/excerpt de este CPT casi siempre está vacío (el texto
 * real vive en el campo ACF "description"), así que la búsqueda nativa de
 * WP ('s' => $search, que solo mira título y post_content) por sí sola
 * encuentra casi nada. Por eso se buscan IDs por título (nativo) y por
 * meta "description" (LIKE) por separado, y se combinan con post__in.
 */
function get_resources_handler($request)
{
    $current_user = wp_get_current_user();

    $can_see_private =
        !empty($current_user->ID) && user_can($current_user, 'read_private_posts');

    $post_status = $can_see_private ? ['publish', 'private'] : ['publish'];

    $paged = (int) ($request['page'] ?? 1);
    $per_page = (int) ($request['per_page'] ?? 16);
    $slug = sanitize_text_field($request['slug'] ?? '');
    $source = sanitize_text_field($request['source'] ?? '');
    $research_team = sanitize_text_field($request['research-team'] ?? '');
    $topic = sanitize_text_field($request['topic'] ?? '');
    $format = sanitize_text_field($request['format'] ?? '');
    $country = sanitize_text_field($request['country'] ?? '');
    $language = sanitize_text_field($request['language'] ?? '');
    $search = sanitize_text_field($request['search'] ?? '');

    $args = [
        'post_type'      => 'inforepo_resource',
        'posts_per_page' => min($per_page, 50),
        'paged'          => $paged,
        'post_status'    => $post_status,
        'orderby'        => 'date',
        'order'          => 'DESC',
    ];

    // "slug1,slug2" -> ['slug1', 'slug2']
    $split_terms = function (string $value): array {
        return array_values(array_filter(array_map('trim', explode(',', $value))));
    };

    // ===== Taxonomías =====
    $tax_query = ['relation' => 'AND'];

    $taxonomy_filters = [
        'source'        => $source,
        'research-team' => $research_team,
        'topic'         => $topic,
        'format'        => $format,
        'country'       => $country,
        'language'      => $language,
    ];

    foreach ($taxonomy_filters as $taxonomy => $value) {
        if (!empty($value)) {
            $tax_query[] = [
                'taxonomy' => $taxonomy,
                'field'    => 'slug',
                'terms'    => $split_terms($value),
            ];
        }
    }

    if (count($tax_query) > 1) {
        $args['tax_query'] = $tax_query;
    }

    // ===== Búsqueda por texto (título + ACF "description") =====
    if (!empty($search)) {
        $title_matches = get_posts([
            'post_type'      => 'inforepo_resource',
            'post_status'    => $post_status,
            'posts_per_page' => -1,
            'fields'         => 'ids',
            's'              => $search,
        ]);

        $description_matches = get_posts([
            'post_type'      => 'inforepo_resource',
            'post_status'    => $post_status,
            'posts_per_page' => -1,
            'fields'         => 'ids',
            'meta_query'     => [
                [
                    'key'     => 'description',
                    'value'   => $search,
                    'compare' => 'LIKE',
                ],
            ],
        ]);

        $matching_ids = array_values(array_unique(array_merge($title_matches, $description_matches)));

        // Si no matchea nada, forzamos un ID imposible para que WP_Query
        // devuelva 0 resultados (en vez de ignorar el filtro y devolver todo).
        $args['post__in'] = !empty($matching_ids) ? $matching_ids : [0];
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
 * REEMPLAZO de inforepo_format_resources_response() en tu helpers.php.
 *
 * Único cambio real: el bloque `// === NUEVO: location ===` antes del
 * return del array 'acf'. El resto es idéntico a lo que ya tenías.
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

        $upload_files = [];
        $file_url = '';

        if (is_array($acf_file_raw)) {
            foreach ($acf_file_raw as $row) {
                // Esperado según tu debug: [{ upload_file: { url, title } }, ...]
                if (is_array($row) && isset($row['upload_file']) && is_array($row['upload_file'])) {
                    $url = $row['upload_file']['url'] ?? '';
                    $title = $row['upload_file']['title'] ?? '';
                    if ($url) $upload_files[] = ['file' => ['url' => $url, 'title' => $title]];
                }
                // Por si acaso otros formatos:
                elseif (is_array($row) && isset($row['url'])) {
                    $url = $row['url'];
                    $title = $row['title'] ?? '';
                    if ($url) $upload_files[] = ['file' => ['url' => $url, 'title' => $title]];
                } elseif (is_array($row) && isset($row['file']['url'])) {
                    $url = $row['file']['url'];
                    $title = $row['file']['title'] ?? '';
                    if ($url) $upload_files[] = ['file' => ['url' => $url, 'title' => $title]];
                } elseif (is_numeric($row)) {
                    $id = (int)$row;
                    $url = wp_get_attachment_url($id) ?: '';
                    $title = get_the_title($id);
                    if ($url) $upload_files[] = ['file' => ['url' => $url, 'title' => $title]];
                }
            }

            // Primer PDF para tu viewer/botón simple
            if (!empty($upload_files)) {
                $file_url = $upload_files[0]['file']['url'] ?? '';
            }
        }

        // === NUEVO: location (reemplaza Mapster) ===
        // get_field('location', $post->ID) devuelve el group ACF
        // { search, lat, lng } armado en wp-location-picker/.
        $acf_location = function_exists('get_field') ? get_field('location', $post->ID) : null;

        $location = null;
        if (!empty($acf_location)) {
            $lat = $acf_location['lat'] ?? null;
            $lng = $acf_location['lng'] ?? null;
            $location = [
                'lat'   => ($lat !== null && $lat !== '') ? (float) $lat : null,
                'lng'   => ($lng !== null && $lng !== '') ? (float) $lng : null,
                'label' => $acf_location['search'] ?? null,
            ];
        }
        // === FIN NUEVO ===

        return [
            'id'            => $post->ID,
            'slug'          => $post->post_name,
            'title'         => get_the_title($post),
            'date'          => get_the_date('', $post),
            'permalink'     => get_permalink($post),
            'excerpt'       => get_the_excerpt($post), // Mantenido por si tu grid lo usa
            'content'       => apply_filters('the_content', $post->post_content), 
            'featuredImage' => get_the_post_thumbnail_url($post->ID, 'large'),

            'acf' => [
                'description' => function_exists('get_field') ? get_field('description', $post->ID) : get_post_meta($post->ID, 'description', true),
                'author' => $author_name,
                'file_url' => $file_url,
                'upload_files' => $upload_files,
                'upload_files_raw' => $acf_file_raw,

                'link_to_resource' => function_exists('get_field') ? get_field('link_to_resource', $post->ID) : get_post_meta($post->ID, 'link_to_resource', true),
                'video_embed' => function_exists('get_field') ? get_field('embed_video', $post->ID) : get_post_meta($post->ID, 'embed_video', true),

                'location' => $location, // NUEVO
            ],

            // Taxonomías vinculadas con los slugs reales declarados en tu plugin
            'taxonomies' => [
                'authoring_organization' => $get_attached_terms($post->ID, 'authoring-organization'),
                'country'                => $get_attached_terms($post->ID, 'country'),
                'topic'                  => $get_attached_terms($post->ID, 'topic'),
                'source'                 => $get_attached_terms($post->ID, 'source'),
                'format'                 => $get_attached_terms($post->ID, 'format'),
                'city_community'         => $get_attached_terms($post->ID, 'city-community'),
                'language'               => $get_attached_terms($post->ID, 'language'),
            ]
        ];
    }, $query->posts);

    return [
        'items' => $items,
        'total' => (int) $query->found_posts
    ];
}
/**
 * Procesa la colección de recursos y mapea sus taxonomías y campos ACF de forma segura.
 */
// function inforepo_format_resources_response($query)
// {
//     if (empty($query->posts)) {
//         return ['items' => [], 'total' => 0];
//     }

//     $items = array_map(function ($post) {
//         // Helper interno para taxonomías usando los slugs exactos de tu plugin CPT
//         $get_attached_terms = function ($post_id, $taxonomy) {
//             $terms = get_the_terms($post_id, $taxonomy);
//             if (is_wp_error($terms) || empty($terms)) return [];
//             return array_map(function ($term) {
//                 return [
//                     'name' => $term->name,
//                     'slug' => $term->slug
//                 ];
//             }, $terms);
//         };

//         // --- PROCESAR AUTOR DE ACF ('author') ---
//         $acf_author = function_exists('get_field') ? get_field('author', $post->ID) : get_post_meta($post->ID, 'author', true);
//         $author_name = '';
//         if (!empty($acf_author)) {
//             if (is_array($acf_author)) {
//                 $author_name = $acf_author['display_name'] ?? $acf_author['post_title'] ?? '';
//             } elseif (is_object($acf_author)) {
//                 $author_name = $acf_author->display_name ?? $acf_author->post_title ?? '';
//             } else {
//                 $author_name = $acf_author;
//             }
//         }

//         // --- PROCESAR ARCHIVO DE ACF ('upload_files') ---

//         // Commenting out to troubleshoot pdf render on Resource Single
//         // $acf_file_raw = function_exists('get_field') ? get_field('upload_files', $post->ID) : null;

//         // $file_url = '';
//         // if (is_array($acf_file_raw)) {
//         //     $first = $acf_file_raw[0] ?? null;
//         //     $file_url = is_array($first) ? ($first['url'] ?? '') : ($acf_file_raw['url'] ?? '');
//         // } elseif (is_string($acf_file_raw)) {
//         //     $file_url = $acf_file_raw;
//         // }

//         $acf_file_raw = function_exists('get_field') ? get_field('upload_files', $post->ID) : null;

//         $upload_files = [];
//         $file_url = '';

//         if (is_array($acf_file_raw)) {
//             foreach ($acf_file_raw as $row) {
//                 // Esperado según tu debug: [{ upload_file: { url, title } }, ...]
//                 if (is_array($row) && isset($row['upload_file']) && is_array($row['upload_file'])) {
//                     $url = $row['upload_file']['url'] ?? '';
//                     $title = $row['upload_file']['title'] ?? '';
//                     if ($url) $upload_files[] = ['file' => ['url' => $url, 'title' => $title]];
//                 }
//                 // Por si acaso otros formatos:
//                 elseif (is_array($row) && isset($row['url'])) {
//                     $url = $row['url'];
//                     $title = $row['title'] ?? '';
//                     if ($url) $upload_files[] = ['file' => ['url' => $url, 'title' => $title]];
//                 } elseif (is_array($row) && isset($row['file']['url'])) {
//                     $url = $row['file']['url'];
//                     $title = $row['file']['title'] ?? '';
//                     if ($url) $upload_files[] = ['file' => ['url' => $url, 'title' => $title]];
//                 } elseif (is_numeric($row)) {
//                     $id = (int)$row;
//                     $url = wp_get_attachment_url($id) ?: '';
//                     $title = get_the_title($id);
//                     if ($url) $upload_files[] = ['file' => ['url' => $url, 'title' => $title]];
//                 }
//             }

//             // Primer PDF para tu viewer/botón simple
//             if (!empty($upload_files)) {
//                 $file_url = $upload_files[0]['file']['url'] ?? '';
//             }
//         }

//         return [
//             'id'            => $post->ID,
//             'slug'          => $post->post_name,
//             'title'         => get_the_title($post),
//             'date'          => get_the_date('', $post),
//             'permalink'     => get_permalink($post),
//             'excerpt'       => get_the_excerpt($post), // Mantenido por si tu grid lo usa
//             'featuredImage' => get_the_post_thumbnail_url($post->ID, 'large'),

//             'acf' => [
//                 'description' => function_exists('get_field') ? get_field('description', $post->ID) : get_post_meta($post->ID, 'description', true),
//                 'author' => $author_name,
//                 'file_url' => $file_url,
//                 'upload_files' => $upload_files,
//                 'upload_files_raw' => $acf_file_raw,

//                 'link_to_resource' => function_exists('get_field') ? get_field('link_to_resource', $post->ID) : get_post_meta($post->ID, 'link_to_resource', true),
//                 'video_embed' => function_exists('get_field') ? get_field('embed_video', $post->ID) : get_post_meta($post->ID, 'embed_video', true),
//             ],

//             // Taxonomías vinculadas con los slugs reales declarados en tu plugin
//             'taxonomies' => [
//                 'authoring_organization' => $get_attached_terms($post->ID, 'authoring-organization'),
//                 'country'                => $get_attached_terms($post->ID, 'country'),
//                 'topic'                  => $get_attached_terms($post->ID, 'topic'),
//                 'source'                 => $get_attached_terms($post->ID, 'source'),
//                 'format'                 => $get_attached_terms($post->ID, 'format'),
//                 'city_community'         => $get_attached_terms($post->ID, 'city-community'), // Cambiado a 'city-community'
//                 'language'               => $get_attached_terms($post->ID, 'language'),
//             ]
//         ];
//     }, $query->posts);

//     return [
//         'items' => $items,
//         'total' => (int) $query->found_posts
//     ];
// }
