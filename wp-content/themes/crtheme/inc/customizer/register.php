<?php
define( 'FOX_REGISTER_URL', get_template_directory_uri() . '/inc/customizer/' );
define( 'FOX_REGISTER_PATH', get_template_directory() . '/inc/customizer/' );

if ( !class_exists( 'Fox_Register' ) ) :
/**
 * Register Options
 *
 * @since 1.0
 */
class Fox_Register {
    
    private static $prefix = 'wi_';
    
    /**
	 * Construct
	 */
	public function __construct() {
	}
    
    /**
	 * The one instance of Fox_Register
	 *
	 * @since 1.0
	 */
	private static $instance;

	/**
	 * Instantiate or return the one Fox_Register instance
	 *
	 * @since 1.0
	 *
	 * @return Fox_Register
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
     * @since 1.0
     */
    public function init() {
    }
    
    /**
     * List of all options
     *
     * shorthand is a replacement for property, type and preview way. For instance, if you type shorthand: width then
     * preview should be css, type should be text, property should be width & unit often be px
     *
     * @since 1.0
     */
    public function options() {
        
        // Var
        $options = array();
        
        /* Homepage Builder
        -------------------------------------------------------------------------------- */
        $options[ 'disable_builder_paged' ] = array(
            'type'      => 'checkbox',
            'name'      => 'Disable builder sections for pages 2, 3..?',
            
            'section'   => 'homepage_builder',
            'section_title' => 'Homepage Builder',
            'section_desc' => 'General options for the homepage builder.',
            
            'panel'     => 'homepage',
            'panel_title' =>'Homepage Builder',
            'panel_desc'=> 'Using this module, you can enable 1 - 10 sections that appear before main stream.',
            'panel_priority'=> 10,
        );
        
        $options[ 'max_sections' ] = array(
            'type'      => 'text',
            'std'       => 10,
            'name'      => 'Max number of sections allowed',
            'desc'      => 'You must RELOAD this customizer page after saving to see more sections. NOTE: DO NOT enter the number more than you need.',
        );
        
        /* Main Stream
        -------------------- */
        $options[ 'disable_main_stream' ] = array(
            'type'      => 'checkbox',
            'name'      => 'Disable main posts stream?',
            'section'   => 'main_stream',
            'section_title' => 'Main Stream',
            'section_desc' => 'Check this to disable main posts stream on your homepage. This will make your site looks like a magazine instead of a blog.',
            
            'panel'     => 'homepage',
        );
        
        $options[ 'main_stream_order' ] = array(
            'type'      => 'text',
            'placeholder' => 'Eg. 2',
            'name'      => '[NEW] Display main stream after section?',
            'desc' => 'By default, main stream will be displayed after all sections. By this option, you can change the order of main stream and allow it to be displayed right after some section. Enter 0 to display main stream before all.',
        );
        
        $options[ 'main_stream_heading' ] = array(
            'type'      => 'text',
            'name'      => 'Heading text',
            'prefix'    => false,
        );
        
        $options[ 'offset' ] = array(
            'type'      => 'text',
            'name'      => 'Offset?',
            'placeholder' => 'Eg. 3',
            'desc'      => 'If you enter 3, your blog stream starts from 4th',
            'prefix'    => true,
        );
        
        $categories = get_categories( array(
            'fields' => 'id=>name',
            'orderby'=> 'slug',
            'hide_empty' => false,
        ));
        
        $options[ 'exclude_categories' ] = array(
            'type'      => 'multicheckbox',
            'name'      => 'Exclude categories?',
            'options'   => $categories,
        );
        
        $options[ 'main_stream_ad_code' ] = array(
            'type'      => 'textarea',
            'name'      => 'Advertisement Code',
            'desc'      => 'Note that the ad will appear BETWEEN posts. You can insert HTML, Javascript, Adsense code... If you use image banner, you can use upload button below.',
            'prefix'    => false,
        );
        
        $options[ 'main_stream_banner' ] = array(
            'type'      => 'image',
            'name'      => 'Image Banner',
            'desc'      => 'This banner appears BETWEEN posts',
            'prefix'    => false,
        );
        
        $options[ 'main_stream_banner_url' ] = array(
            'type'      => 'text',
            'name'      => 'Banner URL',
            'placeholder' => 'http://',
            'prefix'    => false,
        );
        
        $postTypes = get_post_types( array() );
        $postTypesList = array();
        $excludedPostTypes = array(
            'post',
            'revision',
            'nav_menu_item',
            'vc_list_item',
            'page',
            'attachment',
            'custom_css',
            'customize_changeset',
            'vc4_templates',
            'wpcf7_contact_form',
            'tablepress_table',
            'mc4wp-form',
            'product_variation',
            'shop_order',
            'shop_order_refund',
            'shop_coupon',
            'shop_webhook',
            
            'oembed_cache',
            'user_request',
            'wp_block',
            'scheduled-action',
            'jp_pay_order',
            'jp_pay_product',
        );
        if ( is_array( $postTypes ) && ! empty( $postTypes ) ) {
            foreach ( $postTypes as $postType ) {
                if ( ! in_array( $postType, $excludedPostTypes ) ) {
                    $label = ucfirst( $postType );
                    $postTypesList[ 'post_type_' . $postType ] = 'Post Type: ' . $label;
                }
            }
        }
        
        // cat array
        $cat_arr = array(
            'none'          =>  '...',
            'all'       =>  'All categories',
            'featured'  =>  'Posts marked by "star"',
            'sticky'    =>  'Sticky posts',
            'video'     =>  'Video Posts',
            'gallery'   =>  'Gallery Posts',
            'audio'     =>  'Audio Posts',
        );
        $cats = get_categories();
        foreach ($cats as $cat) {
            $cat_arr[ 'cat_' . $cat->slug ] = sprintf('Category: %s',$cat->name);
        }
        
        $cat_arr += $postTypesList;
        
        // orderby array
        $orderby_arr = array( 'date'=>'Date','comment'=>'Comment count','view'=>'View count', 'random' => 'Random' );
        
        $sections = array();
        $max_sections = absint( get_theme_mod( 'wi_max_sections', 10 ) );
        if ( $max_sections < 2 || $max_sections > 40 ) $max_sections = 10;
        
        for ( $i=1; $i<= $max_sections;$i++ ):
        
            // add section
            $cat = get_theme_mod( 'bf_' . $i . '_cat' );
            $title = 'Section '. $i;
            if ($cat == 'featured') $title .= ': Featured posts';
            elseif ($cat == 'all') $title .= ': All posts';
            elseif ($cat == 'sticky') $title .= ': Sticky posts';
            elseif ($cat != '' && $cat != 'none' ) $title .= ': ' . ucfirst( str_replace( 'cat_', '', $cat ) );
        
            $options[ 'bf_' . $i . '_cat' ] = array(
                'name'    => 'Display posts from?',
                'type'     => 'select',
                'options'  => $cat_arr,
                'desc'=>'If you wanna learn about Sticky post, read <a href="http://www.wpbeginner.com/beginners-guide/how-to-make-sticky-posts-in-wordpress/" target="_blank">this article</a>.',
                
                'section'  => 'bf_'.$i,
                'section_title' => $title,
                'panel' => 'homepage',
                
                'prefix'    => false,
            );
        
            $options[ 'bf_' . $i . '_layout' ] = array(
                'name'    => 'Displaying as',
                'type'     => 'select',
                'options'   => wi_block_array(),
                'std'       => 'slider',
                'prefix'    => false,
            );
        
            $options[ 'bf_' . $i . '_number' ] = array(
                'name'    => 'Number of posts to show?',
                'type'     => 'text',
                'prefix'    => false,
            );
        
            $options[ 'bf_' . $i . '_orderby' ] = array(
                'name'    => 'Order By?',
                'type'     => 'select',
                'options'   => $orderby_arr,
                'std'       => 'date',
                
                'prefix'    => false,
            );
        
            $options[ 'bf_' . $i . '_offset' ] = array(
                'name'    => 'Offset',
                'desc'      => 'Number of posts to pass by',
                'type'     => 'text',
                
                'prefix'    => false,
            );
        
            $options[ 'bf_' . $i . '_heading' ] = array(
                'name'      => 'Heading text',
                'type'      => 'text',
                
                'prefix'    => false,
            );
        
            $options[ 'bf_' . $i . '_viewall_link' ] = array(
                'name'      => '"View all" URL',
                'type'      => 'url',
                
                'prefix'    => false,
            );
        
            $options[ 'bf_' . $i . '_viewall_text' ] = array(
                'name'      => '"View all" text',
                'type'      => 'text',
                
                'prefix'    => false,
            );
        
            $options[ 'bf_' . $i . '_ad_code' ] = array(
                'name'      => 'Advertisement Code',
                'type'      => 'textarea',
                'desc'      => 'Note that the ad will appear BEFORE this section. You can insert HTML, Javascript, Adsense code... If you use image banner, you can use upload button below.',
                
                'prefix'    => false,
            );
        
            $options[ 'bf_' . $i . '_banner' ] = array(
                'name'      => 'Image Banner',
                'type'      => 'image',
                'desc'      => 'This banner appears before posts',
                
                'prefix'    => false,
            );
        
            $options[ 'bf_' . $i . '_banner_url' ] = array(
                'name'      => 'Banner URL',
                'type'      => 'text',
                'placeholder' => 'http://',
                
                'prefix'    => false,
            );
        
        endfor;
        
        /* Layout
        -------------------------------------------------------------------------------- */
        // ARCHIVE LAYOUTS
        $elements = array(
            'home'          =>  array('Homepage','Customize layout for main posts stream on front page'),
            'category'      =>  array('Category','Customize layout for categories. You can still select layout for each individual category when edit category'),
            'archive'       =>  'Archive page',
            'tag'           =>  array('Tag','Customize layout for tags. You can still select layout for each individual tag when edit tag'),
            'author'        =>  'Author page',
            'search'        =>  'Search page',
            'all-featured'  =>  'All featured posts page',
        );
        
        foreach ($elements as $ele => $name ) {
            
            $title = is_array( $name ) ? $name[0] . ' Layout' : $name . ' Layout';
            $desc = is_array( $name ) ? $name[1] : '';
            
            $options[ $ele. '_layout' ] = array(
                'name'    => 'Select Layout',
                'options'   => wi_layout_array(),
                'type'      => 'radio',
                
                'section' => 'layout_'.$ele,
                'section_title' => $title,
                'section_desc' => $desc,
                'panel'       => 'layout',
                'panel_title' => 'Layout',
                'panel_priority' => 11,
                
                'prefix'    => true,
            );
            
            if ( 'all-featured' != $ele ) {
            
                $options[ $ele. '_sidebar_state' ] = array(
                    'name'    => 'Sidebar',
                    'options'   => wi_sidebar_array(),
                    'type'      => 'radio',
                    'std'       => 'sidebar-right',
                );
                
            }
            
        } // foreach
        
        $options[ $ele. '_layout' ] = array(
            'name'    => 'Select Layout',
            'options'   => wi_layout_array(),
            'type'      => 'radio',

            'section' => 'layout_'.$ele,
            'section_title' => $name . ' Layout',
            'panel'       => 'layout',
            'panel_title' => 'Layout',
            'panel_priority' => 11,
        );

        $options[ 'single_sidebar_state' ] = array(
            'name'    => 'Sidebar',
            'options'   => wi_sidebar_array(),
            'type'      => 'radio',
            'std'       => 'sidebar-right',
            
            'section'   => 'layout_single',
            'section_title' => 'Single Post Layout',
            'panel'     => 'layout',
        );
        
        $options[ 'page_sidebar_state' ] = array(
            'name'    => 'Sidebar',
            'options'   => wi_sidebar_array(),
            'type'      => 'radio',
            'std'       => 'sidebar-right',
            
            'section'   => 'layout_page',
            'section_title' => 'Page Layout',
            'panel'     => 'layout',
        );
        
        /* Header
        -------------------------------------------------------------------------------- */
        $options[ 'header_layout' ] = array(
            'type'      => 'radio',
            'options'   => array(
                'stack1' => 'Navigation Top - Logo Below',
                'stack2' => 'Logo Top - Navigation Below',
                'inline' => 'Logo Left - Navigation Right',
            ),
            'std'       => 'stack1',
            'name'      => esc_html__( 'Header Layout', 'wi' ),
            
            'section'   => 'header',
            'section_title'=> esc_html__( 'Header', 'wi' ),
            'section_priority' => 110,
        );
        
        $options[ 'disable_header_sticky' ] = array(
            'type'      => 'checkbox',
            'name'      => esc_html__( 'Disable header sticky?', 'wi' ),
        );
        
        $options[ 'logo' ] = array(
            'type'      => 'image',
            'name'      => esc_html__( 'Upload your logo', 'wi' ),
            'desc'=> esc_html__('The logo in the demo site is 1170px wide.','wi'), 
        );
        
        $options[ 'logo_retina' ] = array(
            'type'      => 'image',
            'name'      => esc_html__( 'Upload retina version of the logo', 'wi' ),
            'desc'=> esc_html__('2x times logo dimensions.','wi'), 
        );
        
        $options[ 'logo_minimal' ] = array(
            'type'      => 'image',
            'name'      => 'Minimal Logo',
            'desc'      => 'This logo will be used for the minimal header.',
        );
        
        $options[ 'logo_minimal_white' ] = array(
            'type'      => 'image',
            'name'      => 'Minimal Logo (White Version)',
            'desc'      => 'Will be used on dark background',
        );
        
        $options[ 'logo_width' ] = array(
            'type'      => 'text',
            'name'      => esc_html__( 'Logo width (px)', 'wi' ),
            'placeholder' => '1170px',
        );
        
        $options[ 'logo_margin_top' ] = array(
            'type'      => 'text',
            'name'      => esc_html__( 'Logo margin top (px)', 'wi' ),
        );
        
        $options[ 'logo_margin_bottom' ] = array(
            'type'      => 'text',
            'name'      => esc_html__( 'Logo margin bottom (px)', 'wi' ),
        );
        
        $options[ 'disable_header_social' ] = array(
            'type'      => 'checkbox',
            'name'      => esc_html__( 'Disable header social icons', 'wi' ),
        );
        
        $options[ 'disable_header_search' ] = array(
            'type'      => 'checkbox',
            'name'      => esc_html__( 'Disable header search', 'wi' ),
        );
        
        $options[ 'disable_header_slogan' ] = array(
            'type'      => 'checkbox',
            'name'      => esc_html__( 'Disable header slogan', 'wi' ),
        );
        
        $options[ 'submenu_style' ] = array(
            'type'      => 'radio',
            'name'      => esc_html__( 'Select submenu style', 'wi' ),
            'options'  =>  array(
                'light'=>'Light',
                'dark'=>'Dark'
            ),
            'std'       => 'light',
        );
        
        $options[ 'header_code' ] = array(
            'type'      => 'textarea',
            'name'      => esc_html__( 'Add custom code to header', 'wi' ),
            'desc'      => 'Add any code inside <head> tag. Don\'t write anything unless you understand what you\'re doing.',
        );
        
        /* Footer
        ---------------------------------------- */
        $options[ 'footer_logo' ] = array(
            'type'      => 'image',
            'name'      => esc_html__( 'Footer Logo', 'wi' ),
            
            'section'   => 'footer',
            'section_title' => esc_html__( 'Footer', 'wi' ),
            'section_priority'     => 150,
        );
        
        $options[ 'footer_logo_retina' ] = array(
            'type'      => 'image',
            'name'      => esc_html__( 'Upload retina version of the footer logo', 'wi' ),
        );
        
        $options[ 'footer_logo_width' ] = array(
            'type'      => 'text',
            'name'      => esc_html__( 'Footer logo width (px)', 'wi' ),
        );
        
        $options[ 'disable_footer_social' ] = array(
            'type'      => 'checkbox',
            'name'      => esc_html__( 'Disable footer social icons', 'wi' ),
        );
        
        $options[ 'footer_social_skin' ] = array(
            'type'      => 'radio',
            'options'   => array(
                'black' => 'Solid Black',
                'outline' => 'Outline',
            ),
            'std'       => 'black',
            'name'      => esc_html__( 'Footer Social Icons Skin', 'wi' ),
        );
        
        $options[ 'disable_footer_search' ] = array(
            'type'      => 'checkbox',
            'name'      => esc_html__( 'Disable footer seachbox', 'wi' ),
        );
        
        $options[ 'copyright' ] = array(
            'type'      => 'textarea',
            'name'      => esc_html__( 'Copyright text', 'wi' ),
        );
        
        $options[ 'disable_backtotop' ] = array(
            'type'      => 'checkbox',
            'name'      => esc_html__( 'Disable "back to top" button', 'wi' ),
        );
        
        /* FONTS
        ---------------------------------------- */
        $types = array(
            'body'=> __('Body text','wi'),
            'heading' => __('Heading text','wi'),
            'nav' => __('Menu','wi')
        );
        
        $default_fonts = array(
            'body'          =>  'Merriweather',
            'heading'       =>  'Oswald',
            'nav'           =>  'Oswald',
        );
        
        $default_fallback = array(
            'body'          =>  'Georgia, serif',
            'heading'       =>  'sans-serif',
            'nav'           =>  'sans-serif',
        );
        
        foreach ($types as $type => $element ) {
            
            $options[ $type.'_font' ] = array(
                'name'      => sprintf( esc_html__( 'Select "%s" font?', 'wi' ), $element ),
                'type'      => 'select',
                'options'   => fox_option_fonts(),
                'std'       => $default_fonts[ $type ],
                
                'section'   => 'typography',
                'section_title' => 'Typography',
                'section_priority' => 140,
            );
            
            $options[ $type.'_custom_font' ] = array(
                'name'      => sprintf( esc_html__( 'Custom font name for "%s" if it\'s not in Google fonts', 'wi' ), $element ),
                'type'      => 'text',
            );
            
            $options[ $type.'_fallback_font' ] = array(
                'name'      => sprintf( esc_html__( 'Fallback font for "%s"?', 'wi' ), $element ),
                'type'      => 'select',
                'options'   => wi_fallback_font_array(),
                'std'       => $default_fallback[$type],
            );
            
            if ( 'heading' == $type || 'nav' == $type ) {
                
                $options[ $type.'_font_weight' ] = array(
                    'name'      => sprintf( esc_html__( '%s font weight', 'wi' ), $element ),
                    'type'      => 'select',
                    'options'   => [
                        '' => 'Default',
                        '100' => '100',
                        '300' => '300',
                        '400' => '400',
                        '600' => '600',
                        '700' => '700',
                        '900' => '900',
                    ],
                    'std'       => '',
                );
                
            }
            
        } // foreach
        
        /* Font Size
        -------------------------------------------------------------------------------- */
        
        $elements = array(
            'body'  =>  'Body',
            'nav'   =>  'Menu item',
            'nav-sub'=>  'Submenu item',
            'section-heading'   =>  'Section Heading',
            'slider-title'      =>  'Slider post title',
            'big-title'         =>  'Big post title',
            'post-title'        =>  'Standard-layout post title',
            'grid-title'        =>  'Grid-layout post title',
            'masonry-title'     =>  'Masonry-layout post title',
            'newspaper-title'   =>  'Newspaper-layout post title',
            'list-title'        =>  'List-layout post title',
            'page-title'        =>  'Single page title',
            'archive-title'     =>  'Archive (category, tag...) page title',
            'widget-title'      =>  'Widget title',
            'h1'    =>  'H1',
            'h2'    =>  'H2',
            'h3'    =>  'H3',
            'h4'    =>  'H4',
            'h5'    =>  'H5',
            'h6'    =>  'H6',
        );
        
        $defaults = array(
            'body'  =>  '16',
            'nav'   =>  '26',
            'nav-sub'=>  '12',
            'section-heading'   =>  '80',
            'slider-title'      =>  '60',
            'big-title'         =>  '60',
            'post-title'        =>  '52',
            'grid-title'        =>  '26',
            'masonry-title'     =>  '32',
            'newspaper-title'   =>  '36',
            'list-title'        =>  '36',
            'page-title'        =>  '70',
            'archive-title'     =>  '80',
            'widget-title'      =>  '12',
            'h1'    =>  '40',
            'h2'    =>  '32',
            'h3'    =>  '26',
            'h4'    =>  '22',
            'h5'    =>  '18',
            'h6'    =>  '14',
        );
        
        foreach ($elements as $ele => $label) {
            
            $options[ $ele.'_size' ] = array(
                'name'      => sprintf( esc_html__( '%s font size', 'wi' ), $label),
                'type'      => 'text',
                'std'       => $defaults[$ele],

                'section'     => 'fontsize',
                'section_title'=> esc_html__( 'Font Size', 'wi' ),
                'section_priority'=> 145,
            );
        
        }
        
        $options[ 'slogan_spacing' ] = array(
            'name'      => esc_html__( 'Slogan letter spacing', 'wi' ),
            'type'      => 'text',
            'std'       => 12,
        );
        
        /*------------------------------------------   STYLE   ------------------------------------------ */
        $options[ 'content_width' ] = array(
            'name'      => esc_html__( 'Content width (px)', 'wi' ),
            'desc'      => 'Enter a number. Default is 1020px.',
            'type'      => 'text',
            'std'       => 1020,
            
            'section'     => 'style',
            'section_title'=> esc_html__( 'Style', 'wi' ),
            'section_priority'=> 155,
        );
        
        $options[ 'sidebar_width' ] = array(
            'name'      => esc_html__( 'Sidebar width (px)', 'wi' ),
            'desc'      => 'Enter a number. Default is 265px.',
            'type'      => 'text',
            'std'       => 265,
        );
        
        $options[ 'sticky_sidebar' ] = array(
            'name'      => esc_html__( 'Sticky sidebar?', 'wi' ),
            'type'      => 'checkbox',
        );
        
        $options[ 'dropcap_style' ] = array(
            'type'      => 'radio',
            'options'   => array(
                'default' => 'Default',
                'dark' => 'Dark',
                'color' => 'Color',
            ),
            'std'       => 'default',
            'name'      => esc_html__( 'Dropcap Style', 'wi' ),
        );
        
        $colors = array();
        
        $colors[] = array(
			'slug'    => 'primary_color',
			'default' => '#db4a37',
			'label'   => __( 'Accent color', 'wi' )
		);

		$colors[] = array(
			'slug'    => 'text_color',
			'default' => '#000000',
			'label'   => __( 'Text Color', 'wi' )
		);
        
		$colors[] = array(
			'slug'    => 'link_color',
			'default' => '#db4a37',
			'label'   => __( 'Link Color', 'wi' )
		);
        
		$colors[] = array(
			'slug'    => 'link_hover_color',
			'default' => '#db4a37',
			'label'   => __( 'Link hover color', 'wi' )
		);
		$colors[] = array(
			'slug'    => 'active_nav_color',
			'default' => '#fff',
			'label'   => __( 'Menu active color', 'wi' )
		);
        $colors[] = array(
			'slug'    => 'widget_title_bg_color',
			'default' => '#000',
			'label'   => __( 'Widget title background color', 'wi' )
		);
        $colors[] = array(
			'slug'    => 'widget_title_text_color',
			'default' => '#fff',
			'label'   => __( 'Widget title text color', 'wi' )
		);
		$colors[] = array(
			'slug'    => 'selection_color',
			'default' => '',
			'label'   => __( 'Selection color', 'wi' )
		);
        $colors[] = array(
			'slug'    => 'selection_text_color',
			'default' => '#fff',
			'label'   => __( 'Selection text color', 'wi' )
		);
        
        $colors[] = array(
			'slug'    => 'body_background_color',
			'default' => '#fff',
			'label'   => __( 'Body background color', 'wi' )
		);
        
		foreach ( $colors as $color ) {
            
            $options[ $color['slug'] ] = array(
                'type'      => 'color',
                'name'      => $color['label'],
                'std'       => $color['default'],
            );
			
		}
        
        // ARCHIVE
        $options[ 'body_background' ] = array(
            'type'      => 'image',
            'name'      => esc_html__( 'Body background image', 'wi' ),
        );
        
        $options[ 'body_background_position' ] = array(
            'type'      => 'text',
            'placeholder' => 'center top',
            'name'      => esc_html__( 'Body background position', 'wi' ),
        );
        
        $options[ 'body_background_size' ] = array(
            'type'      => 'text',
            'placeholder' => 'cover',
            'name'      => esc_html__( 'Body background size', 'wi' ),
        );
        
        $options[ 'body_background_repeat' ] = array(
            'type'      => 'select',
            'name'      => esc_html__( 'Body background repeat', 'wi' ),
            'options'  =>  array(
                 'no-repeat' =>  'No repeat',
                 'repeat' =>  'Repeat',
                 'repeat-x' =>  'Repeat x',
                 'repeat-y' =>  'Repeat y',
             ),
            'std'       => 'no-repeat',
        );
        
        $options[ 'body_background_attachment' ] = array(
            'type'      => 'select',
            'name'      => esc_html__( 'Body background attachment', 'wi' ),
            'options'  =>  array(
                'fixed' =>  'Fixed',
                'scroll' =>  'Scroll',
             ),
            'std'       => 'fixed',
        );
        
        $options[ 'content_background_opacity' ] = array(
            'type'      => 'text',
            'name'      => esc_html__( 'Content background opacity', 'wi' ),
            'desc'       => 'Enter a number from 0 - 100. Default is 100%.',
        );
        
        /*------------------------------------------   Blog   ------------------------------------------ */
        $options[ 'home_number' ] = array(
            'type'      => 'text',
            'name'      => esc_html__( 'Custom number of posts to show on homepage', 'wi' ),
            
            'section'   => 'blog',
            'section_title' => 'Blog',
            'section_priority' => 160,
        );
        
        $options[ 'disable_blog_image' ] = array(
            'type'      => 'checkbox',
            'name'      => esc_html__( 'Hide featured image on standard blog post', 'wi' ),
        );
        
        $options[ 'disable_blog_date' ] = array(
            'type'      => 'checkbox',
            'name'      => esc_html__( 'Hide post date?', 'wi' ),
        );
        
        $options[ 'time_style' ] = array(
            'type'      => 'radio',
            'name'      => 'Time Fashion',
            'options'   => array(
                'standard' => 'March 22, 2019',
                'human' => '5 days ago',
            ),
            'std'       => 'human',
        );
        
        $options[ 'disable_blog_categories' ] = array(
            'type'      => 'checkbox',
            'name'      => esc_html__( 'Hide post categories?', 'wi' ),
        );
        
        $options[ 'disable_blog_author' ] = array(
            'type'      => 'checkbox',
            'name'      => esc_html__( 'Hide post author?', 'wi' ),
        );
        
        $options[ 'blog_view_count' ] = array(
            'type'      => 'checkbox',
            'name'      => esc_html__( 'Show view count?', 'wi' ),
        );
        
        $options[ 'disable_blog_comment' ] = array(
            'type'      => 'checkbox',
            'name'      => esc_html__( 'Hide post comment link?', 'wi' ),
        );
        
        $options[ 'disable_blog_share' ] = array(
            'type'      => 'checkbox',
            'name'      => esc_html__( 'Hide post share icons?', 'wi' ),
        );
        
        $options[ 'disable_blog_related' ] = array(
            'type'      => 'checkbox',
            'name'      => esc_html__( 'Hide related posts?', 'wi' ),
        );
        
        $options[ 'related_source' ] = array(
            'type'      => 'radio',
            'name'      => esc_html__( 'Related posts source', 'wi' ),
            'options'   => array(
                'tags'  => esc_html__( 'Posts having same tags', 'wi' ),
                'jetpack' => esc_html__( 'Jetpack Related Posts Module', 'wi' ),
            ),
            'desc'      => esc_html__( 'To use Jetpack Related Posts module, you have to install Jetpack and enable its related posts module.', 'wi' ),
            'std'   => 'tags',
        );
        
        $options[ 'blog_standard_display' ] = array(
            'type'      => 'radio',
            'name'      => esc_html__( 'Display Content or Excerpt on Standard blog?', 'wi' ),
            'options'   => array(
                'content'  => esc_html__( 'Content', 'wi' ),
                'excerpt' => esc_html__( 'Excerpt', 'wi' ),
            ),
            'std'   => 'content',
        );
        
        $options[ 'excerpt_length' ] = array(
            'type'      => 'text',
            'name'      => esc_html__( 'Excerpt length?', 'wi' ),
            'placeholder'=> '55',
            'desc'      => esc_html__( 'Enter a number of words that you wanna display on post excerpt? Default is 55.', 'wi' ),
        );
        
        $options[ 'grid_excerpt_length' ] = array(
            'type'      => 'text',
            'name'      => esc_html__( 'Excerpt length for grid layout', 'wi' ),
            'desc'      => esc_html__( 'This option applied to grid layout while the above one applied to other layouts', 'wi' ),
        );
        
        $options[ 'disable_blog_readmore' ] = array(
            'type'      => 'checkbox',
            'name'      => esc_html__( 'Disable "Read more" button in excerpt mode', 'wi' ),
        );
        
        /*------------------------------------------   ARCHIVE   ------------------------------------------ */
        $options[ 'disable_archive_label' ] = array(
            'type'      => 'checkbox',
            'name'      => esc_html__( 'Disable archive labels: category, tag..', 'wi' ),
            
            'section'   => 'archive',
            'section_title' => 'Archive Page',
            'section_priority' => 165,
        );    
        
        /*------------------------------------------   SINGLE   ------------------------------------------ */
        $options[ 'cool_post_all' ] = array(
            'type'      => 'checkbox',
            'name'      => esc_html__( '[NEW] Make all posts become "cool post"', 'wi' ),
            'desc'      => 'Once check this, ALL posts become cool post, ie. have a big hero featured image and narrow content, sidebar disabled. You can also enable "cool post" for each individual post.',
            
            'section'   => 'single',
            'section_title' => 'Single Post',
            'section_priority' => 170,
        );
        
        $options[ 'cool_thumbnail_size' ] = array(
            'type'      => 'radio',
            'name'      => 'Thumbnail stretch',
            'options'   => array(
                'full' => 'Full screen width',
                'big' => 'A little bit bigger than content',
            ),
            'std'       => 'big',
        );
        
        $options[ 'cool_post_stretch' ] = array(
            'type'      => 'radio',
            'name'      => 'Post content image stretch',
            'options'   => array(
                'bit' => 'A little bit bigger than content',
                'full' => 'Full screen width',
            ),
            'std'       => 'bit',
        );
        
        $options[ 'hero' ] = array(
            'type'      => 'radio',
            'options'   => array(
                'none' => 'None',
                'full' => 'Fullscreen hero image',
                'half' => 'Half vertical hero image',
            ),
            'std'       => 'none',
            'name'      => esc_html__( 'Hero image?', 'wi' ),
            'desc'      => 'Note that you can still select hero setting for each individual post.',
        );
        
        $options[ 'disable_single_image' ] = array(
            'type'      => 'checkbox',
            'name'      => esc_html__( 'Hide featured image on single post', 'wi' ),
        );
        
        $options[ 'disable_single_share' ] = array(
            'type'      => 'checkbox',
            'name'      => esc_html__( 'Hide post share icons?', 'wi' ),
        );
        
        $options[ 'disable_single_tag' ] = array(
            'type'      => 'checkbox',
            'name'      => esc_html__( 'Hide post tags?', 'wi' ),
        );
        
        $options[ 'disable_single_related' ] = array(
            'type'      => 'checkbox',
            'name'      => esc_html__( 'Hide "related posts" area??', 'wi' ),
        );
        
        $options[ 'disable_single_author' ] = array(
            'type'      => 'checkbox',
            'name'      => esc_html__( 'Hide authorbox?', 'wi' ),
        );
        
        $options[ 'disable_single_comment' ] = array(
            'type'      => 'checkbox',
            'name'      => esc_html__( 'Hide comment area for all posts?', 'wi' ),
        );
        
        $options[ 'disable_single_nav' ] = array(
            'type'      => 'checkbox',
            'name'      => esc_html__( 'Hide post navigation?', 'wi' ),
        );

        $options[ 'disable_single_same_category' ] = array(
            'type'      => 'checkbox',
            'name'      => esc_html__( 'Hide "same category posts" area?', 'wi' ),
        );
        
        $options[ 'disable_side_dock' ] = array(
            'type'      => 'checkbox',
            'name'      => esc_html__( 'Disable "Side Dock" feature on single posts.', 'wi' ),
        );
        
        // SHARE ICONS
        $options[] = array(
            'type'      => 'heading',
            'name'      => esc_html__( 'Share Icons', 'wi' ),
        );
        
        $options[ 'share_icons' ] = array(
            'type'      => 'multicheckbox',
            'name'      => esc_html__( 'Icons', 'wi' ),
            'desc'      => 'Only at most 5 icons will be displayed.',
            'options'   => array(
                'facebook' => 'Facebook',
                'twitter' => 'Twitter',
                'google' => 'Google+',
                'pinterest' => 'Pinterest',
                'linkedin' => 'Linked In',
                'whatsapp' => 'Whatsapp',
                'email'     => 'Email',
                'reddit'    => 'Reddit',
            ),
            'std'       => 'facebook,twitter,pinterest,linkedin,email',
        );
        
        // AUTOLOAD NEXT POST
        $options[] = array(
            'type'      => 'heading',
            'name'      => esc_html__( 'Autoload next post', 'wi' ),
        );
        
        $options[ 'autoload_post' ] = array(
            'type'      => 'checkbox',
            'name'      => esc_html__( '[NEW] Auto load next post', 'wi' ),
        );
        
        $options[ 'disable_nextpost_tags' ] = array(
            'type'      => 'checkbox',
            'name'      => esc_html__( 'Disable next post tags', 'wi' ),
        );
        
        $options[ 'disable_nextpost_authorbox' ] = array(
            'type'      => 'checkbox',
            'name'      => esc_html__( 'Disable next post author box', 'wi' ),
        );
        
        $options[ 'disable_nextpost_related' ] = array(
            'type'      => 'checkbox',
            'name'      => esc_html__( 'Disable next post related area', 'wi' ),
        );
        
        // AD
        $options[] = array(
            'type'      => 'heading',
            'name'      => esc_html__( 'Ad', 'wi' ),
        );
        
        $options[ 'single_before_code' ] = array(
            'type'      => 'textarea',
            'name'      => esc_html__( 'Advertisement code before post content', 'wi' ),
            'desc'      => 'Note that the ad will appear before posts. You can insert HTML, Javascript, Adsense code... If you use image banner, you can use upload button below.'
        );
        
        $options[ 'single_before_banner' ] = array(
            'type'      => 'image',
            'name'      => 'Image Banner',
            'desc'      => 'This banner appears before singe post content',
        );
        
        $options[ 'single_before_banner_url' ] = array(
            'type'      => 'text',
            'placeholder' => 'http://',
            'name'      => 'Banner URL',
        );
        
        $options[ 'single_after_code' ] = array(
            'type'      => 'textarea',
            'name'      => 'Advertisement code after post content',
            'desc'      => 'Note that the ad will appear after posts. You can insert HTML, Javascript, Adsense code... If you use image banner, you can use upload button below.',
        );
        
        $options[ 'single_after_banner' ] = array(
            'type'      => 'image',
            'name'      => 'Image Banner',
            'desc'      => 'This banner appears after singe post content',
        );
        
        $options[ 'single_after_banner_url' ] = array(
            'type'      => 'text',
            'placeholder' => 'http://',
            'name'      => 'Banner URL',
        );
        
        /*------------------------------------------   PAGE   ------------------------------------------ */
        $options[ 'disable_page_share' ] = array(
            'type'      => 'checkbox',
            'name'      => esc_html__( 'Hide share icons on page', 'wi' ),
            
            'section'     => 'page',
            'section_title'=> esc_html__( 'Page', 'wi' ),
            'section_priority'=> 175,
        );
        
        $options[ 'disable_page_comment' ] = array(
            'type'      => 'checkbox',
            'name'      => esc_html__( 'Hide comment area all pages', 'wi' ),
        );
        
        $options[ 'exclude_pages_from_search' ] = array(
            'type'      => 'checkbox',
            'name'      => esc_html__( 'Exclude pages from search', 'wi' ),
        );
        
        /* Social
        -------------------------------------------------------------------------------- */
        $social_arr = wi_social_array();
        foreach ($social_arr as $s => $c):
        
        $options[ 'social_'.$s ] = array(
            'type'      => 'text',
            'name'      => $c,
            
            'section'     => 'social',
            'section_title'=> esc_html__( 'Social Profile', 'wi' ),
            'section_priority'=> 180,
        );
        
        endforeach;
        
        /* Custom CSS
         * removed since 2.9
        -------------------------------------------------------------------------------- *
        $options[ 'custom_css' ] = array(
            'type'      => 'textarea',
            'name'      => esc_html__( 'Insert custom CSS', 'wi' ),
            
            'section'     => 'css',
            'section_title'=> esc_html__( 'Custom CSS', 'wi' ),
            'section_priority'=> 210,
        );
        
        /* Quick Translation
        -------------------------------------------------------------------------------- */
        $strings = array(
            'more_link'             =>  'Keep Reading',
            'previous'              =>  'Previous',
            'next'                  =>  'Next',
            'next_story'            =>  'Next Story',
            'previous_story'        =>  'Previous Story',
            'search'                =>  'Search...',
            'category'              =>  'in',
            'author'                =>  'by %s',
            'date'                  =>  'Published on',
            'latest_posts'          =>  'Latest posts',
            'viewall'               =>  'View all',
            'related'               =>  'You might be interested in',
            'latest'                =>  'Latest from %s',
            'go'                    =>  'Go to',
            'top'                   =>  'Top',
        );
        
        // Quick Translation
        foreach ( $strings as $k => $v ) {
            
            $options[ 'translate_'.$k ] = array(
                'type'      => 'text',
                'name'      => sprintf( 'Translation for "%s"',$v ),
                
                'section'   => 'translation',
                'section_title'=> esc_html__( 'Quick Translation', 'wi' ),
                'section_priority'=> 185,
            );
            
        }
        
        /* MOBILE SETTINGS
        -------------------------------------------------------------------------------- */
        $options[ 'disable_header_slogan_mobile' ] = array(
            'type'      => 'checkbox',
            'name'      => 'Disable the slogan on mobile',
            
            'section'     => 'mobile',
            'section_title' => esc_html__( 'Mobile Options', 'wi' ),
            'section_priority'=> 187,
        );
        
        /* Misc
        -------------------------------------------------------------------------------- */
        $options[ 'twitter_username' ] = array(
            'type'      => 'text',
            'name'      => esc_html__( 'Twitter Username', 'wi' ),
            'desc'      => 'This option will be used for @via in tweet share button.',
            
            'section'     => 'misc',
            'section_title' => esc_html__( 'Miscellaneous', 'wi' ),
            'section_priority'=> 190,
        );
        
        /* Backward Compatibility
         * @since 3.0
        -------------------------------------------------------------------------------- */
        $options[ 'site_border' ] = array(
            'name'      => esc_html__( 'Site Border', 'wi' ),
            'type'      => 'radio',
            'options'   => array(
                'true' => 'Enable',
                'false' => 'Disable',
            ),
            'std'       => 'false',
            
            'section'     => 'backward',
            'section_title' => 'Backward Compatibility',
            'section_priority'=> 250,
        );
        
        $options[ 'enable_hand_lines' ] = array(
            'name'      => esc_html__( 'Enable hand-drawn lines instead of straight lines', 'wi' ),
            'type'      => 'checkbox',
        );
        
        $options[ 'blog_content_column' ] = array(
            'type'      => 'radio',
            'options'   => array(
                '1' => '1 column',
                '2' => '2 columns',
            ),
            'std'       => '1',
            'name'      => 'Post content column',
            'desc' => 'You can set content column for each individual post.'
        );
        
        $options[ 'disable_blog_dropcap' ] = array(
            'type'      => 'checkbox',
            'name'      => esc_html__( 'Disable "big first letter"', 'wi' ),
        );
        
        // @hook `fox_options` so that outer options are welcome
        $options = apply_filters( 'fox_options', $options );
        
        require get_template_directory() . '/inc/customizer/processor.php';
        
        return $final;
        
    }
    
}

endif; // class exists