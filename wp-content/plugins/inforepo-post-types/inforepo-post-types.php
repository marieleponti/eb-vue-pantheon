<?php

/**
 * Info Repo Post Types
 *
 * @author            mariele ponti
 * @copyright         2024 iLIT
 * @license           GPL-2.0-or-later
 *
 * @wordpress-plugin
 * Plugin Name:       Info Repo Post Types Plugin
 * Plugin URI:        
 * Description:       
 * Version:           1.0.0
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            mariele ponti
 * Author URI:        
 * Text Domain:       inforepo-post-types
 * License:           GPL v2 or later
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Update URI:        
 */

if (!defined('ABSPATH')) die();

// Register Custom Post Type
function inforepo_resource_post_type()
{

    $labels = array(
        'name'                  => _x('Resources', 'Post Type General Name', 'inforepo'),
        'singular_name'         => _x('Resource', 'Post Type Singular Name', 'inforepo'),
        'menu_name'             => __('Resources', 'inforepo'),
        'name_admin_bar'        => __('Resource', 'inforepo'),
        'archives'              => __('File', 'inforepo'),
        'attributes'            => __('Attributes', 'inforepo'),
        'parent_item_colon'     => __('Parent Item', 'inforepo'),
        'all_items'             => __('All Items', 'inforepo'),
        'add_new_item'          => __('Add Item', 'inforepo'),
        'add_new'               => __('Add Item', 'inforepo'),
        'new_item'              => __('New Item', 'inforepo'),
        'edit_item'             => __('Edit Item', 'inforepo'),
        'update_item'           => __('Update Item', 'inforepo'),
        'view_item'             => __('View Item', 'inforepo'),
        'view_items'            => __('View Items', 'inforepo'),
        'search_items'          => __('Search Items', 'inforepo'),
        'not_found'             => __('Not Found', 'inforepo'),
        'not_found_in_trash'    => __('Not Found In Trash', 'inforepo'),
        'featured_image'        => __('Featured Image', 'inforepo'),
        'set_featured_image'    => __('Save Featured Image', 'inforepo'),
        'remove_featured_image' => __('Remove Featured Image', 'inforepo'),
        'use_featured_image'    => __('Use Featured Image', 'inforepo'),
        'insert_into_item'      => __('Insert Into Item', 'inforepo'),
        'uploaded_to_this_item' => __('Upload to this Item', 'inforepo'),
        'items_list'            => __('Items List', 'inforepo'),
        'items_list_navigation' => __('Resource List Navigation', 'inforepo'),
        'filter_items_list'     => __('Filter Resources', 'inforepo'),
    );
    $args = array(
        'label'                 => __('Resource', 'inforepo'),
        'description'           => __('Resource Libary', 'inforepo'),
        'labels'                => $labels,
        'supports'              => array('title', 'editor', 'excerpt', 'author', 'thumbnail', 'comments', 'revisions', 'custom-fields', 'page-attributes'),
        'hierarchical'          => false, // cuando es verdad, funciona como página
        'public'                => true, //Whether a post type is intended for use publicly either via the admin interface or by front-end users. 
        'show_in_rest'          => true,
        'show_ui'               => true,
        'show_in_menu'          => true,
        'menu_position'         => 6,
        'menu_icon'             => 'dashicons-book-alt',
        'show_in_admin_bar'     => true,
        'show_in_nav_menus'     => true,
        'can_export'            => true,
        'has_archive'           => 'resources', // set to false to eliminate /resources/ page
        // 'posts_per_page'        => -1,
        'exclude_from_search'   => false, // Whether to exclude posts with this post type from front end search results
        'publicly_queryable'    => true, // Whether queries can be performed on the front end for the post type as part of parse_request().
        'capability_type'       => 'post',
        'map_meta_cap'          => true,
        'query_var'             => true,
        'rewrite'               => array('slug' => 'resources')
    );

    register_post_type('inforepo_resource', $args);
}
add_action('init', 'inforepo_resource_post_type', 0);

/**
 * start register taxonomies for post type inforepo_resources
 */
function register_resource_taxonomies()
{
    register_taxonomy(
        'format',
        'inforepo_resource',
        array(
            'labels' => array(
                'name' => 'Formats',
                'singular_name' => 'Format',
                'menu_name' => 'Formats',
                'all_items' => 'All Formats',
                'edit_item' => 'Edit Format',
                'view_item' => 'View Format',
                'update_item' => 'Update Format',
                'add_new_item' => 'Add New Format',
                'new_item_name' => 'New Format Name',
                'search_items' => 'Search Formats',
                'not_found' => 'No formats found',
                'no_terms' => 'No formats',
                'items_list_navigation' => 'Formats list navigation',
                'items_list' => 'Formats list',
                'back_to_items' => '← Go to formats',
                'item_link' => 'Format Link',
                'item_link_description' => 'A link to a format',
            ),
            'public' => true,
            'hierarchical' => true,
            'show_in_menu' => true,
            'show_ui'      => true,
            'meta_box_cb'           => false,
            'show_in_rest' => true,
            'query_var' => true,
            'rewrite' => array('slug' => 'format')

        )
    );

    register_taxonomy(
        'topic',
        'inforepo_resource',
        array(
            'labels' => array(
                'name' => 'Resource Topics',
                'singular_name' => 'Resource Topic',
                'menu_name' => 'Resource Topics',
                'all_items' => 'All Resource Topics',
                'edit_item' => 'Edit Resource Topic',
                'view_item' => 'View Resource Topic',
                'update_item' => 'Update Resource Topic',
                'add_new_item' => 'Add New Resource Topic',
                'new_item_name' => 'New Resource Topic Name',
                'search_items' => 'Search Resource Topics',
                'not_found' => 'No resource topics found',
                'no_terms' => 'No resource topics',
                'items_list_navigation' => 'Resource Topics list navigation',
                'items_list' => 'Resource Topics list',
                'back_to_items' => '← Go to resource topics',
                'item_link' => 'Resource Topic Link',
                'item_link_description' => 'A link to a resource topic',
            ),
            'public' => true,
            'hierarchical' => true,
            'show_in_menu' => true,
            'show_ui'      => true,
            'meta_box_cb'           => false,
            'show_in_rest' => true,
            'query_var' => true,
            'rewrite' => array('slug' => 'topic'),
        )
    );

    register_taxonomy(
        'country',
        'inforepo_resource',
        array(
            'labels' => array(
                'name' => 'Countries',
                'singular_name' => 'Country',
                'menu_name' => 'Country',
                'all_items' => 'All Countries',
                'edit_item' => 'Edit Countries',
                'view_item' => 'View Countries',
                'update_item' => 'Update Countries',
                'add_new_item' => 'Add New Country',
                'new_item_name' => 'New Country Name',
                'search_items' => 'Search Countries',
                'not_found' => 'No country found',
                'no_terms' => 'No country',
                'items_list_navigation' => 'Country list navigation',
                'items_list' => 'Country list',
                'back_to_items' => '← Go to country',
                'item_link' => 'Country Link',
                'item_link_description' => 'A link to a country',
            ),
            'public' => true,
            'hierarchical' => true,
            'show_in_menu' => true,
            'show_ui'      => true,
            'meta_box_cb'           => false,
            'show_in_rest' => true,
            'query_var' => true,
            'rewrite' => array('slug' => 'country')
        )
    );

    register_taxonomy(
        'city_community',
        'inforepo_resource',
        array(
            'labels' => array(
                'name' => 'Cities/Communities',
                'singular_name' => 'City/Community',
                'menu_name' => 'Cities/Communities',
                'all_items' => 'All Cities/Communities',
                'edit_item' => 'Edit Cities/Communities',
                'view_item' => 'View Cities/Communities',
                'update_item' => 'Update Cities/Communities',
                'add_new_item' => 'Add New City/Community',
                'new_item_name' => 'New City/Community Name',
                'search_items' => 'Search Cities/Communities',
                'not_found' => 'No city/community found',
                'no_terms' => 'No city/community',
                'items_list_navigation' => 'City/Community list navigation',
                'items_list' => 'City/Community list',
                'back_to_items' => '← Go to city/community',
                'item_link' => 'city/community Link',
                'item_link_description' => 'A link to a city/community',
            ),
            'public' => true,
            'hierarchical' => true,
            'show_in_menu' => true,
            'show_ui'      => true,
            'meta_box_cb'           => false,
            'show_in_rest' => true,
            'query_var' => true,
            'rewrite' => array('slug' => 'city-community')
        )
    );

    register_taxonomy(
        'source',
        'inforepo_resource',
        array(
            'labels' => array(
                'name' => 'Sources',
                'singular_name' => 'Source',
                'menu_name' => 'Sources',
                'all_items' => 'All Sources',
                'edit_item' => 'Edit Sources',
                'view_item' => 'View Sources',
                'update_item' => 'Update Sources',
                'add_new_item' => 'Add New Source',
                'new_item_name' => 'New Source',
                'search_items' => 'Search Sources',
                'not_found' => 'No source found',
                'no_terms' => 'No source',
                'items_list_navigation' => 'Source list navigation',
                'items_list' => 'Source list',
                'back_to_items' => '← Go to source',
                'item_link' => 'Source Link',
                'item_link_description' => 'A link to a source',
            ),
            'public' => true,
            'hierarchical' => true,
            'show_in_menu' => true,
            'show_ui'      => true,
            'meta_box_cb'           => false,
            'show_in_rest' => true,
            'query_var' => true,
            'rewrite' => array('slug' => 'sources')
        )
    );

    register_taxonomy(
        'visibility',
        'inforepo_resource',
        array(
            'labels' => array(
                'name' => 'Visibility',
                'singular_name' => 'Visibility',
                'menu_name' => 'Visibility',
                'all_items' => 'Public or Private',
                'edit_item' => 'Edit Visibility',
                'view_item' => 'View Visibility',
                'update_item' => 'Update Visibility',
                'add_new_item' => 'Add New Visibility',
                'new_item_name' => 'New Visibility',
                'search_items' => 'Search by Visibility',
                'not_found' => 'No visibility found',
                'no_terms' => 'No visibility',
                'items_list_navigation' => 'Public/private navigation',
                'items_list' => 'Visibility list',
                'back_to_items' => '← Go to visibility',
                'item_link' => 'Visibility Link',
                'item_link_description' => 'A link to visibility type',
            ),
            'capabilities' => array(
                'edit_terms' => false
            ),
            'public' => true,
            'hierarchical' => true,
            'show_in_menu' => true,
            'show_ui'      => true,
            'meta_box_cb'  => false,
            'show_in_rest' => true,
            'query_var' => true,
            'rewrite' => false,
            'default_term' => [
                'name' => 'Private',
                'slug' => 'private'
            ]
        )
    );

    register_taxonomy(
        'language',
        'inforepo_resource',
        array(
            'labels' => array(
                'name' => 'Languages',
                'singular_name' => 'Language',
                'menu_name' => 'Language',
                'all_items' => 'All Languages',
                'edit_item' => 'Edit Language',
                'view_item' => 'View Language',
                'update_item' => 'Update Language',
                'add_new_item' => 'Add New Language',
                'new_item_name' => 'New Language',
                'search_items' => 'Search by Language',
                'not_found' => 'No language found',
                'no_terms' => 'No language',
                'items_list_navigation' => 'Language navigation',
                'items_list' => 'Language list',
                'back_to_items' => '← Go to language',
                'item_link' => 'Language Link',
                'item_link_description' => 'A link to language type',
            ),
            'public' => true,
            'hierarchical' => true,
            'show_in_menu' => true,
            'show_ui'      => true,
            'meta_box_cb'  => false,
            'show_in_rest' => true,
            'query_var' => true,
            'rewrite' => array('slug' => 'language')
        )
    );

    register_taxonomy(
        'research-team',
        'inforepo_resource',
        array(
            'labels' => array(
                'name' => 'Research Team',
                'singular_name' => 'Research Team',
                'menu_name' => 'Research Team',
                'all_items' => 'All Research Teams',
                'edit_item' => 'Edit Research Team',
                'view_item' => 'View Research Team',
                'update_item' => 'Update Research Team',
                'add_new_item' => 'Add New Research Team',
                'new_item_name' => 'New Research Team',
                'search_items' => 'Search in Research Teams',
                'not_found' => 'No Research Team found',
                'no_terms' => 'No Research Team',
                'items_list_navigation' => 'Research Team navigation',
                'items_list' => 'Research Team list',
                'back_to_items' => '← Go to Research Team',
                'item_link' => 'Research Team Link',
                'item_link_description' => 'A link to Research Team',
            ),
            'public' => true,
            'hierarchical' => true,
            'show_in_menu' => true,
            'show_ui'      => true,
            'meta_box_cb'  => false,
            'show_in_rest' => true,
            'query_var' => true,
            'rewrite' => array('slug' => 'eb-research')
        )
    );

    register_taxonomy(
        'special-content',
        'inforepo_resource',
        array(
            'labels' => array(
                'name' => 'Special Content',
                'singular_name' => 'Special Content',
                'menu_name' => 'Special Content',
                'all_items' => 'All Special Content',
                'edit_item' => 'Edit Special Content',
                'view_item' => 'View Special Content',
                'update_item' => 'Update Special Content',
                'add_new_item' => 'Add New Special Content',
                'new_item_name' => 'New Special Content',
                'search_items' => 'Search in Special Content',
                'not_found' => 'No Special Content found',
                'no_terms' => 'No Special Content',
                'items_list_navigation' => 'Special Content navigation',
                'items_list' => 'Special Content list',
                'back_to_items' => '← Go to Special Content',
                'item_link' => 'Special Content Link',
                'item_link_description' => 'A link to Special Content',
            ),
            'public' => true,
            'hierarchical' => true,
            'show_in_menu' => true,
            'show_ui'      => true,
            'meta_box_cb'  => false,
            'show_in_rest' => true,
            'query_var' => true,
            'rewrite' => array('slug' => 'special-content')
        )
    );


    register_taxonomy(
        'authoring-organization',
        'inforepo_resource',
        array(
            'labels' => array(
                'name' => 'Authoring Organization',
                'singular_name' => 'Authoring Organization',
                'menu_name' => 'Authoring Organization',
                'all_items' => 'All Authoring Organizations',
                'edit_item' => 'Edit Authoring Organization',
                'view_item' => 'View Authoring Organizations',
                'update_item' => 'Update Authoring Organizations',
                'add_new_item' => 'Add New Authoring Organization',
                'new_item_name' => 'New Authoring Organization',
                'search_items' => 'Search in Authoring Organizations',
                'not_found' => 'No Authoring Organization found',
                'no_terms' => 'No Authoring Organization',
                'items_list_navigation' => 'Authoring Organization navigation',
                'items_list' => 'Authoring Organization list',
                'back_to_items' => '← Go to Authoring Organizations',
                'item_link' => 'Authoring Organization Link',
                'item_link_description' => 'A link to Authoring Organization',
            ),
            'public' => true,
            'hierarchical' => true,
            'show_in_menu' => true,
            'show_ui'      => true,
            'meta_box_cb'  => false,
            'show_in_rest' => true,
            'query_var' => true,
            'rewrite' => array('slug' => 'authoring-organization')
        )
    );
    /**
     * end register taxonomies for post type inforepo_resources
     */
}
add_action('init', 'register_resource_taxonomies');


/**
 * add terms to taxonomies
 */
function inforepo_seed_terms()
{
    $topics = [
        'Border tech',
        'Border externalization',
        'Corporate actors',
        'Datafication of borders',
        'Data sharing',
        'Industry and Funding',
        'Human impact',
        'Surveillance infrastructure',
        'Interoperability',
        'AI',
        'Biometrics',
        'Law and Policy',
        'Militarization',
        'Private actors',
        'Securitization'

    ];
    foreach ($topics as $t) {
        if (!term_exists($t, 'topic')) {
            wp_insert_term($t, 'topic');
        }
    }

    $formats = [
        'Academic Research',
        'Audio File',
        'Book',
        'Case Study',
        'Dataset/Database',
        'Exhibition',
        'Fact Sheet',
        'Government Documents',
        'Graphic',
        'Legislation',
        'Report',
        'News',
        'Website',
        'Interview',
        'Visualizations'
    ];
    foreach ($formats as $f) {
        if (!term_exists($f, 'format')) {
            wp_insert_term($f, 'format');
        }
    }


    $countries = [
        'Afghanistan',
        'Aland Islands',
        'Albania',
        'Algeria',
        'American Samoa',
        'Andorra',
        'Angola',
        'Anguilla',
        'Antarctica',
        'Antigua and Barbuda',
        'Argentina',
        'Armenia',
        'Aruba',
        'Australia',
        'Austria',
        'Azerbaijan',
        'Bahrain',
        'Bangladesh',
        'Barbados',
        'Belarus',
        'Belgium',
        'Belize',
        'Benin',
        'Bermuda',
        'Bhutan',
        'Bolivia',
        'Bonaire, Sint Eustatius and Saba',
        'Bosnia and Herzegovina',
        'Botswana',
        'Bouvet Island',
        'Brazil',
        'British Indian Ocean Territory',
        'Brunei',
        'Bulgaria',
        'Burkina Faso',
        'Burundi',
        'Cambodia',
        'Cameroon',
        'Canada',
        'Cape Verde',
        'Cayman Islands',
        'Central African Republic',
        'Chad',
        'Chile',
        'China',
        'Christmas Island',
        'Cocos (Keeling) Islands',
        'Colombia',
        'Comoros',
        'Congo',
        'Cook Islands',
        'Costa Rica',
        'Cote D\'Ivoire (Ivory Coast)',
        'Croatia',
        'Cuba',
        'Curaçao',
        'Cyprus',
        'Czech Republic',
        'Democratic Republic of the Congo',
        'Denmark',
        'Djibouti',
        'Dominica',
        'Dominican Republic',
        'Ecuador',
        'Egypt',
        'El Salvador',
        'Equatorial Guinea',
        'Eritrea',
        'Estonia',
        'Eswatini',
        'Ethiopia',
        'Falkland Islands',
        'Faroe Islands',
        'Fiji Islands',
        'Finland',
        'France',
        'French Guiana',
        'French Polynesia',
        'French Southern Territories',
        'Gabon',
        'Georgia',
        'Germany',
        'Ghana',
        'Gibraltar',
        'Greece',
        'Greenland',
        'Grenada',
        'Guadeloupe',
        'Guam',
        'Guatemala',
        'Guernsey and Alderney',
        'Guinea',
        'Guinea-Bissau',
        'Guyana',
        'Haiti',
        'Heard Island and McDonald Islands',
        'Honduras',
        'Hong Kong S.A.R.',
        'Hungary',
        'Iceland',
        'India',
        'Indonesia',
        'Iran',
        'Iraq',
        'Ireland',
        'Israel',
        'Italy',
        'Jamaica',
        'Japan',
        'Jersey',
        'Jordan',
        'Kazakhstan',
        'Kenya',
        'Kiribati',
        'Kosovo',
        'Kuwait',
        'Kyrgyzstan',
        'Laos',
        'Latvia',
        'Lebanon',
        'Lesotho',
        'Liberia',
        'Libya',
        'Liechtenstein',
        'Lithuania',
        'Luxembourg',
        'Macau S.A.R.',
        'Madagascar',
        'Malawi',
        'Malaysia',
        'Maldives',
        'Mali',
        'Malta',
        'Man (Isle of)',
        'Marshall Islands',
        'Martinique',
        'Mauritania',
        'Mauritius',
        'Mayotte',
        'Mexico',
        'Micronesia',
        'Moldova',
        'Monaco',
        'Mongolia',
        'Montenegro',
        'Montserrat',
        'Morocco',
        'Mozambique',
        'Myanmar',
        'Namibia',
        'Nauru',
        'Nepal',
        'Netherlands',
        'New Caledonia',
        'New Zealand',
        'Nicaragua',
        'Niger',
        'Nigeria',
        'Niue',
        'Norfolk Island',
        'North Korea',
        'North Macedonia',
        'Northern Mariana Islands',
        'Norway',
        'Oman',
        'Pakistan',
        'Palau',
        'Palestinian Territory Occupied',
        'Panama',
        'Papua New Guinea',
        'Paraguay',
        'Peru',
        'Philippines',
        'Pitcairn Island',
        'Poland',
        'Portugal',
        'Puerto Rico',
        'Qatar',
        'Reunion',
        'Romania',
        'Russia',
        'Rwanda',
        'Saint Helena',
        'Saint Kitts and Nevis',
        'Saint Lucia',
        'Saint Pierre and Miquelon',
        'Saint Vincent and the Grenadines',
        'Saint-Barthelemy',
        'Saint-Martin (French part)',
        'Samoa',
        'San Marino',
        'Sao Tome and Principe',
        'Saudi Arabia',
        'Senegal',
        'Serbia',
        'Seychelles',
        'Sierra Leone',
        'Singapore',
        'Sint Maarten (Dutch part)',
        'Slovakia',
        'Slovenia',
        'Solomon Islands',
        'Somalia',
        'South Africa',
        'South Georgia',
        'South Korea',
        'South Sudan',
        'Spain',
        'Sri Lanka',
        'Sudan',
        'Suriname',
        'Svalbard and Jan Mayen Islands',
        'Sweden',
        'Switzerland',
        'Syria',
        'Taiwan',
        'Tajikistan',
        'Tanzania',
        'Thailand',
        'The Bahamas',
        'The Gambia ',
        'Timor-Leste',
        'Togo',
        'Tokelau',
        'Tonga',
        'Trinidad and Tobago',
        'Tunisia',
        'Turkey',
        'Turkmenistan',
        'Turks and Caicos Islands',
        'Tuvalu',
        'Uganda',
        'Ukraine',
        'United Arab Emirates',
        'United Kingdom',
        'United States',
        'United States Minor Outlying Islands',
        'Uruguay',
        'Uzbekistan',
        'Vanuatu',
        'Vatican City State (Holy See)',
        'Venezuela',
        'Vietnam',
        'Virgin Islands (British)',
        'Virgin Islands (US)',
        'Wallis and Futuna Islands',
        'Western Sahara',
        'Yemen',
        'Zambia',
        'Zimbabwe'
    ];
    foreach ($countries as $c) {
        if (!term_exists($c, 'country')) {
            wp_insert_term($c, 'country');
        }
    }

    $languages = [
        'English',
        'Spanish',
        'Portuguese',
        'Haitian Creole'
    ];
    foreach ($languages as $l) {
        if (!term_exists($l, 'language')) {
            wp_insert_term($l, 'language');
        }
    }

    $visibility = [
        'Private',
        'Public'
    ];
    foreach ($visibility as $v) {
        if (!term_exists($v, 'visibility')) {
            wp_insert_term($v, 'visibility');
        }
    }

    $sources = [
        'Public Records Requests',
        'Academic',
        'Community Members',
        'Community-based Organization',
        'Executive Branch',
        'Government Agency',
        'Legislative Branch',
        'Non-profit/NGO',
        'Private Sector'
    ];
    foreach ($sources as $s) {
        if (!term_exists($s, 'source')) {
            wp_insert_term($s, 'source');
        }
    }

    $research_teams = [
        'EB Research'
    ];
    if (!term_exists('EB Research', 'research-team')) {
        wp_insert_term('EB Research', 'research-team');
    }

    $special_content_types = [
        'featured'
    ];
    if (!term_exists('featured', 'special-content')) {
        wp_insert_term('featured', 'special-content');
    }
}
/**
 * 
 * @author marieleponti
 * @package inforepo
 * This function is commented out because terms are already adding. 
 * Uncomment if you want full control over taxonomies and terms from the code base
 * Leaving uncommented, as admin should be able to delete, edit, and add terms
 * via the admin UI. If inforepo_add_terms_to_resource_taxonomies is called
 * at every init, it will override those deletions and edits. 
 * 
 */
// add_action('init', 'inforepo_add_terms_to_resource_taxonomies');

// function inforepo_update_countries()
// {
//     $countries = [
//         'Afghanistan',
//         'Aland Islands',
//         'Albania',
//         'Algeria',
//         'American Samoa',
//         'Andorra',
//         'Angola',
//         'Anguilla',
//         'Antarctica',
//         'Antigua and Barbuda',
//         'Argentina',
//         'Armenia',
//         'Aruba',
//         'Australia',
//         'Austria',
//         'Azerbaijan',
//         'Bahrain',
//         'Bangladesh',
//         'Barbados',
//         'Belarus',
//         'Belgium',
//         'Belize',
//         'Benin',
//         'Bermuda',
//         'Bhutan',
//         'Bolivia',
//         'Bonaire, Sint Eustatius and Saba',
//         'Bosnia and Herzegovina',
//         'Botswana',
//         'Bouvet Island',
//         'Brazil',
//         'British Indian Ocean Territory',
//         'Brunei',
//         'Bulgaria',
//         'Burkina Faso',
//         'Burundi',
//         'Cambodia',
//         'Cameroon',
//         'Canada',
//         'Cape Verde',
//         'Cayman Islands',
//         'Central African Republic',
//         'Chad',
//         'Chile',
//         'China',
//         'Christmas Island',
//         'Cocos (Keeling) Islands',
//         'Colombia',
//         'Comoros',
//         'Congo',
//         'Cook Islands',
//         'Costa Rica',
//         'Cote D\'Ivoire (Ivory Coast)',
//         'Croatia',
//         'Cuba',
//         'Curaçao',
//         'Cyprus',
//         'Czech Republic',
//         'Democratic Republic of the Congo',
//         'Denmark',
//         'Djibouti',
//         'Dominica',
//         'Dominican Republic',
//         'Ecuador',
//         'Egypt',
//         'El Salvador',
//         'Equatorial Guinea',
//         'Eritrea',
//         'Estonia',
//         'Eswatini',
//         'Ethiopia',
//         'Falkland Islands',
//         'Faroe Islands',
//         'Fiji Islands',
//         'Finland',
//         'France',
//         'French Guiana',
//         'French Polynesia',
//         'French Southern Territories',
//         'Gabon',
//         'Georgia',
//         'Germany',
//         'Ghana',
//         'Gibraltar',
//         'Greece',
//         'Greenland',
//         'Grenada',
//         'Guadeloupe',
//         'Guam',
//         'Guatemala',
//         'Guernsey and Alderney',
//         'Guinea',
//         'Guinea-Bissau',
//         'Guyana',
//         'Haiti',
//         'Heard Island and McDonald Islands',
//         'Honduras',
//         'Hong Kong S.A.R.',
//         'Hungary',
//         'Iceland',
//         'India',
//         'Indonesia',
//         'Iran',
//         'Iraq',
//         'Ireland',
//         'Israel',
//         'Italy',
//         'Jamaica',
//         'Japan',
//         'Jersey',
//         'Jordan',
//         'Kazakhstan',
//         'Kenya',
//         'Kiribati',
//         'Kosovo',
//         'Kuwait',
//         'Kyrgyzstan',
//         'Laos',
//         'Latvia',
//         'Lebanon',
//         'Lesotho',
//         'Liberia',
//         'Libya',
//         'Liechtenstein',
//         'Lithuania',
//         'Luxembourg',
//         'Macau S.A.R.',
//         'Madagascar',
//         'Malawi',
//         'Malaysia',
//         'Maldives',
//         'Mali',
//         'Malta',
//         'Man (Isle of)',
//         'Marshall Islands',
//         'Martinique',
//         'Mauritania',
//         'Mauritius',
//         'Mayotte',
//         'Mexico',
//         'Micronesia',
//         'Moldova',
//         'Monaco',
//         'Mongolia',
//         'Montenegro',
//         'Montserrat',
//         'Morocco',
//         'Mozambique',
//         'Myanmar',
//         'Namibia',
//         'Nauru',
//         'Nepal',
//         'Netherlands',
//         'New Caledonia',
//         'New Zealand',
//         'Nicaragua',
//         'Niger',
//         'Nigeria',
//         'Niue',
//         'Norfolk Island',
//         'North Korea',
//         'North Macedonia',
//         'Northern Mariana Islands',
//         'Norway',
//         'Oman',
//         'Pakistan',
//         'Palau',
//         'Palestinian Territory Occupied',
//         'Panama',
//         'Papua New Guinea',
//         'Paraguay',
//         'Peru',
//         'Philippines',
//         'Pitcairn Island',
//         'Poland',
//         'Portugal',
//         'Puerto Rico',
//         'Qatar',
//         'Reunion',
//         'Romania',
//         'Russia',
//         'Rwanda',
//         'Saint Helena',
//         'Saint Kitts and Nevis',
//         'Saint Lucia',
//         'Saint Pierre and Miquelon',
//         'Saint Vincent and the Grenadines',
//         'Saint-Barthelemy',
//         'Saint-Martin (French part)',
//         'Samoa',
//         'San Marino',
//         'Sao Tome and Principe',
//         'Saudi Arabia',
//         'Senegal',
//         'Serbia',
//         'Seychelles',
//         'Sierra Leone',
//         'Singapore',
//         'Sint Maarten (Dutch part)',
//         'Slovakia',
//         'Slovenia',
//         'Solomon Islands',
//         'Somalia',
//         'South Africa',
//         'South Georgia',
//         'South Korea',
//         'South Sudan',
//         'Spain',
//         'Sri Lanka',
//         'Sudan',
//         'Suriname',
//         'Svalbard and Jan Mayen Islands',
//         'Sweden',
//         'Switzerland',
//         'Syria',
//         'Taiwan',
//         'Tajikistan',
//         'Tanzania',
//         'Thailand',
//         'The Bahamas',
//         'The Gambia ',
//         'Timor-Leste',
//         'Togo',
//         'Tokelau',
//         'Tonga',
//         'Trinidad and Tobago',
//         'Tunisia',
//         'Turkey',
//         'Turkmenistan',
//         'Turks and Caicos Islands',
//         'Tuvalu',
//         'Uganda',
//         'Ukraine',
//         'United Arab Emirates',
//         'United Kingdom',
//         'United States',
//         'United States Minor Outlying Islands',
//         'Uruguay',
//         'Uzbekistan',
//         'Vanuatu',
//         'Vatican City State (Holy See)',
//         'Venezuela',
//         'Vietnam',
//         'Virgin Islands (British)',
//         'Virgin Islands (US)',
//         'Wallis and Futuna Islands',
//         'Western Sahara',
//         'Yemen',
//         'Zambia',
//         'Zimbabwe'
//     ];
//     foreach ($countries as $country) {
//         if (!term_exists($country, 'country')) {
//             wp_insert_term($country, 'country');
//         }
//     }
// }

register_activation_hook(__FILE__, function () {
    inforepo_resource_post_type();
    register_resource_taxonomies();
    inforepo_seed_terms(); 
    // inforepo_update_countries();
    flush_rewrite_rules();
});


/**
 * Function to delete unwanted or outdated taxonomy 
 * terms
 *
 * 
 * @return void
 */
// function inforepo_delete_all_terms(){
//     $taxonomy_name_array = ['<taxonomy_name_1','<taxonomy_name_2>'];
//     foreach($taxonomy_name_array as $taxonomy_name){
//         $terms = get_terms( array(
//             'taxonomy' => $taxonomy_name,
//             'hide_empty' => false
//         ) );
//         foreach ( $terms as $term ) {
//                    wp_delete_term($term->term_id, $taxonomy_name); 
//             }         
//     }
// }
// add_action('init', 'inforepo_delete_all_terms');


/**
 * Function to delete unwanted or outdated taxonomy 
 * 
 *
 * 
 * @return void
 */
// function inforepo_unregister_tags_for_inforepo_resource()
// {

//     unregister_taxonomy_for_object_type('country', 'inforepo_resource');
// }
// add_action('init', 'inforepo_unregister_tags_for_inforepo_resource');
