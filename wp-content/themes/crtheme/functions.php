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