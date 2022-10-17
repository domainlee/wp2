<?php
if ( ! defined( 'CRThemes_version' ) ) {
    define( 'CRThemes_version', '1.0.0.0' );
}

// ADMIN
require_once get_parent_theme_file_path( '/inc/admin/admin.php' );
//
//require_once get_parent_theme_file_path( '/inc/admin/import.php' ); // import demo data
//
//require_once get_parent_theme_file_path( '/inc/support.php' ); // array of things we support to validate

// since 2.8
require_once get_parent_theme_file_path( '/inc/header.php' );

require_once get_parent_theme_file_path( '/inc/fonts.php' );
require_once get_parent_theme_file_path( '/inc/google-fonts.php' );



/**
 * Register and Enqueue Styles.
 *
 * @since crthemes 1.0
 */
function register_styles() {
    wp_register_style('main', get_template_directory_uri() . '/assets/build/css/main.min.css', array(), '1.1', 'all');
    wp_enqueue_style('main'); // Enqueue it!
}

add_action( 'wp_enqueue_scripts', 'register_styles' );

/**
 * Register and Enqueue Scripts.
 *
 * @since crthemes 1.0
 */
function register_scripts() {
    wp_register_script('crthemes-js', get_template_directory_uri() . '/assets/build/js/main.bundle.js', array('jquery'), '1.0.1', true); // Custom scripts
    wp_enqueue_script('crthemes-js'); // Enqueue it!
}

add_action( 'wp_enqueue_scripts', 'register_scripts' );


/* One click import demo
 * @since 3.0
  */
if ( ! defined( 'PT_OCDI_PATH' ) ) {
    define( 'PT_OCDI_PATH', get_template_directory() . '/inc/demo-import/' );
    define( 'PT_OCDI_URL', get_template_directory_uri() . '/inc/demo-import/' );
}
add_filter( 'pt-ocdi/disable_pt_branding', '__return_true' );

require_once get_parent_theme_file_path( '/inc/demo-import/one-click-demo-import.php' );


if ( class_exists( 'ACF' ) ) {
    add_action('acf/init', 'my_acf_blocks_init');
    function my_acf_blocks_init() {

        // Check function exists.
        if( function_exists('acf_register_block_type') ) {

            // Register a testimonial block.
            acf_register_block_type(array(
                'name'              => 'testimonial',
                'title'             => __('Testimonial'),
                'description'       => __('A custom testimonial block.'),
                'render_template'   => 'template-parts/blocks/testimonial/testimonial.php',
                'enqueue_style'     => get_template_directory_uri() . '/template-parts/blocks/testimonial/testimonial.css',
                'category'          => 'formatting',
            ));
        }
    }

    add_filter('acf/settings/save_json', 'my_acf_json_save_point');
    function my_acf_json_save_point( $path ) {
        $path = get_stylesheet_directory() . '/ACFJson';
        return $path;
    }

    if( function_exists('acf_add_options_page') ) {

        acf_add_options_page(array(
            'page_title'    => 'Theme General Settings',
            'menu_title'    => 'Theme Settings',
            'menu_slug'     => 'theme-general-settings',
            'capability'	=> 'administrator',
//            'redirect'      => false
        ));

        acf_add_options_sub_page(array(
            'page_title'    => 'Theme Header Settings',
            'menu_title'    => 'Header',
            'parent_slug'   => 'theme-general-settings',
        ));

        acf_add_options_sub_page(array(
            'page_title'    => 'Theme Footer Settings',
            'menu_title'    => 'Footer',
            'parent_slug'   => 'theme-general-settings',
        ));

    }


}


/* -------------------------------------------------------------------- */
/* SETUP
/* -------------------------------------------------------------------- */
if ( ! function_exists( 'crthemes_setup' ) ) :
    function crthemes_setup() {

        // translation
        load_theme_textdomain( 'wi', get_template_directory() . '/languages' );

        // Add default posts and comments RSS feed links to head.
        add_theme_support( 'automatic-feed-links' );

        // title tag
        add_theme_support( 'title-tag' );

        // post thumbnail
        add_theme_support( 'post-thumbnails' );
        add_image_size( 'thumbnail-big', 1020, 510, true );  // big thumbnail (ratio 2:1)
        add_image_size( 'thumbnail-medium', 480, 384, true );  // medium thumbnail
        add_image_size( 'thumbnail-medium-nocrop', 480, 9999, false );  // medium thumbnail no crop
        add_image_size( 'thumbnail-vertical', 9999, 500, false );  // vertical image used for gallery

        // This theme uses wp_nav_menu() in two locations.
        register_nav_menus( array(
            'primary' => __( 'Primary Menu', 'wi' ),
            'footer' => __( 'Footer Menu', 'wi' ),
        ) );

        // html5
        add_theme_support( 'html5', array(
            'search-form', 'comment-form', 'comment-list', 'gallery', 'caption',
        ) );

        // post formats
        add_theme_support( 'post-formats', array(
            'video', 'gallery', 'audio', 'link',
        ) );

        // since 2.4
        add_theme_support( 'woocommerce' );

    }
endif; //
add_action( 'after_setup_theme', 'crthemes_setup' );