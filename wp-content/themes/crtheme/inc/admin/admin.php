<?php
/* Admin Area
-------------------------------------------------------------------------------------- */
/**
 * Admin Class
 *
 * @since Fox 2.2
 */
if ( !class_exists( 'Wi_Admin' ) ) :

class Wi_Admin
{   
    
    /**
	 *
	 */
	public function __construct() {
	}
    
    /**
	 * The one instance of Wi_Admin
	 *
	 * @since Fox 2.2
	 */
	private static $instance;

	/**
	 * Instantiate or return the one Wi_Admin instance
	 *
	 * @since Fox 2.2
	 *
	 * @return Wi_Admin
	 */
	public static function instance() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}

		return self::$instance;
	}
    
    /**
     * Initiate the class
     * contains action & filters
     *
     * @since Fox 2.2
     */
    public function init() {
        
        // metabox
//        require_once get_template_directory() . '/inc/admin/framework/metabox/metabox.php';
        
        // TGM
        require_once get_template_directory() . '/inc/admin/framework/tgm.php';
        
        // register plugins needed for theme
        add_action( 'tgmpa_register', array ( $this, 'register_required_plugins' ) );
        
        // Include media upload to sidebar area
        // This will be used when we need to upload something
        add_action( 'sidebar_admin_setup', array( $this, 'wp_enqueue_media' ) );
        
        require_once get_template_directory() . '/inc/admin/framework/nav/nav-custom-fields.php'; // fields
        add_action( 'wp_loaded', array( $this, 'include_menu_walker' ) );
        
        // enqueue scripts
        add_action( 'admin_enqueue_scripts', array( $this, 'enqueue' ) );
        
        // localization
        add_action( 'wiadminjs', array( $this, 'l10n' ) );
        
        // metabox
        add_action( 'wi_metaboxes', array( $this, 'metaboxes' ) );
        
        /**
         * Add a thumbnail column in edit.php
         *
         * Thank to: http://wordpress.org/support/topic/adding-custum-post-type-thumbnail-to-the-edit-screen
         *
         * @since 1.0
         */
        add_action( 'manage_posts_custom_column', array( $this, 'add_thumbnail_value_editscreen' ), 10, 2 );
        add_filter( 'manage_edit-post_columns', array( $this, 'columns_filter' ) , 10, 1 );
        
        /**
         * Term Options
         */
        add_action( 'category_add_form_fields', array( $this, 'taxonomy_add_new_meta_field' ), 10, 2 );
        add_action( 'post_tag_add_form_fields', array( $this, 'taxonomy_add_new_meta_field' ), 10, 2 );
        
        add_action( 'category_edit_form_fields', array( $this, 'taxonomy_edit_meta_field' ), 10, 2 );
        add_action( 'post_tag_edit_form_fields', array( $this, 'taxonomy_edit_meta_field' ), 10, 2 );
        
        add_action( 'edited_category', array( $this, 'save_taxonomy_custom_meta' ), 10, 2 );  
        add_action( 'create_category', array( $this, 'save_taxonomy_custom_meta' ), 10, 2 );  
        add_action( 'edited_post_tag', array( $this, 'save_taxonomy_custom_meta' ), 10, 2 );  
        add_action( 'create_post_tag', array( $this, 'save_taxonomy_custom_meta' ), 10, 2 );
        
        /**
         * Demo Import
         *
         * @since 3.0
         */
        add_filter( 'pt-ocdi/import_files', array( $this, 'import_files' ) );
        add_action( 'pt-ocdi/after_import', array( $this, 'after_import_setup' ) );
        
    }
    
    /**
     * Setup after importing process
     *
     * @since 2.0
     */
    function after_import_setup( $selected_import ) {
        
        $demos = array(
            'Fox Classic' => array(
                'slug' => 'classic',
                'primary' => 'Primary',
                'footer' => 'Footer',
            ),
            'Fox Times' => array(
                'slug' => 'times',
                'primary' => 'Primary',
                'footer' => 'Footer',
            ),
        );
        
        $nav_menu_locations = [];
        
        foreach ( $demos as $name => $data ) {
         
            if ( $name === $selected_import['import_file_name'] ) {
                
                // Assign menus to their locations.
                if ( isset( $data[ 'primary' ] ) ) {
                    $nav = get_term_by( 'name', $data[ 'primary' ], 'nav_menu' );
                    if ( $nav ) {
                        $nav_menu_locations[ 'primary' ] = $nav->term_id;
                    }
                }
                
                // Assign menus to their locations.
                if ( isset( $data[ 'footer' ] ) ) {
                    $nav = get_term_by( 'name', $data[ 'footer' ], 'nav_menu' );
                    if ( $nav ) {
                        $nav_menu_locations[ 'footer' ] = $nav->term_id;
                    }
                }
                
                if ( ! empty( $nav_menu_locations ) ) {
                    set_theme_mod( 'nav_menu_locations', $nav_menu_locations );
                }

                // Assign front page and posts page (blog page).
                $front_page_id = get_page_by_title( 'Home Page' );
//                $blog_page_id  = get_page_by_title( 'Blog' );

                update_option( 'show_on_front', 'page' );
                update_option( 'page_on_front', $front_page_id->ID );
//                update_option( 'page_for_posts', $blog_page_id->ID );
                update_option( 'themes_selected', $data['slug'] );

            }
            
        } // foreach

        // update options
        $options = json_decode(file_get_contents(get_template_directory() . '/inc/demos/classic/options.txt'));
        if(!empty($options)) {
            foreach ($options as $v) {
                $v = (array)$v;
                update_option( trim($v['option_name']), maybe_unserialize($v['option_value']), 'yes' );
            }
        }
        
    }
    
    /**
     * Registers import files
     *
     * @since 3.0
     */
    function import_files( $files ) {
        
        define( 'DEMO_PATH', get_template_directory() . '/inc/demos/' );
        define( 'DEMO_URL', get_template_directory_uri() . '/inc/demos/' );
        
        $files = array();
        
        $files[] = array(
            'import_file_name'              => 'Fox Classic',
            'local_import_file'             => DEMO_PATH . "classic/content2.xml",
            'local_import_widget_file'      => DEMO_PATH . "classic/widgets.wie",
            'local_import_customizer_file'  => DEMO_PATH . "classic/customizer.dat",
            'import_preview_image_url'      => DEMO_URL . "classic/preview.jpg",
        );
        
        $files[] = array(
            'import_file_name'              => 'Fox Times',
            'local_import_file'             => DEMO_PATH . "times/content.xml",
            'local_import_widget_file'      => DEMO_PATH . "times/widgets.wie",
            'local_import_customizer_file'  => DEMO_PATH . "times/customizer.dat",
            'import_preview_image_url'      => DEMO_URL . "times/preview.jpg",
        );
        
        return $files;
    
    }
    
    function save_taxonomy_custom_meta( $term_id ) {
        
        if ( isset( $_POST['term_meta'] ) ) {
            $t_id = $term_id;
            $term_meta = get_option( "taxonomy_$t_id" );
            $cat_keys = array_keys( $_POST['term_meta'] );
            foreach ( $cat_keys as $key ) {
                if ( isset ( $_POST['term_meta'][$key] ) ) {
                    $term_meta[$key] = $_POST['term_meta'][$key];
                }
            }
            // Save the option array.
            update_option( "taxonomy_$t_id", $term_meta );
        }
        
    }
    
    function taxonomy_add_new_meta_field() {
        // this will add the custom meta field to the add new term page

        $layout_arr = wi_layout_array();
        $layout_arr = array( '' => 'Default' ) + $layout_arr;
        $sidebar_state_arr = wi_sidebar_array();
        $sidebar_state_arr = array( '' => 'Default' ) + $sidebar_state_arr;

        ?>
        <tr class="form-field">
           <th scope="row" valign="top"><label for="term_meta[layout]"><?php _e( 'Select layout', 'wi' ); ?></label></th>
            <td>
                <select name="term_meta[layout]" id="term_meta[layout]">
                    <?php foreach ($layout_arr as $lay => $out): ?>
                    <option value="<?php echo esc_attr($lay);?>"><?php echo esc_html($out);?></option>
                    <?php endforeach; ?>
                </select>
                <p class="description"><?php _e( 'Select layout for displaying posts on this category','wi' ); ?></p>
            </td>
        </tr>

        <tr class="form-field">
           <th scope="row" valign="top"><label for="term_meta[sidebar_state]"><?php _e( 'Sidebar layout', 'wi' ); ?></label></th>
            <td>
                <select name="term_meta[sidebar_state]" id="term_meta[sidebar_state]">
                    <?php foreach ($sidebar_state_arr as $side => $bar ): ?>
                    <option value="<?php echo esc_attr($side);?>"><?php echo esc_html($bar);?></option>
                    <?php endforeach; ?>
                </select>
                <p class="description"><?php _e( 'Select sidebar layout for  this category','wi' ); ?></p>
            </td>
        </tr>
    <?php
    }
    
    // Edit term page
    function taxonomy_edit_meta_field( $term ) {

        $layout_arr = wi_layout_array();
        $layout_arr = array( '' => 'Default' ) + $layout_arr;
        $sidebar_state_arr = wi_sidebar_array();
        $sidebar_state_arr = array( '' => 'Default' ) + $sidebar_state_arr;

        // put the term ID into a variable
        $t_id = $term->term_id;

        // retrieve the existing value(s) for this meta field. This returns an array
        $term_meta = get_option( "taxonomy_$t_id" );
        $current_layout = isset($term_meta['layout']) ? $term_meta['layout'] : '';
        $current_sidebar_state = isset($term_meta['sidebar_state']) ? $term_meta['sidebar_state'] : '';
    ?>
        <tr class="form-field">
           <th scope="row" valign="top"><label for="term_meta[layout]"><?php _e( 'Select layout', 'wi' ); ?></label></th>
            <td>
                <select name="term_meta[layout]" id="term_meta[layout]">
                    <?php foreach ($layout_arr as $lay => $out): ?>
                    <option value="<?php echo esc_attr($lay);?>" <?php selected( $lay, $current_layout); ?>><?php echo esc_html($out);?></option>
                    <?php endforeach; ?>
                </select>
                <p class="description"><?php _e( 'Select layout for displaying posts on this category','wi' ); ?></p>
            </td>
        </tr>

        <tr class="form-field">
           <th scope="row" valign="top"><label for="term_meta[sidebar_state]"><?php _e( 'Sidebar layout', 'wi' ); ?></label></th>
            <td>
                <select name="term_meta[sidebar_state]" id="term_meta[sidebar_state]">
                    <?php foreach ($sidebar_state_arr as $side => $bar ): ?>
                    <option value="<?php echo esc_attr($side);?>" <?php selected( $side, $current_sidebar_state); ?>><?php echo esc_html($bar);?></option>
                    <?php endforeach; ?>
                </select>
                <p class="description"><?php _e( 'Select sidebar layout for  this category','wi' ); ?></p>
            </td>
        </tr>

    <?php
    }
    
    function add_thumbnail_value_editscreen($column_name, $post_id) {

        $width = (int) 50;
        $height = (int) 50;

        if ( 'thumbnail' == $column_name ) {
            // thumbnail of WP 2.9
            $thumbnail_id = get_post_meta( $post_id, '_thumbnail_id', true );
            // image from gallery
            $attachments = get_children( array('post_parent' => $post_id, 'post_type' => 'attachment', 'post_mime_type' => 'image') );
            if ($thumbnail_id)
                $thumb = wp_get_attachment_image( $thumbnail_id, array($width, $height), true );
            elseif ($attachments) {
                foreach ( $attachments as $attachment_id => $attachment ) {
                    $thumb = wp_get_attachment_image( $attachment_id, array($width, $height), true );
                }
            }
            if ( isset($thumb) && $thumb ) {
                echo $thumb;
            } else {
                echo '<em>' . __('None','wi') . '</em>';
            }
        }
    }
    
    function columns_filter( $columns ) {
        $column_thumbnail = array( 'thumbnail' => __('Thumbnail','wi') );
        $columns = array_slice( $columns, 0, 1, true ) + $column_thumbnail + array_slice( $columns, 1, NULL, true );
        return $columns;
    }
    
    /**
     * Register Plugins
     *
     * Instagram Widget & Post Format UI is now a part of Theme package
     *
     * @since 1.0
     */
    function register_required_plugins (){
        
        $plugins = array (
            array(
                'name'               => 'Advanced Custom Fields PRO', // The plugin name.
                'slug'               => 'advanced-custom-fields-pro', // The plugin slug (typically the folder name).
                'source'             => 'https://crthemes.com/acfpro.zip', // The plugin source.
                'required'           => true, // If false, the plugin is only 'recommended' instead of required.
                'version'            => '', // E.g. 1.0.0. If set, the active plugin must be this version or higher. If the plugin version is higher than the plugin version installed, the user will be notified to update the plugin.
                'force_activation'   => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch.
                'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins.
                'external_url'       => '', // If set, overrides default API URL and points to an external URL.
                'is_callable'        => '', // If set, this callable will be be checked for availability to determine if a plugin is active.
            ),

//            array(
//                'name'     				=> 'Contact Form 7', // The plugin name
//                'slug'     				=> 'contact-form-7', // The plugin slug (typically the folder name)
//                'required' 				=> false, // If false, the plugin is only 'recommended' instead of required
//            ),
            
            /**
             * since 2.9
             */
//            array(
//                'name'     				=> 'Post Views Counter', // The plugin name
//                'slug'     				=> 'post-views-counter', // The plugin slug (typically the folder name)
//                'required' 				=> false, // If false, the plugin is only 'recommended' instead of required
//            ),
//
//            array(
//                'name'     				=> 'Mailchimp for WP', // The plugin name
//                'slug'     				=> 'mailchimp-for-wp', // The plugin slug (typically the folder name)
//                'required' 				=> false, // If false, the plugin is only 'recommended' instead of required
//            ),
            
        );

        $config = array(
            'id'           => 'tgmpa',
            'default_path' => '',
            'menu'         => 'tgma-install-plugins',
            'parent_slug'  => 'themes.php',
            'capability'   => 'edit_theme_options',
            'has_notices'  => true,
            'dismissable'  => true,
            'dismiss_msg'  => '',
            'is_automatic' => true,
            'message'      => '',
        );

        tgmpa( $plugins, $config );
    }
    
    function vp_pfui_base_url( $url ) {
        return get_template_directory_uri() . '/inc/admin/framework/formatui/';
    }
    
    function wp_enqueue_media() {
        wp_enqueue_media();
    }
    
    /**
     * Includes menu walker
     *
     * @since 2.8
     */
    function include_menu_walker() {
    
        add_filter( 'wp_edit_nav_menu_walker', array( $this, 'load_menu_walker' ), 99 );
        
    }
    
    /**
     * Loads menu walker
     *
     * @since 2.8
     */
    function load_menu_walker( $walker ) {
    
        $walker = 'Fox_Menu_Item_Custom_Fields_Walker';
        if ( ! class_exists( $walker ) ) {
            require_once get_template_directory() . '/inc/admin/framework/nav/walker-nav-menu-edit.php'; // custom walker to add fields
        }

        return $walker;
        
    }
    
    /**
     * Enqueue javascript & style for admin
     *
     * @since Fox 2.2
     */
    function enqueue(){
        
        // We need to upload image/media constantly
        wp_enqueue_media();
        
        // admin css
//        wp_enqueue_style( 'wi-admin', get_template_directory_uri() . '/css/admin.css', array( 'wp-color-picker', 'wp-mediaelement' ) );
        
        // admin javascript
//        wp_enqueue_script( 'wi-admin', get_template_directory_uri() . '/js/admin.js', array( 'wp-color-picker', 'wp-mediaelement' ), '20160326', true );
        
        // localize javascript
        $jsdata = apply_filters( 'wiadminjs', array() );
        wp_localize_script( 'wi-admin', 'WITHEMES_ADMIN' , $jsdata );
        
    }
    
    /**
     * Localization some text
     *
     * @since Fox 2.2
     */
    function l10n( $jsdata ) {
    
        $jsdata[ 'l10n' ] =  array(
        
            'choose_image' => esc_html__( 'Choose Image', 'wi' ),
            'change_image' => esc_html__( 'Change Image', 'wi' ),
            'upload_image' => esc_html__( 'Upload Image', 'wi' ),
            
            'choose_images' => esc_html__( 'Choose Images', 'wi' ),
            'change_images' => esc_html__( 'Change Images', 'wi' ),
            'upload_images' => esc_html__( 'Upload Images', 'wi' ),
        
        );
        
        return $jsdata;
    
    }
    
    /**
     * Metaboxes
     *
     * @return $metaboxes
     *
     * @modified since 2.4
     * @since Fox 2.2
     */
    function metaboxes( $metaboxes ) {
    
        $metaboxes[] = array (
            
            'id' => 'page-options',
            'screen' => array( 'page' ),
            'title' => esc_html__( 'Settings', 'wi' ),
            'fields' => array(
                
                array(
                    'id' => 'column_layout',
                    'name' => esc_html__( 'Column Layout', 'wi' ),
                    'type' => 'select',
                    'options' => array(
                        '' => esc_html__( 'Default', 'wi' ),
                        'single-column' => esc_html__( 'Single-column', 'wi' ),
                        'two-column' => esc_html__( 'Two-column', 'wi' ),
                    ),
                    'std' => '',
                ),
                
                array(
                    'id' => 'sidebar_layout',
                    'name' => esc_html__( 'Sidebar layout', 'wi' ),
                    'type' => 'select',
                    'options' => array(
                        '' => esc_html__( 'Default', 'wi' ),
                        'sidebar-right' => esc_html__( 'Sidebar right', 'wi' ),
                        'sidebar-left' => esc_html__( 'Sidebar left', 'wi' ),
                        'no-sidebar' => esc_html__( 'No sidebar', 'wi' ),
                    ),
                    'std' => '',
                ),
                
                array(
                    'id' => 'cool',
                    'name' => 'Make this page "COOL"',
                    'type' => 'checkbox',
                    'desc' => 'When check this, it displays a page with big hero header, narrow content width.',
                ),
                
                array(
                    'id' => 'dropcap',
                    'name' => esc_html__( 'First letter dropcap', 'wi' ),
                    'type' => 'select',
                    'options' => array(
                        '' => esc_html__( 'Default', 'wi' ),
                        'true' => esc_html__( 'Enable', 'wi' ),
                        'false' => esc_html__( 'Disable', 'wi' ),
                    ),
                    'std' => '',
                ),
                
                array(
                    'id' => 'disable_share',
                    'name' => esc_html__( 'Hide share icons this page', 'wi' ),
                    'type' => 'checkbox',
                ),
                
            ),
        
        );
        
        $metaboxes[] = array (
            
            'id' => 'post-options',
            'screen' => array( 'post' ),
            'title' => esc_html__( 'Settings', 'wi' ),
            'fields' => array(
                
                array(
                    'id' => 'column_layout',
                    'name' => esc_html__( 'Column Layout', 'wi' ),
                    'type' => 'select',
                    'options' => array(
                        '' => esc_html__( 'Default', 'wi' ),
                        'single-column' => esc_html__( 'Single-column', 'wi' ),
                        'two-column' => esc_html__( 'Two-column', 'wi' ),
                    ),
                    'std' => '',
                ),
                
                array(
                    'id' => 'sidebar_layout',
                    'name' => esc_html__( 'Sidebar layout', 'wi' ),
                    'type' => 'select',
                    'options' => array(
                        '' => esc_html__( 'Default', 'wi' ),
                        'sidebar-right' => esc_html__( 'Sidebar right', 'wi' ),
                        'sidebar-left' => esc_html__( 'Sidebar left', 'wi' ),
                        'no-sidebar' => esc_html__( 'No sidebar', 'wi' ),
                    ),
                    'std' => '',
                ),
                
                array(
                    'id' => 'dropcap',
                    'name' => esc_html__( 'First letter dropcap', 'wi' ),
                    'type' => 'select',
                    'options' => array(
                        '' => esc_html__( 'Default', 'wi' ),
                        'true' => esc_html__( 'Enable', 'wi' ),
                        'false' => esc_html__( 'Disable', 'wi' ),
                    ),
                    'std' => '',
                ),
                
                array(
                    'id' => 'cool',
                    'name' => 'Make this post "COOL"',
                    'type' => 'checkbox',
                    'desc' => 'When check this, it displays a post with big hero header, narrow content width.',
                ),
                
                array(
                    'id' => 'cool_thumbnail_size',
                    'name' => 'Cool Post Thumbnail',
                    'type' => 'select',
                    'options' => array(
                        '' => 'Default',
                        'full' => 'Fullwidth',
                        'big' => 'Big',
                    ),
                    'desc' => 'If you select "Default", it takes option value from Customizer',
                ),
                
                array(
                    'id' => 'hero',
                    'name' => 'Make featured image hero?',
                    'type' => 'select',
                    'options' => array(
                        '' => 'Default',
                        'full' => 'Fullscreen hero image',
                        'half' => 'Half vertical hero image',
                        'none' => 'Disable',
                    ),
                ),
                
                array(
                    'id' => 'hide_featured_image',
                    'name' => 'Hide featured image this post?',
                    'type' => 'checkbox',
                ),
                
            ),
        
        );
        
        /**
         * since 3.0
         */
        $metaboxes[] = array (
            
            'id' => 'format-options',
            'screen' => array( 'post' ),
            'title' => esc_html__( 'Post Format Options', 'wi' ),
            'fields' => array(
                
                array(
                    'id' => '_format_video_embed',
                    'name' => 'Video Embed Code',
                    'type' => 'textarea',
                    'prefix' => false,
                ),
                
                array(
                    'id' => '_format_audio_embed',
                    'name' => 'Audio Embed Code',
                    'type' => 'textarea',
                    'prefix' => false,
                ),
                
                array(
                    'id' => '_format_link_url',
                    'name' => 'Format link URL',
                    'type' => 'text',
                    'prefix' => false,
                ),
                
                array(
                    'id' => '_format_gallery_images',
                    'name' => 'Gallery Images',
                    'type' => 'images',
                    'prefix' => false,
                ),
                
                array(
                    'id' => '_format_gallery_effect',
                    'name' => 'Gallery Effects',
                    'type' => 'radio',
                    'options' => array(
                        'carousel' => 'Carousel',
                        'fade' => 'Fade',
                        'slide' => 'Slide',
                    ),
                    'prefix' => false,
                ),
            
            ),
        
        );
        
        $metaboxes[] = array (
            
            'id' => 'reiview-options',
            'screen' => array( 'post' ),
            'title' => esc_html__( 'Review Settings', 'wi' ),
            'fields' => array(
                
                array(
                    'id' => 'review',
                    'name' => esc_html__( 'Review', 'wi' ),
                    'type' => 'review',
                ),
                
                array(
                    'id' => 'review_text',
                    'name' => esc_html__( 'Custom Text', 'wi' ),
                    'type' => 'textarea',
                ),
                
                array(
                    'id' => 'review_btn1_url',
                    'name' => esc_html__( 'Button 1 URL', 'wi' ),
                    'type' => 'text',
                    'placeholder' => 'http://',
                ),
                
                array(
                    'id' => 'review_btn1_text',
                    'name' => esc_html__( 'Button 1 Text', 'wi' ),
                    'type' => 'text',
                    'placeholder' => 'Click Here',
                ),
                
                array(
                    'id' => 'review_btn2_url',
                    'name' => esc_html__( 'Button 2 URL', 'wi' ),
                    'type' => 'text',
                    'placeholder' => 'http://',
                ),
                
                array(
                    'id' => 'review_btn2_text',
                    'name' => esc_html__( 'Button 2 Text', 'wi' ),
                    'type' => 'text',
                    'placeholder' => 'Click Here',
                ),
            
            ),
        
        );
        
        return $metaboxes;
    
    }
    
}

Wi_Admin::instance()->init();

endif; // class exists