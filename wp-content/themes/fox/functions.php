<?php
define( 'FOX_VERSION', '3.1' );

// admin
require_once get_parent_theme_file_path( '/inc/admin/admin.php' );
require_once get_parent_theme_file_path( '/inc/admin/framework/widget.php' ); // @since 2.8

// since 2.4
// WooCommerce
require_once get_parent_theme_file_path( '/woo/hooks.php' );

// Review Component
require_once get_parent_theme_file_path( '/inc/review.php' );

// since 2.8
require_once get_parent_theme_file_path( '/inc/header.php' );

// includes
require_once get_parent_theme_file_path( '/inc/google-fonts.php' );
require_once get_parent_theme_file_path( '/inc/fonts.php' );
require_once get_parent_theme_file_path( '/inc/customizer/fonts.php' );
require_once get_parent_theme_file_path( '/inc/featured-post.php' );
require_once get_parent_theme_file_path( '/inc/css.php' );
require_once get_parent_theme_file_path( '/inc/template-tags.php' );
require_once get_parent_theme_file_path( '/inc/template-blogs.php' );
require_once get_parent_theme_file_path( '/inc/automatic-featured-images-from-videos.php' );
//require_once get_parent_theme_file_path( '/inc/post-views/bawpv.php' ); // removed since 2.9
require_once get_parent_theme_file_path( '/inc/post-view.php' ); // we use custom code to hook into and the html of the plugin
require_once get_parent_theme_file_path( '/inc/shortcodes.php' );
require_once get_parent_theme_file_path( '/inc/autoloadpost.php' );

// added since 3.0
require_once get_parent_theme_file_path( '/inc/hero.php' );

// depricated functions
require get_parent_theme_file_path( '/inc/depricated.php' );

// customizer
require get_parent_theme_file_path( '/inc/customizer/customizer.php' );
require get_parent_theme_file_path ( '/inc/customizer/register.php' );

/* One click import demo
 * @since 3.0
  */
if ( ! defined( 'PT_OCDI_PATH' ) ) {
    define( 'PT_OCDI_PATH', get_template_directory() . '/inc/demo-import/' );
    define( 'PT_OCDI_URL', get_template_directory_uri() . '/inc/demo-import/' );
}
add_filter( 'pt-ocdi/disable_pt_branding', '__return_true' );

require_once get_parent_theme_file_path( '/inc/demo-import/one-click-demo-import.php' );

// widgets
require get_parent_theme_file_path ( '/widgets/about/register.php' );
require get_parent_theme_file_path ( '/widgets/latest-posts/register.php' );
require get_parent_theme_file_path ( '/widgets/social/register.php' );
require get_parent_theme_file_path ( '/widgets/media/register.php' );
require get_parent_theme_file_path ( '/widgets/facebook/register.php' );
require get_parent_theme_file_path ( '/widgets/instagram/register.php' );
require get_parent_theme_file_path ( '/widgets/pinterest/register.php' );
require get_parent_theme_file_path ( '/widgets/ad/register.php' );
require get_parent_theme_file_path ( '/widgets/best-rated/register.php' );
require get_parent_theme_file_path ( '/widgets/authorlist/register.php' );

/* -------------------------------------------------------------------- */
/* CONTENT WIDTH 
/* -------------------------------------------------------------------- */
global $content_width;
if ( ! isset( $content_width ) ) {
	$content_width = absint(get_theme_mod('wi_content_width')) ? absint(get_theme_mod('wi_content_width')) : 1020;
}

/* -------------------------------------------------------------------- */
/* LAYOUT ARRAY
/* -------------------------------------------------------------------- */
if ( ! function_exists( 'wi_layout_array' ) ) {
function wi_layout_array() {
    $layout_arr = array(
        'standard'              =>  'Standard',
        'grid-2'                =>  'Grid 2 columns',
        'grid-3'                =>  'Grid 3 columns',
        'grid-4'                =>  'Grid 4 columns',
        'masonry-2'             =>  'Pinterest-like 2 columns',
        'masonry-3'             =>  'Pinterest-like 3 columns',
        'masonry-4'             =>  'Pinterest-like 4 columns',
        'newspaper'             =>  'Newspaper',
        'list'                  =>  'List',
    );
    
    return $layout_arr;
}
}

/* -------------------------------------------------------------------- */
/* BLOCK ARRAY
/* -------------------------------------------------------------------- */
if ( ! function_exists( 'wi_block_array' ) ) {
function wi_block_array() {
    $block_arr = array(
        'slider'                    =>  'Slider',
        'big-post'                  =>  'Big post',
        'grid-2'                    =>  'Grid 2 columns',
        'grid-3'                    =>  'Grid 3 columns',
        'grid-4'                    =>  'Grid 4 columns',
        
        'list'                      =>  'List style',
        'vertical'                  =>  'Post Vertical',
        'group-1'                   =>  'Post Group 1',
        'group-2'                   =>  'Post Group 2',
    );
    
    return $block_arr;
}
}

/* -------------------------------------------------------------------- */
/* SIDEBAR ARRAY
/* -------------------------------------------------------------------- */
if ( ! function_exists( 'wi_sidebar_array' ) ) {
function wi_sidebar_array() {
    return array(
        'sidebar-right'     =>  'Sidebar Right',
        'sidebar-left'      =>  'Sidebar Left',
        'no-sidebar'        =>  'No Sidebar',
    );
}
}

/* -------------------------------------------------------------------- */
/* RETURN LAYOUT
/* -------------------------------------------------------------------- */
if (!function_exists('wi_layout')){
function wi_layout(){
    
    if ( is_home() ) {
        $layout = get_theme_mod('wi_home_layout');
    } elseif ( is_category() ) {
        $this_cat = get_category(get_query_var('cat'), false);
        $term_meta = get_option( "taxonomy_$this_cat->term_id" );
        $layout = isset($term_meta['layout']) ? $term_meta['layout'] : '';
        if (!$layout) {
            $layout = get_theme_mod('wi_category_layout');
        }
    } elseif ( is_search() ) {
        $layout = get_theme_mod('wi_search_layout');
    } elseif ( is_day() || is_month() || is_year() ) {
        $layout = get_theme_mod('wi_archive_layout');
    } elseif ( is_tag() ) {
        $tag_id = get_queried_object()->term_id;
        $term_meta = get_option( "taxonomy_$tag_id" );
        $layout = isset($term_meta['layout']) ? $term_meta['layout'] : '';
        if (!$layout) {
            $layout = get_theme_mod('wi_tag_layout');
        }
    } elseif ( is_author() ) {
        $layout = get_theme_mod('wi_author_layout');
    } elseif ( is_404() ) {
        $layout = 'standard';
    } elseif ( is_single() ) {
        $layout = 'standard';
    } elseif ( is_page() && is_page_template('page-featured.php') ) {
        $layout = get_theme_mod('wi_all-featured_layout') ? get_theme_mod('wi_all-featured_layout') : '';
    } else {
        $layout = 'standard';
    }
    
    if (!$layout) $layout = '';
    
    if (!array_key_exists($layout,wi_layout_array())) $layout = 'standard';

    return apply_filters('wi_layout',$layout);
}
}

/* -------------------------------------------------------------------- */
/* SIDEBAR STATE
/* -------------------------------------------------------------------- */
if (!function_exists('wi_sidebar_state')){
function wi_sidebar_state(){
    $sidebar_state = '';
    if (is_page()) {
        if (
            is_page_template('page-fullwidth.php') || is_page_template('page-one-column.php')
        ) {
            $sidebar_state = 'no-sidebar';
        } else {
            $sidebar_state = get_post_meta( get_the_ID(), '_wi_sidebar_layout', true );
            if ( ! $sidebar_state ) $sidebar_state = get_theme_mod( 'wi_page_sidebar_state' );
        }
    } elseif (is_single()) {
        $sidebar_state = get_post_meta( get_the_ID(), '_wi_sidebar_layout', true );
        if ( ! $sidebar_state ) $sidebar_state = get_theme_mod('wi_single_sidebar_state');
    } elseif (is_home()) {
        $sidebar_state = get_theme_mod('wi_home_sidebar_state');
    } elseif (is_category()) {
        
        $t_id = get_queried_object_id();
        $term_meta = get_option( "taxonomy_$t_id" );
        $sidebar_state = isset($term_meta['sidebar_state']) ? $term_meta['sidebar_state'] : '';
        if ( ! $sidebar_state ) $sidebar_state = get_theme_mod('wi_category_sidebar_state');
    } elseif (is_tag()) {
        $sidebar_state = get_theme_mod('wi_tag_sidebar_state');
    } elseif (is_archive()) {
        $sidebar_state = get_theme_mod('wi_archive_sidebar_state');
    } elseif (is_search()) {
        $sidebar_state = get_theme_mod('wi_search_sidebar_state');
    } elseif (is_author()) {
        $sidebar_state = get_theme_mod('wi_author_sidebar_state');
    }
    
    $sidebar_state = apply_filters( 'wi_sidebar_state', $sidebar_state );
    
    if ($sidebar_state!='sidebar-left' && $sidebar_state!='no-sidebar') $sidebar_state = 'sidebar-right';
    return $sidebar_state;
}
}

/* -------------------------------------------------------------------- */
/* BODY CLASSES
/* -------------------------------------------------------------------- */
add_action('body_class','wi_body_class');
if (!function_exists('wi_body_class')){
function wi_body_class($classes){
    
    // one-column template fallback
    if ( is_page_template( 'page-one-column.php' ) ) {
    
        $classes[] = 'disable-2-columns';
        
    } elseif ( is_single() || is_page() ) {
        
        $column = wi_content_column();
        $column_class = ( $column == '1' ) ? 'disable-2-columns' : 'enable-2-columns';
        
        // for cool post
        if ( wi_is_cool_post() ) {
            $column_class = 'disable-2-columns';
        }
        
        $classes[] = $column_class;
    
    }
    
    // Sidebar
    $sidebar_state = wi_sidebar_state();
    if ($sidebar_state=='sidebar-right') {
        $classes[] = 'has-sidebar sidebar-right';
    } elseif ($sidebar_state=='sidebar-left') {
        $classes[] = 'has-sidebar sidebar-left';
    } else {
        $classes[] = 'no-sidebar';
    }
    
    // site border
    if ( 'true' === get_theme_mod( 'wi_site_border', 'false' ) ) {
        
        $classes[] = 'site-has-border';
        
    } else {
        
        $classes[] = 'site-no-border';
        
    }
    
    // hand-drawn lines
    if (get_theme_mod('wi_enable_hand_lines')) {
        $classes[] = 'enable-hand-lines';
    } else {
        $classes[] = 'disable-hand-lines';
    }
    
    // menu style
    if (get_theme_mod('wi_submenu_style') == 'dark') {
        $classes[] = 'submenu-dark';
    } else {
        $classes[] = 'submenu-light';
    }
    
    // dropcap style
    $dropcap_style = get_theme_mod( 'wi_dropcap_style' );
    if ( 'color' != $dropcap_style && 'dark' != $dropcap_style ) $dropcap_style = 'default';
    $classes[] = 'dropcap-style-' . $dropcap_style;
    
    // blockquote style
    $style = get_theme_mod( 'wi_blockquote_style' );
    if ( 'minimal' != $style && 'left-line' != $style ) $style = 'default';
    $classes[] = 'blockquote-style-' . $dropcap_style;
    
    // stretch level
    // @since 3.0
    $stretch_option = get_theme_mod( 'wi_cool_post_stretch', 'bit' );
    if ( 'full' !== $stretch_option ) $stretch_option = 'bit';
    $classes[] = 'coolpost-image-stretch-' . $stretch_option;
    
	return $classes;
}
}

/* -------------------------------------------------------------------- */
/* POST CLASS BECAUSE THIS APPLIES FOR INDIVIDUAL POSTS
/* -------------------------------------------------------------------- */
add_filter( 'post_class', 'wi_post_class' );
function wi_post_class( $classes ) {
    
    $dropcap = get_post_meta( get_the_ID(), '_wi_dropcap', true );
    if ( ! $dropcap ) $dropcap = ! get_theme_mod( 'wi_disable_blog_dropcap' );
    if ( 'true' == $dropcap ) { $dropcap = true; }
    elseif ( 'false' == $dropcap ) { $dropcap = false; }
    
    if ( $dropcap ) $classes[] = 'enable-dropcap';
    else $classes[] = 'disable-dropcap';
    
    return $classes;
    
}

/* -------------------------------------------------------------------- */
/* SETUP
/* -------------------------------------------------------------------- */
if ( ! function_exists( 'wi_setup' ) ) :
function wi_setup() {
    
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
endif; // wi_setup
add_action( 'after_setup_theme', 'wi_setup' );

/* -------------------------------------------------------------------- */
/* WIDGETS
/* -------------------------------------------------------------------- */
if (!function_exists('wi_widgets_init')) {
function wi_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Sidebar', 'wi' ),
		'id'            => 'sidebar',
		'description'   => __('Add widgets here to appear in your sidebar.', 'wi' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h3 class="widget-title"><span>',
		'after_title'   => '</span></h3>',
	) );
    
    register_sidebar( array(
		'name'          => __( 'Page Sidebar', 'wi' ),
		'id'            => 'page-sidebar',
		'description'   => __('Add widgets here to appear in your page\'s sidebar.', 'wi' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h3 class="widget-title"><span>',
		'after_title'   => '</span></h3>',
	) );
    
    register_sidebar( array(
		'name'          => __( 'Header Area', 'wi' ),
		'id'            => 'header',
		'description'   => __('Add widgets here to appear at the header of your site.', 'wi' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h3 class="widget-title"><span>',
		'after_title'   => '</span></h3>',
	) );
    
    for ($i=1; $i<=4; $i++) {
    register_sidebar( array(
		'name'          => sprintf(__( 'Footer %s', 'wi' ), $i),
		'id'            => 'footer-'.$i,
		'description'   => __('Add widgets here to appear in your footer sidebar.', 'wi' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h3 class="widget-title"><span>',
		'after_title'   => '</span></h3>',
	) );
    }
    
}
}
add_action( 'widgets_init', 'wi_widgets_init' );

/**
 * Add preconnect for Google Fonts.
 *
 * @since 2.8
 *
 * @param array  $urls           URLs to print for resource hints.
 * @param string $relation_type  The relation type the URLs are printed.
 * @return array $urls           URLs to print for resource hints.
 */
function wi_resource_hints( $urls, $relation_type ) {
	if ( wp_style_is( 'wi-fonts', 'queue' ) && 'preconnect' === $relation_type ) {
		$urls[] = array(
			'href' => 'https://fonts.gstatic.com',
			'crossorigin',
		);
	}

	return $urls;
}
add_filter( 'wp_resource_hints', 'wi_resource_hints', 10, 2 );

/* -------------------------------------------------------------------- */
/* FONTs
 *
 * @since 1.0
 * @modified in 2.3
 *
/* -------------------------------------------------------------------- */
if ( ! function_exists( 'wi_fonts' ) ) :
function wi_fonts() {
    
    $types = array('body','heading','nav');
    $previous_fonts = array();
    
    $default_fonts = array(
        'body'          =>  'Merriweather',
        'heading'       =>  'Oswald',
        'nav'           =>  'Oswald',
    );
    
    $fonts_url = '';
    $google_fonts = fox_google_fonts();    
    $subsets = array();
    
    $faces = array();
    $fonts = array();
    
    foreach ($types as $type) {
        
        // custom font
        if (trim(get_theme_mod('wi_'.$type.'_custom_font'))!='') continue;
        
        // get current font
        $current_font = get_theme_mod('wi_'.$type.'_font');
        if ( ! $current_font ) $current_font = $default_fonts[$type];
        
        // not a Google font
        if ( ! isset( $google_fonts[ $current_font ] ) )
            continue;
        
        $faces[] = $current_font;
        
    }
    
    // font data
    foreach ( $faces as $face ) {
    
        $fontData = $google_fonts[ $face ];
        $face = str_replace( ' ', '+', $face );
        $styles = $fontData[ 'styles' ];
        $styles = join( ',', $styles );
        $fonts[] = "{$face}:{$styles}";
        $subsets += $fontData[ 'subsets' ];
        
    }
    
    // remove duplicated elements
    $fonts = array_unique( $fonts );
    $subsets = array_unique( $subsets );

	if ( $fonts ) {
		$fonts_url = add_query_arg( array(
			'family' => implode( '|', $fonts ),
			'subset' => join( ',', $subsets ),
		), 'https://fonts.googleapis.com/css' );
	}
    
    return $fonts_url;
    
}
endif;

/**
 * Handles JavaScript detection.
 *
 * Adds a `js` class to the root `<html>` element when JavaScript is detected.
 *
 * @since 2.8
 */
function wi_javascript_detection() {
	echo "<script>(function(html){html.className = html.className.replace(/\bno-js\b/,'js')})(document.documentElement);</script>\n";
}
add_action( 'wp_head', 'wi_javascript_detection', 0 );

/**
 * Add a pingback url auto-discovery header for singularly identifiable articles.
 * @since 2.8
 */
function wi_pingback_header() {
	if ( is_singular() && pings_open() ) {
		printf( '<link rel="pingback" href="%s">' . "\n", get_bloginfo( 'pingback_url' ) );
	}
}
add_action( 'wp_head', 'wi_pingback_header' );

/* -------------------------------------------------------------------- */
/* ENQUEUE SCRIPTS
/* -------------------------------------------------------------------- */
function wi_scripts() {
    
    // loads google fonts
    wp_enqueue_style( 'wi-fonts', wi_fonts(), array(), null );

	// awesome font
	wp_enqueue_style( 'font-awesome', get_theme_file_uri( '/css/font-awesome-4.7.0/css/font-awesome.min.css' ), array(), '4.7' );

    // Load our main stylesheet.
    if ( is_child_theme() || ( defined('WP_DEBUG') && true === WP_DEBUG ) ) {
	   wp_enqueue_style( 'style', get_stylesheet_uri() );
    } else {
        wp_enqueue_style( 'style', get_theme_file_uri( 'style.min.css' ) );
    }
    
    if ( withemes_woocommerce_installed() ) {
        wp_enqueue_style( 'woocommerce', get_theme_file_uri( '/css/woocommerce.css' ) );
    }
    
    // Responsive
    // deprecated since 2.9
    // we merged it with style.css
	// wp_enqueue_style( 'wi-responsive', get_theme_file_uri( '/css/responsive.css' ) );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
    
    // facebook
    wp_register_script( 'wi-facebook', 'https://connect.facebook.net/en_US/all.js#xfbml=1', false, '1.0', true );
    
    // main
    if ( defined('WP_DEBUG') && true === WP_DEBUG ) {
        
        wp_enqueue_script( 'imagesloaded', get_theme_file_uri( '/js/imagesloaded.pkgd.min.js' ), array( 'jquery' ), '3.1.8' , true );
        wp_enqueue_script( 'colorbox', get_theme_file_uri( '/js/jquery.colorbox-min.js' ), array( 'jquery' ), '1.6.0' , true );
        wp_enqueue_script( 'easing', get_theme_file_uri( '/js/jquery.easing.1.3.js' ), array( 'jquery' ), '1.3' , true );
        wp_enqueue_script( 'fitvids', get_theme_file_uri( '/js/jquery.fitvids.js' ), array( 'jquery' ), '1.0' , true );
        wp_enqueue_script( 'flexslider', get_theme_file_uri( '/js/jquery.flexslider-min.js' ), array( 'jquery' ), '1.0' , true );
        wp_enqueue_script( 'inview', get_theme_file_uri( '/js/jquery.inview.min.js' ), array( 'jquery' ), '1.0' , true );
        wp_enqueue_script( 'retina', get_theme_file_uri( '/js/jquery.retina.min.js' ), array( 'jquery' ), '1.0' , true );
        wp_enqueue_script( 'masonry', get_theme_file_uri( '/js/masonry.pkgd.min.js' ), array( 'jquery' ), '3.2.2' , true );
        wp_enqueue_script( 'matchMedia', get_theme_file_uri( '/js/matchMedia.js' ), array( 'jquery' ), '1.0' , true );
        wp_enqueue_script( 'slick', get_theme_file_uri( '/js/slick.min.js' ), array( 'jquery' ), '1.4.1' , true );
        wp_enqueue_script( 'theia-sticky-sidebar', get_theme_file_uri( '/js/theia-sticky-sidebar.js' ), array( 'jquery' ), '1.3.1' , true );
        
        wp_enqueue_script( 'wi-main', get_theme_file_uri( '/js/main.js' ), array( 'jquery' ), FOX_VERSION , true );
        
    } else {
        
        wp_enqueue_script( 'wi-main', get_theme_file_uri( '/js/theme.min.js' ), array( 'jquery' ), FOX_VERSION , true );
        
    }
    
    // Create a filter to add global JS data to <head />
    // @since Fox 2.2
    $jsdata = array( 
        'l10n' => array( 
            'prev' => esc_html__( 'Previous', 'wi' ), 
            'next' => esc_html__( 'Next', 'wi' ),
        ),
        'enable_sticky_sidebar'=> get_theme_mod( 'wi_sticky_sidebar' ),
        
        // @since 2.8
        'enable_sticky_header' => ! get_theme_mod( 'wi_disable_header_sticky' ),
        
        'ajaxurl' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce( 'nav_mega_nonce' ),
    );
    
    if ( is_single() && wi_autoload() && !is_customize_preview() ) {
        
        wp_enqueue_script( 'scrollspy', get_theme_file_uri( '/js/scrollspy.js' ), array('jquery'), null, true );
        wp_enqueue_script( 'autoloadpost', get_theme_file_uri( '/js/autoloadpost.js' ), array('jquery', 'scrollspy'), null, true );
        wp_enqueue_script( 'history', get_theme_file_uri( '/js/jquery.history.js' ), array('jquery'), null, true );
        $jsdata[ 'enable_autoload' ] = true;
        
    }
    
    $jsdata = apply_filters( 'jsdata', $jsdata );
	wp_localize_script( 'wi-main', 'WITHEMES', $jsdata );
    
}
add_action( 'wp_enqueue_scripts', 'wi_scripts' );


/* -------------------------------------------------------------------- */
/* PRIMARY MENU
/* -------------------------------------------------------------------- */
add_filter( 'nav_menu_css_class', 'wi_nav_menu_css_class', 10, 4 );
if ( !function_exists( 'wi_nav_menu_css_class' ) ) :
/**
 * Mega Menu
 *
 * @since 1.0
 */
function wi_nav_menu_css_class( $classes, $item, $args, $depth ) {

    if ( ! $depth && get_post_meta( $item->ID, 'menu-item-mega', true ) && 'primary' === $args->theme_location ) {

        $classes[] = 'mega';

    }

    return $classes;

}
endif;

add_filter( 'nav_menu_item_title', 'wi_nav_menu_item_title', 10, 4 );
if ( !function_exists( 'wi_nav_menu_item_title' ) ) :
/**
 * Mega Menu
 *
 * @since 1.0
 */
function wi_nav_menu_item_title( $title, $item, $args, $depth ) {

    if ( ( $icon = get_post_meta( $item->ID, 'menu-item-menu-icon', true ) ) && 'primary' === $args->theme_location ) {

        $title = '<i class="fa fa-' . esc_attr( $icon ) . '"></i>' . $title;

    }

    return $title;

}
endif;

/* -------------------------------------------------------------------- */
/* CONTACT METHODs
/* -------------------------------------------------------------------- */
if (!function_exists('wi_contactmethods')){
function wi_contactmethods( $contactmethods ) {

	$contactmethods['twitter']   = __('Twitter URL','wi');
	$contactmethods['facebook-square']  = __('Facebook URL','wi');
	$contactmethods['google-plus']    = __('Google+ URL','wi');
	$contactmethods['tumblr']    = __('Tumblr URL','wi');
	$contactmethods['instagram'] = __('Instagram URL','wi');
	$contactmethods['pinterest-p'] = __('Pinterest URL','wi');
    $contactmethods['linkedin'] = __('LinkedIn URL','wi');
    $contactmethods['youtube'] = __('YouTube URL','wi');
    $contactmethods['vimeo-square'] = __('Vimeo URL','wi');
    $contactmethods['soundcloud'] = __('Soundcloud URL','wi');
    $contactmethods['flickr'] = __('Flickr URL','wi');
    $contactmethods['vk'] = __('VKontakte','wi');

	return $contactmethods;
}
}
add_filter('user_contactmethods','wi_contactmethods');

/* -------------------------------------------------------------------- */
/* SOCIAL ARRAY
/* -------------------------------------------------------------------- */
if (!function_exists('wi_social_array')){
function wi_social_array() {
    return array(
		'facebook-square'      =>	__('Facebook','wi'),
		'twitter'              =>	__('Twitter','wi'),
		'google-plus'          =>	__('Google+','wi'),
		'linkedin'             =>	__('LinkedIn','wi'),
        'snapchat'               =>	__('Snapchat','wi'),
		'tumblr'               =>	__('Tumblr','wi'),
		'pinterest'            =>	__('Pinterest','wi'),
		'youtube'              =>	__('YouTube','wi'),
		'skype'                       =>	__('Skype','wi'),
		'instagram'                   =>	__('Instagram','wi'),
		'delicious'                   =>	__('Delicious','wi'),
		'digg'                        =>	__('Digg','wi'),
		'reddit'               =>	__('Reddit','wi'),
		'stumbleupon'          =>	__('StumbleUpon','wi'),
        'medium'                      =>	__('Medium','wi'),
		'vimeo-square'                =>	__('Vimeo','wi'),
		'yahoo'                       =>	__('Yahoo!','wi'),
		'flickr'                      =>	__('Flickr','wi'),
		'deviantart'                  =>	__('DeviantArt','wi'),
		'github'               =>	__('GitHub','wi'),
		'stack-overflow'              =>	__('StackOverFlow','wi'),
        'stack-exchange'              =>	__('Stack Exchange','wi'),
        'bitbucket'            =>	__('Bitbucket','wi'),
		'xing'                 =>	__('Xing','wi'),
		'foursquare'                  =>	__('Foursquare','wi'),
		'paypal'                      =>	__('Paypal','wi'),
		'yelp'                        =>	__('Yelp','wi'),
		'soundcloud'                  =>	__('SoundCloud','wi'),
		'lastfm'               =>	__('Last.fm','wi'),
        'spotify'                     =>	__('Spotify','wi'),
        'slideshare'                  =>	__('Slideshare','wi'),
		'dribbble'                    =>	__('Dribbble','wi'),
		'steam'                =>	__('Steam','wi'),
		'behance'              =>	__('Behance','wi'),
        'whatsapp'              => __('WhatsApp','wi'),
		'weibo'                       =>	__('Weibo','wi'),
        'telegram'                      => __('Telegram','wi'),
		'trello'                      =>	__('Trello','wi'),
		'vk'                          =>	__('VKontakte','wi'),
		'home'                        =>	__('Homepage','wi'),
		'envelope'             =>	__('Email','wi'),
        '500px'             =>	__('500px','wi'),
		'rss'                 =>	__('Feed','wi'),
	);
}
}

if (!function_exists('wi_social_list')){
    function wi_social_list($search = false){
        $social_array = wi_social_array();
        foreach ( $social_array as $k => $v){
            if ( get_theme_mod('wi_social_'.$k) ){
if ( 'facebook-square' == $k ) {
    $i = 'facebook';
} else {
    $i = $k;
}
?>
                <li class="li-<?php echo str_replace('','',$k);?>"><a href="<?php echo esc_url(get_theme_mod('wi_social_'.$k));?>" target="_blank" rel="alternate" title="<?php echo esc_attr($v);?>"><i class="fa fa-<?php echo esc_attr($i);?>"></i> <span><?php echo esc_html($v);?></span></a></li>
            <?php }
        }?>
        <?php if ($search){ ?>
        <li class="li-search"><a><i class="fa fa-search"></i> <span>Search</span></a></li>
        <?php }
    }
}

/* -------------------------------------------------------------------- */
/* FEATURED CLASS
/* -------------------------------------------------------------------- */
add_filter('post_class','wi_post_featured_class');
if (!function_exists('wi_post_featured_class')){
function wi_post_featured_class( $classes ) {
	if (get_post_meta(get_the_ID(),'_is_featured',true) == 'yes'):
        $classes[] = 'post-featured';
    endif;
    return $classes;
}
}
add_filter( 'the_content_more_link', 'wi_remove_more_link_scroll' );

/* -------------------------------------------------------------------- */
/* PREVENT PAGE MORE LINK SCROLL
/* -------------------------------------------------------------------- */
if (!function_exists('wi_remove_more_link_scroll')){
function wi_remove_more_link_scroll( $link ) {
	$link = preg_replace( '|#more-[0-9]+|', '', $link );
	return $link;
}
}
add_filter( 'the_content_more_link', 'wi_remove_more_link_scroll' );

/* -------------------------------------------------------------------- */
/* EXCLUDE PAGES FROM SEARCH
/* -------------------------------------------------------------------- */
if (!function_exists('wi_search_filter')) {
function wi_search_filter($query) {
    if (get_theme_mod('wi_exclude_pages_from_search')){
        if ( $query->is_search && is_search() ) {
            $query->set('post_type', 'post');
        }
    }
    return $query;
    }
}
add_filter( 'pre_get_posts','wi_search_filter' );

/* -------------------------------------------------------------------- */
/* IGNORE STICKY POSTS
/* -------------------------------------------------------------------- */
if (!function_exists('wi_ignore_sticky')) {
function wi_ignore_sticky($query) {
    
    if ( is_home() && $query->is_main_query())  {
        
        $query->set('ignore_sticky_posts', true);  
        $query->set('post__not_in', get_option('sticky_posts'));
        
    }
    
    return $query;
}
}
add_filter('pre_get_posts','wi_ignore_sticky');

/* -------------------------------------------------------------------- */
/* BACK TO TOP
/* -------------------------------------------------------------------- */
add_action('wp_footer','wi_backtotop');
if ( !function_exists('wi_backtotop') ) {
function wi_backtotop() {
    if (!get_theme_mod('wi_disable_backtotop')){
    ?>
    <div id="backtotop" class="backtotop">
        <span class="go"><?php _e('Go to','wi');?></span>
        <span class="top"><?php _e('Top','wi');?></span>
    </div><!-- #backtotop -->
<?php 
    } // endif
}   
}

/* -------------------------------------------------------------------- */
/* EXCERPT
/* -------------------------------------------------------------------- */
/* Remove the ugly bracket [...] in the excerpt */
add_filter('excerpt_more','wi_remove_bracket_in_excerpt');
if ( !function_exists('wi_remove_bracket_in_excerpt') ) {
function wi_remove_bracket_in_excerpt($excerpt){
	return '&hellip;';
}
}
	/* More length */
if ( !function_exists('wi_custom_excerpt_length') ) {
function wi_custom_excerpt_length( $length ) {
	$excerpt_length = absint(get_theme_mod('wi_excerpt_length')) ? absint(get_theme_mod('wi_excerpt_length')) : 55;
    return $excerpt_length;
}
}
add_filter( 'excerpt_length', 'wi_custom_excerpt_length', 999 );

/* -------------------------------------------------------------------- */
/* HEADER FOOTER CODE
/* -------------------------------------------------------------------- */
/* Header Code */
add_action('wp_head','wi_add_head_code');
if ( !function_exists('wi_add_head_code') ) {
function wi_add_head_code(){
	echo get_theme_mod('wi_header_code');
}
}

/* -------------------------------------------------------------------- */
/* SUBWORD
/* -------------------------------------------------------------------- */
if ( !function_exists('wi_subword') ) {
function wi_subword($str = '',$int = 0, $length = NULL){
	if (!$str) return;
	$words = explode(" ",$str); if (!is_array($words)) return;
	$return = array_slice($words,$int,$length); if (!is_array($return)) return;
	return implode(" ",$return);
}
}

/* -------------------------------------------------------------------- */
/* QUICK TRANSLATION
/* -------------------------------------------------------------------- */
add_filter('gettext','wi_quick_translate',20,3);
if (!function_exists('wi_quick_translate')){
function wi_quick_translate($string,$text,$domain) {
    
    $options = array(
            'more_link'             =>  'Keep Reading',
            'previous'               =>  'Previous',
            'next'                  =>  'Next',
            'next_story'            =>  'Next Story',
            'previous_story'        =>  'Previous Story',
            'search'                =>  'Search...',
            'category'              =>  'in',
            'author'                =>  'by %s',
            'date'                  =>  'Published on',
            'latest_posts'          =>  'Latest posts',
            'viewall'                   =>  'View all',
            'related'               =>  'You might be interested in',
            'latest'                   =>  'Latest from %s',
            'go'                    =>  'Go to',
            'top'                   =>  'Top',
        );
    
    foreach ($options as $k => $v) {
        if ($string==$v && get_theme_mod('wi_translate_'.$k)!='') $string = get_theme_mod('wi_translate_'.$k);
    }
    
    return $string;
    
}
}

/* -------------------------------------------------------------------- */
/* FONT SIZE MECHANISM
/* -------------------------------------------------------------------- */
if (!function_exists('wi_font_size_array')) {
function wi_font_size_array() {
    $size_arr = array();
    
    $size_arr['body'] = array(
        'prop'      =>  'body',
        'std'       =>  16,
        'ipad1'     =>  1,
        'ipad2'     =>  1,
        'iphone1'   =>  .875,
        'iphone2'   =>  .875,
    );
    
    $size_arr['nav'] = array(
        'prop'      =>  '#wi-mainnav .menu > ul > li > a, .header-social ul li a, .offcanvas-nav .menu > ul > li > a',
        'std'       =>  26,
        'ipad1'     =>  1,
        'ipad2'     =>  .75,
        'iphone1'   =>  .75,
        'iphone2'   =>  .75,
    );
    
    $size_arr['nav-sub'] = array(
        'prop'      =>  '#wi-mainnav .menu > ul > li > ul > li > a',
        'std'       =>  16,
        'ipad1'     =>  1,
        'ipad2'     =>  1,
        'iphone1'   =>  1,
        'iphone2'   =>  1,
    );
    
    $size_arr['section-heading'] = array(
        'prop'      =>  '.section-heading',
        'std'       =>  80,
        'ipad1'     =>  1,
        'ipad2'     =>  .7,
        'iphone1'   =>  .5,
        'iphone2'   =>  .325,
    );
    
    $size_arr['slider-title'] = array(
        'prop'      =>  '.slider-title',
        'std'       =>  60,
        'ipad1'     =>  1,
        'ipad2'     =>  .8,
        'iphone1'   =>  .6,
        'iphone2'   =>  .5,
    );
    
    $size_arr['big-title'] = array(
        'prop'      =>  '.big-title',
        'std'       =>  16,
        'ipad1'     =>  1,
        'ipad2'     =>  .8,
        'iphone1'   =>  .5,
        'iphone2'   =>  .4,
    );
    
    $size_arr['post-title'] = array(
        'prop'      =>  '.post-title',
        'std'       =>  52,
        'ipad1'     =>  1,
        'ipad2'     =>  1,
        'iphone1'   =>  .6,
        'iphone2'   =>  .46,
    );
    
    $size_arr['grid-title'] = array(
        'prop'      =>  '.grid-title',
        'std'       =>  26,
        'ipad1'     =>  1,
        'ipad2'     =>  1,
        'iphone1'   =>  1,
        'iphone2'   =>  .92,
    );
    
    $size_arr['masonry-title'] = array(
        'prop'      =>  '.masonry-title',
        'std'       =>  32,
        'ipad1'     =>  1,
        'ipad2'     =>  1,
        'iphone1'   =>  1,
        'iphone2'   =>  .75,
    );
    
    $size_arr['newspaper-title'] = array(
        'prop'      =>  '.newspaper-title',
        'std'       =>  36,
        'ipad1'     =>  1,
        'ipad2'     =>  1,
        'iphone1'   =>  1,
        'iphone2'   =>  .666,
    );
    
    $size_arr['list-title'] = array(
        'prop'      =>  '.list-title',
        'std'       =>  36,
        'ipad1'     =>  1,
        'ipad2'     =>  1,
        'iphone1'   =>  .611,
        'iphone2'   =>  .611,
    );
    
    $size_arr['page-title'] = array(
        'prop'      =>  '.page-title',
        'std'       =>  70,
        'ipad1'     =>  1,
        'ipad2'     =>  1,
        'iphone1'   =>  .6,
        'iphone2'   =>  .6,
    );
    
    $size_arr['archive-title'] = array(
        'prop'      =>  '.archive-title',
        'std'       =>  80,
        'ipad1'     =>  1,
        'ipad2'     =>  1,
        'iphone1'   =>  .6,
        'iphone2'   =>  .4,
    );
    
    $size_arr['widget-title'] = array(
        'prop'      =>  '.widget-title',
        'std'       =>  12,
        'ipad1'     =>  1,
        'ipad2'     =>  1,
        'iphone1'   =>  1,
        'iphone2'   =>  1,
    );
    
    $size_arr['h1'] = array(
        'prop'      =>  'h1',
        'std'       =>  40,
        'ipad1'     =>  1,
        'ipad2'     =>  1,
        'iphone1'   =>  .7,
        'iphone2'   =>  .7,
    );
    
    $size_arr['h2'] = array(
        'prop'      =>  'h2',
        'std'       =>  32,
        'ipad1'     =>  1,
        'ipad2'     =>  1,
        'iphone1'   =>  .7,
        'iphone2'   =>  .7,
    );
    
    $size_arr['h3'] = array(
        'prop'      =>  'h3',
        'std'       =>  26,
        'ipad1'     =>  1,
        'ipad2'     =>  1,
        'iphone1'   =>  .7,
        'iphone2'   =>  .7,
    );
    
    $size_arr['h4'] = array(
        'prop'      =>  'h4',
        'std'       =>  22,
        'ipad1'     =>  1,
        'ipad2'     =>  1,
        'iphone1'   =>  .7,
        'iphone2'   =>  .7,
    );
    
    $size_arr['h5'] = array(
        'prop'      =>  'h5',
        'std'       =>  18,
        'ipad1'     =>  1,
        'ipad2'     =>  1,
        'iphone1'   =>  .7,
        'iphone2'   =>  .7,
    );
    
    $size_arr['h6'] = array(
        'prop'      =>  'h6',
        'std'       =>  14,
        'ipad1'     =>  1,
        'ipad2'     =>  1,
        'iphone1'   =>  .7,
        'iphone2'   =>  .7,
    );
    
    return $size_arr;
    
}
}
?>
<?php
add_action('wp_head','wi_facebook_share_picture');
if (!function_exists('wi_facebook_share_picture')) {
function wi_facebook_share_picture(){
    if (is_singular()) {
        global $post;
        if (has_post_thumbnail()) {
            $thumbnail = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID),'full');
?>
<meta property="og:image" content="<?php echo esc_url($thumbnail[0]);?>"/>
<meta property="og:image:secure_url" content="<?php echo esc_url($thumbnail[0]);?>" />
<?php }
    }
}
}

/* -------------------------------------------------------------------- */
/* CUSTOM NUMBER OF POSTS TO DISPLAY ON HOMEPAGE (NOT ARCHIVE)
/* -------------------------------------------------------------------- */
if ( !function_exists( 'wi_limit_posts_per_page' ) ) :
function wi_limit_posts_per_page(&$query) {
    
    $number = trim( get_theme_mod( 'wi_home_number' ) );
    
    if ( ! empty( $number) && !is_admin() && $query->is_main_query() && is_home() ) {
        $query->set( 'posts_per_page', $number );
    }
}
endif;
add_action('pre_get_posts', 'wi_limit_posts_per_page');

if ( ! function_exists( 'wi_pre_get_posts' ) ) :
/**
 * Advanced Query Options
 *
 * Offset and Exclude Categories
 * 
 * @since 2.3
 */
function wi_pre_get_posts( $query ) {
    
    if ( ! is_admin() && $query->is_home() && $query->is_main_query() ) {
        
        // Exclude Categories
        $exclude_categories = get_theme_mod( 'wi_exclude_categories' );
        if ( is_string( $exclude_categories ) ) $exclude_categories = explode( ',', trim($exclude_categories) );
        if ( ! empty($exclude_categories) ) {
            $query->set( 'category__not_in', $exclude_categories );
        }
        
        // Offset should be available when infinite scroll module not enabled
        $offset = absint( get_theme_mod( 'wi_offset' ) );
        if ( $offset > 0 ) {

            $home_ppp = trim( get_theme_mod( 'wi_home_number' ) );
    
            if ( ! empty( $home_ppp) ) $ppp = $home_ppp;
            else $ppp = get_option( 'posts_per_page' );

            // Detect and handle pagination...
            if ( $query->is_paged ) {

                //Manually determine page query offset (offset + current page (minus one) x posts per page)
                $page_offset = $offset + ( ($query->query_vars['paged']-1) * $ppp );

                //Apply adjust page offset
                $query->set('offset', $page_offset );

            } else {

                //This is the first page. Just use the offset...
                $query->set('offset',$offset);

            }

        }
        
	}
    
}
endif;

add_action( 'pre_get_posts', 'wi_pre_get_posts', 300 );

if ( ! function_exists( 'wi_adjust_offset_pagination' ) ) :
/**
 * Adjusts offset pagination
 *
 * @since 2.3
 */
function wi_adjust_offset_pagination($found_posts, $query) {
    
    // Offset should be available when infinite scroll module not enabled
    $offset = absint( get_theme_mod( 'wi_offset' ) );
    if ( $offset > 0 && $query->is_home() && $query->is_main_query() && ! is_admin() ) {

        //Reduce WordPress's found_posts count by the offset... 
        return $found_posts - $offset;

    }
    
    return $found_posts;
    
}
endif;

add_filter( 'found_posts', 'wi_adjust_offset_pagination', 1, 2 );

// Reduce amount of meta value saved to database
// @since 2.4
add_filter( 'baw_count_views_timings', 'wi_baw_count_views_timings' );
function wi_baw_count_views_timings( $timings ) {
    return array( 'all'=>'', 'month'=>'Ym', 'year'=>'Y', 'week' => 'YW' );
}

// Delete all day/week meta keys to save db sizes
// Since 2.4
// Please remove below comment if you wish to delete all day & week meta views
//
// add_action( 'admin_init', 'wi_delete_date_view_keys' );
function wi_delete_date_view_keys() {
    
    if ( get_option( 'wi_delete_date_view_keys' ) ) return;

    $all_posts = new WP_Query( array(
        'posts_per_page' => -1,
        'post_type' => 'any',
    ) );
    
    $done = false;
    
    global $post;
    
    if ( $all_posts->have_posts() ) : while ( $all_posts->have_posts() ) : $all_posts->the_post();
    
        global $wpdb, $timings;
        $wpdb->query( 'DELETE FROM ' . $wpdb->postmeta . ' WHERE post_id = ' . (int)$post->ID . ' AND meta_key LIKE "_count-views_day%"' );
        $wpdb->query( 'DELETE FROM ' . $wpdb->postmeta . ' WHERE post_id = ' . (int)$post->ID . ' AND meta_key LIKE "_count-views_week%"' );
    
    endwhile;
    endif;
    
    wp_reset_query();
    
    if ( ! update_option( 'wi_delete_date_view_keys', true ) ) add_option( 'wi_delete_date_view_keys', true );

}

/**
 * Post Format Link
 *
 * @since 2.4
 */
add_filter( 'post_link', 'wi_post_format_link', 10, 3 );
function wi_post_format_link( $url, $post, $leavename=false ) {
    
    if ( get_post_format( $post ) == 'link' ) {
        $source = trim( get_post_meta( $post->ID, '_format_link_url', true ) );
        if ( $source ) return esc_url( $source );
	}
	return $url;

}

if ( ! function_exists( 'wi_single_ad' ) ) :
/**
 * Single Ad
 *
 * @since 2.5
 */
function wi_single_ad( $pos = 'before' ) {

    if ( 'after' != $pos ) $pos = 'before';
    $code = trim( get_theme_mod( 'wi_single_' . $pos . '_code' ) );
    if ( $code ) { ?>
    <div class="single-ad ad-code ad-<?php echo esc_attr( $pos ); ?>">
        <?php echo do_shortcode( $code ); ?>
    </div><!-- .single-ad -->
<?php } elseif ( $banner = get_theme_mod( 'wi_single_' . $pos . '_banner' ) ) {
        $url = trim( get_theme_mod( 'wi_single_' . $pos . '_banner_url' ) );
    if ( $url ) {
        $open = '<a href="' . esc_url( $url ) . '" target="_blank">';
        $close = '</a>';
    } else {
        $open = $close = '';
    }
?>
    
    <div class="single-ad ad-code ad-<?php echo esc_attr( $pos ); ?>">
        <?php echo $open; ?>
        <img src="<?php echo esc_url( $banner ); ?>" alt="<?php echo esc_html__( 'Banner', 'wi' ); ?>" />
        <?php echo $close; ?>
    </div>
<?php
    }
}
endif;

add_action( 'wp_footer', 'wi_single_sidedock' );
/**
 * Single Side Dock Post
 *
 * @since 2.5
 */
function wi_single_sidedock() {

    if ( get_theme_mod( 'wi_disable_side_dock' ) || ! is_single() || wi_autoload() ) return;
    
    $related_posts = wi_related_query( 2 );
    if ( $related_posts && $related_posts->have_posts() ) :
    
    ?>

<aside id="content-dock">
    
    <h3 class="dock-title"><?php _e('You might be interested in','wi');?></h3>
    
    <div class="dock-posts">
        
        <?php while ( $related_posts->have_posts() ): $related_posts->the_post(); ?>

        <article id="post-<?php the_ID(); ?>" <?php post_class('post-dock'); ?> itemscope itemtype="http://schema.org/CreativeWork">
            
            <div class="post-inner">

                <?php wi_display_thumbnail('thumbnail','post-dock-thumbnail',true,true);?>

                <section class="post-dock-body">

                    <div class="post-dock-content">

                        <header class="post-dock-header">

                            <h3 class="post-dock-title" itemprop="headline">
                                <a href="<?php the_permalink();?>" rel="bookmark"><?php the_title();?></a>
                            </h3>

                        </header><!-- .post-dock-header -->
                        
                        <div class="post-dock-excerpt" itemprop="text">
                            <p><?php echo wi_subword(get_the_excerpt(),0,10); ?></p>
                        </div><!-- .post-dock-excerpt -->

                        <div class="clearfix"></div>

                    </div><!-- .post-dock-content -->

                </section><!-- .post-dock-body -->

                <div class="clearfix"></div>

            </div><!-- .post -->
            
        </article><!-- .post-dock -->
    
    <?php endwhile; ?>
        
    </div><!-- .dock-posts -->

    <button class="close">
        <i class="fa fa-close"></i>
    </button>

</aside><!-- #content-dock -->
    
<?php
    
    endif; // have posts
    
    wp_reset_query();
    
}

/**
 * HTML allowed to use in copyright
 */
function wi_allowed_html() {

    $return = array(
        'a' => array(
            'href' => array(),
            'title' => array(),
            'target' => array(),
            'class' => array(),
            'onclick' => array(),
            'rel' => array(),
            'nofollow' => array(),
        ),
        'br' => array(),
        'em' => array(
            'class' => array(),
            'title' => array(),
        ),
        'strong' => array(
            'class' => array(),
            'title' => array(),
        ),
        'span' => array(
            'class' => array(),
            'title' => array(),
        ),
        'i' => array(
            'class' => array(),
            'title' => array(),
        ),
        'b' => array(
            'class' => array(),
            'title' => array(),
        ),
        'hr' => array(
            'class' => array(),
            'title' => array(),
        ),
        'ul' => array(
            'class' => array(),
            'title' => array(),
        ),
        'ol' => array(
            'class' => array(),
            'title' => array(),
        ),
        'li' => array(
            'class' => array(),
            'title' => array(),
        ),
        'img' => array(
            'src' => array(),
            'title' => array(),
            'class' => array(),
            'width' => array(),
            'height' => array(),
        ),
    );
    return apply_filters( 'fox_allowed_html', $return );
    
}

if ( ! function_exists( 'wi_get_instagram_photos' ) ) :
/**
 * retrieve instagram photos
 *
 * @since 2.8
 */
function wi_get_instagram_photos( $username, $number, $cache_time ) {

    /**
     * Get Instagram Photos
     *
     * @Scott Evans
     */
    $username = trim( strtolower( $username ) );
    $number = absint( $number );
    $cache_time = absint( $cache_time );

    if ( ! $username ) return;

    if ( $number < 1 || $number > 12 ) $number = 6;

    if ( false === ( $instagram = get_transient( 'wi-instagram-' . sanitize_title_with_dashes( $username . '-' . $number ) ) ) ) {

        switch ( substr( $username, 0, 1 ) ) {
			case '#':
				$url              = 'https://instagram.com/explore/tags/' . str_replace( '#', '', $username );
				$transient_prefix = 'h';
				break;

			default:
				$url              = 'https://instagram.com/' . str_replace( '@', '', $username );
				$transient_prefix = 'u';
				break;
		}

		if ( false === ( $instagram = get_transient( 'insta-a10-' . $transient_prefix . '-' . sanitize_title_with_dashes( $username ) ) ) ) {

			$remote = wp_remote_get( $url );

			if ( is_wp_error( $remote ) ) {
				return new WP_Error( 'site_down', esc_html__( 'Unable to communicate with Instagram.', 'wi' ) );
			}

			if ( 200 !== wp_remote_retrieve_response_code( $remote ) ) {
				return new WP_Error( 'invalid_response', esc_html__( 'Instagram did not return a 200.', 'wi' ) );
			}

			$shards      = explode( 'window._sharedData = ', $remote['body'] );
			$insta_json  = explode( ';</script>', $shards[1] );
			$insta_array = json_decode( $insta_json[0], true );

			if ( ! $insta_array ) {
				return new WP_Error( 'bad_json', esc_html__( 'Instagram has returned invalid data.', 'wi' ) );
			}

			if ( isset( $insta_array['entry_data']['ProfilePage'][0]['graphql']['user']['edge_owner_to_timeline_media']['edges'] ) ) {
				$images = $insta_array['entry_data']['ProfilePage'][0]['graphql']['user']['edge_owner_to_timeline_media']['edges'];
			} elseif ( isset( $insta_array['entry_data']['TagPage'][0]['graphql']['hashtag']['edge_hashtag_to_media']['edges'] ) ) {
				$images = $insta_array['entry_data']['TagPage'][0]['graphql']['hashtag']['edge_hashtag_to_media']['edges'];
			} else {
				return new WP_Error( 'bad_json_2', esc_html__( 'Instagram has returned invalid data.', 'wi' ) );
			}

			if ( ! is_array( $images ) ) {
				return new WP_Error( 'bad_array', esc_html__( 'Instagram has returned invalid data.', 'wi' ) );
			}

			$instagram = array();

			foreach ( $images as $image ) {
				if ( true === $image['node']['is_video'] ) {
					$type = 'video';
				} else {
					$type = 'image';
				}

				$caption = __( 'Instagram Image', 'wi' );
				if ( ! empty( $image['node']['edge_media_to_caption']['edges'][0]['node']['text'] ) ) {
					$caption = wp_kses( $image['node']['edge_media_to_caption']['edges'][0]['node']['text'], array() );
				}

				$instagram[] = array(
					'description' => $caption,
					'link'        => trailingslashit( '//instagram.com/p/' . $image['node']['shortcode'] ),
					'time'        => $image['node']['taken_at_timestamp'],
					'comments'    => $image['node']['edge_media_to_comment']['count'],
					'likes'       => $image['node']['edge_liked_by']['count'],
					'thumbnail'   => preg_replace( '/^https?\:/i', '', $image['node']['thumbnail_resources'][0]['src'] ),
					'small'       => preg_replace( '/^https?\:/i', '', $image['node']['thumbnail_resources'][2]['src'] ),
					'large'       => preg_replace( '/^https?\:/i', '', $image['node']['thumbnail_resources'][4]['src'] ),
					'original'    => preg_replace( '/^https?\:/i', '', $image['node']['display_url'] ),
					'type'        => $type,
				);
			} // End foreach().

			// do not set an empty transient - should help catch private or empty accounts.
			if ( ! empty( $instagram ) ) {
				$instagram = base64_encode( serialize( $instagram ) );
				set_transient( 'insta-a10-' . $transient_prefix . '-' . sanitize_title_with_dashes( $username ), $instagram, apply_filters( 'null_instagram_cache_time', $cache_time ) );
			}
		}

		if ( ! empty( $instagram ) ) {

			$instagram = unserialize( base64_decode( $instagram ) );

		} else {

			return new WP_Error( 'no_images', esc_html__( 'Instagram did not return any images.', 'wi' ) );

		}
    }

    if ( ! empty( $instagram ) ) {

        return array_slice( $instagram, 0, $number );

    } else {

        return new WP_Error( 'no_images', esc_html__( 'Instagram did not return any images.', 'wi' ) );

    }

}
endif;

/**
 * Mobile Nav Off Canvas Markup
 * @since 2.9
 */
add_action( 'wp_footer', 'wi_mobile_nav', 0 );
function wi_mobile_nav() {
?>
<div id="offcanvas">

    <?php if ( has_nav_menu( 'primary' ) ) { ?>
            
        <nav id="mobilenav" class="offcanvas-nav">

            <?php wp_nav_menu(array(
                'theme_location'	=>	'primary',
                'depth'				=>	4,
                'container_class'	=>	'menu',
                'after' => '<span class="indicator"></span>',
            ));?>

        </nav><!-- #mobilenav -->
    
    <?php } // primary menu
            
    // social icons                          
    if (!get_theme_mod('wi_disable_header_social')): ?>
    <div class="offcanvas-social header-social social-list">
        <ul>
            <?php wi_social_list( false ); ?>
        </ul>
    </div><!-- .social-list -->
    <?php endif; // header-social
                               
    // header search
    if ( ! get_theme_mod( 'wi_disable_header_search' ) ) {
        get_search_form();
    }
    ?>
    
</div><!-- #offcanvas -->

<div id="offcanvas-overlay"></div>
<?php
}

/**
 * set section value to none for homepage builder
 *
 * @since 3.0
 */
// add_action( 'wp', 'wi_fix_default_options_customizer' );
function wi_fix_default_options_customizer() {
    
    if ( ! is_admin() ) {
        
        $max_sections = absint( get_theme_mod( 'wi_max_sections', 10 ) );
        if ( $max_sections < 2 || $max_sections > 40 ) $max_sections = 10;

        for ( $i = 1; $i <= $max_sections; $i++ ) {

            $prefix = "bf_{$i}_";
            $cat = get_theme_mod( "{$prefix}cat" );
            if ( ! $cat ) {
                set_theme_mod( "{$prefix}cat", 'none' );
            }

            $layout = get_theme_mod( "{$prefix}layout" );
            if ( ! $layout ) {
                set_theme_mod( "{$prefix}layout", 'slider' );
            }

        }
        
    }
    
}

/**
 * Link Post Format
 * @since 3.0
 */
function post_link_url( $url, $post ) {
    
    if ( ! is_admin() ) {
        
        $link = '';

        if ( 'link' === get_post_format( $post->ID ) ) {

            $link = trim( get_post_meta( $post->ID, '_format_link_url', true ) );

        }

        if ( $link ) $url = $link;
        
    }
    
    return $url;
    
}
add_filter( 'post_link', 'post_link_url',10, 2 );