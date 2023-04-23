<?php

require_once get_theme_file_path('/inc/search-route.php');

function university_files()
{
    // STYLES

    //wp_enqueue_style('university_main_styles', get_stylesheet_uri());
    wp_enqueue_style('google-font', '//fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,400i,700,700i|Roboto:100,300,400,400i,700,700i');
    wp_enqueue_style('font-awesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css');
    wp_enqueue_style('university-main-styles', get_theme_file_uri('/build/style-index.css'));
    wp_enqueue_style('university-extra-styles', get_theme_file_uri('/build/index.css'));

    // JAVASCRIPT

    wp_enqueue_script('university-main-code', get_theme_file_uri('/build/index.js'), ['jquery'], '1.0', true);
    wp_localize_script('university-main-code', 'universityData', [
        'root_url'  => get_site_url()
    ]);
}
// Add css and js files into the theme
add_action('wp_enqueue_scripts', 'university_files');

function university_features()
{
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');

    register_nav_menu('headerMenuLocation', 'Header menu location');
    register_nav_menu('footerLocationOne', 'Footer location one');
    register_nav_menu('footerLocationTwo', 'Footer location two');

    add_image_size('professorLandscape', 400, 260, true);
    add_image_size('professorPortrait', 480, 650, true);
    add_image_size('pageBanner', 1500, 350, true);
}

// Add features to the theme, such as menus, custom image sizes, title-tag
add_action('after_setup_theme', 'university_features');

function custom_excerpt_length($length): int
{
    return 18;
}

// Custom excerpt length
add_filter('excerpt_length', 'custom_excerpt_length', 999);

function custom_excerpt_end($more): string
{
    return '...';
}

// Custom excerpt end string
add_filter('excerpt_more', 'custom_excerpt_end');

function university_adjust_querys($query)
{
    if (!is_admin() && is_post_type_archive('event') && $query->is_main_query()) {
        $query->set('meta_key', 'event_date');
        $query->set('orderby', 'meta_value_num');
        $query->set('order', 'ASC');
        /*
         Return only events where the event_date is greater than or equal to today's date
         $query->set('meta_query', [
            [
                'key'       => 'event_date',
                'compare'   => '>=',
                'value'     => date('Ymd'),
                'type'      => 'numeric'
            ]
        ]);*/
    }
    if (!is_admin() && is_post_type_archive('program') && $query->is_main_query()) {
        $query->set('orderby', 'title');
        $query->set('order', 'ASC');
        $query->set('posts_per_page', -1);
    }

    if (!is_admin() && is_post_type_archive('campus') && $query->is_main_query()) {
        $query->set('posts_per_page', -1);
    }
}

// Modify native main query of the theme
add_action('pre_get_posts', 'university_adjust_querys');

function university_custom_rest()
{

    // Add extra field to REST API
    register_rest_field('post', 'authorName', [
        'get_callback'  =>  function () {
            return get_the_author();
        }
    ]);
}

// Customizing REST API
add_action('rest_api_init', 'university_custom_rest');


// Create Custom Post Types
function university_post_types()
{
    // Event post type
    register_post_type('event', [
        'supports'      => [
            'title',
            'editor',
            'excerpt'
        ],
        'rewrite'       => [
            'slug'  => 'events'
        ],
        'has_archive'   => true,
        'public'        => true,
        'show_in_rest'  => true,
        'labels'    => [
            'name'          => 'Events',
            'add_new'       => 'Add New Event',
            'edit_item'     => 'Edit Event',
            'all_items'     => 'All Events',
            'singular_name' => 'Event'
        ],
        'menu_icon'     => 'dashicons-calendar'
    ]);

    // Campus post type
    register_post_type('campus', [
        'supports'      => [
            'title',
            'editor',
            'excerpt'
        ],
        'rewrite'       => [
            'slug'  => 'campuses'
        ],
        'has_archive'   => true,
        'public'        => true,
        'show_in_rest'  => true,
        'labels'    => [
            'name'          => 'Campuses',
            'add_new'       => 'Add New Campus',
            'edit_item'     => 'Edit Campus',
            'all_items'     => 'All Campuses',
            'singular_name' => 'Campus'
        ],
        'menu_icon'     => 'dashicons-location-alt'
    ]);

    // Program post type
    register_post_type('program', [
        'supports'      => [
            'title',
            'editor'
        ],
        'rewrite'       => [
            'slug'  => 'programs'
        ],
        'has_archive'   => true,
        'public'        => true,
        'show_in_rest'  => true,
        'labels'    => [
            'name'          => 'Programs',
            'add_new'       => 'Add New Program',
            'edit_item'     => 'Edit Program',
            'all_items'     => 'All Programs',
            'singular_name' => 'Program'
        ],
        'menu_icon'     => 'dashicons-awards'
    ]);

    // Professor post type
    register_post_type('professor', [
        'supports'      => [
            'title',
            'editor',
            'thumbnail'
        ],
        'has_archive'   => false,
        'public'        => true,
        'show_in_rest'  => true,
        'labels'    => [
            'name'          => 'Professors',
            'add_new'       => 'Add New Professor',
            'edit_item'     => 'Edit Professor',
            'all_items'     => 'All Professors',
            'singular_name' => 'Professor'
        ],
        'menu_icon'     => 'dashicons-welcome-learn-more'
    ]);
}

add_action('init', 'university_post_types');
