<?php
if ( class_exists( 'ACF' ) ) {
    add_action('acf/init', 'my_acf_blocks_init');
    function my_acf_blocks_init() {
        // Check function exists.
        if( function_exists('acf_register_block_type') ) {
            acf_register_block_type(array(
                'name'              => 'about',
                'title'             => __('About'),
                'description'       => __('A custom about block.'),
                'render_template'   => 'template-parts/blocks/about/about.php',
                'enqueue_style'     => get_template_directory_uri() . '/assets/build/css/about.min.css',
                'enqueue_script'    => get_template_directory_uri() . '/template-parts/blocks/about/index.js',
//                'enqueue_script'    => get_template_directory_uri() . '/assets/build/js/main.bundle.js',
                'category'          => 'media',
                'keywords'          => array('About', 'Hero'),
                'enqueue_assets'  => function() {
//                    wp_enqueue_style( 'flickity', plugin_dir_url( __FILE__ ) . 'template-parts/blocks/flickity/flickity.min.css' );
//                    wp_enqueue_style( 'block-flickity', plugin_dir_url( __FILE__ ) . 'template-parts/blocks/flickity/block-flickity.css' );
//
//                    wp_enqueue_script( 'flickity', plugin_dir_url( __FILE__ ) . 'template-parts/blocks/flickity/flickity.pkgd.min.js', '', '2.2.1', true );
//                    wp_enqueue_script( 'flickity-init', plugin_dir_url( __FILE__ ) . 'template-parts/blocks/flickity/block-flickity.js', array( 'flickity' ), '1.0.0', true );
                },
            ));

            acf_register_block_type(array(
                'name'              => 'resume',
                'title'             => __('Resume'),
                'description'       => __('A custom resume block.'),
                'render_template'   => 'template-parts/blocks/resume/resume.php',
                'enqueue_style'     => get_template_directory_uri() . '/assets/build/css/resume.min.css',
                'enqueue_script'    => get_template_directory_uri() . '/template-parts/blocks/resume/index.js',
                'category'          => 'formatting',
            ));

            acf_register_block_type(array(
                'name'              => 'service',
                'title'             => __('Service'),
                'description'       => __('A custom service block.'),
                'render_template'   => 'template-parts/blocks/service/service.php',
                'enqueue_style'     => get_template_directory_uri() . '/assets/build/css/service.min.css',
                'category'          => 'formatting',
            ));

            acf_register_block_type(array(
                'name'              => 'project',
                'title'             => __('Project'),
                'description'       => __('A custom project block.'),
                'render_template'   => 'template-parts/blocks/project/project.php',
                'enqueue_style'     => get_template_directory_uri() . '/assets/build/css/project.min.css',
                'enqueue_script'    => get_template_directory_uri() . '/template-parts/blocks/project/index.js',
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
            'redirect'      => false
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

    function save_options($post_id) {
        if($post_id === 'options') {
            global $wpdb;
            $query_string = "SELECT * FROM {$wpdb->prefix}options  WHERE option_name LIKE '%options_%'";
            $options = $wpdb->get_results($wpdb->prepare($query_string));
            if(!empty($options)) {
                foreach ($options as $k => $v) {
                    $value = json_decode(json_encode($v), true);
                    unset($value['option_id']);
                    unset($value['autoload']);
                    $options[$k] = $value;
                }
                file_put_contents(get_template_directory() . '/inc/demos/classic/options.txt', json_encode($options));
            }
        }
    }
    add_action('acf/save_post', 'save_options', 20);

}
