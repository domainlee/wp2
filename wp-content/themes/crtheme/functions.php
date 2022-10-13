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

require get_parent_theme_file_path( '/inc/customizer/customizer.php' );
require get_parent_theme_file_path ( '/inc/customizer/register.php' );
require_once get_parent_theme_file_path( '/inc/fonts.php' );
require_once get_parent_theme_file_path( '/inc/google-fonts.php' );
require_once get_parent_theme_file_path( '/inc/customizer/fonts.php' );

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

}