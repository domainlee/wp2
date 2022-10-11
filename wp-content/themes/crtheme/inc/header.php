<?php
add_action( 'wp_ajax_nav_mega', 'wi_nav_mega' );
add_action( 'wp_ajax_nopriv_nav_mega', 'wi_nav_mega' );
if ( ! function_exists( 'wi_nav_mega' ) ) :
/**
 * Mega item ajax loading
 *
 * @since 2.8
 */
function wi_nav_mega() {
    
    $nonce = isset( $_POST[ 'nonce' ] ) ? $_POST[ 'nonce' ] : '';
    
    // Verify nonce field passed from javascript code
    if ( ! wp_verify_nonce( $nonce, 'nav_mega_nonce' ) )
        die ( 'Busted!');
    
    $item_id = isset( $_POST[ 'itemID' ] ) ? absint( $_POST[ 'itemID' ] ) : '';
    if ( ! $item_id ) exit();
    
    $tax_id = get_post_meta( $item_id, '_menu_item_object_id', true );
    if ( ! $tax_id ) {
        exit();
    }
    
    $args = array(
        'post_type'             => 'post',
        'post_status'           => 'publish',
        'ignore_sticky_posts'   => 1,
        'posts_per_page'        => 3,
        'tax_query'             => array(
            array(
                'taxonomy'      => 'category',
                'field'         => 'term_id', //This is optional, as it defaults to 'term_id'
                'terms'         => $tax_id,
                'operator'      => 'IN' // Possible values are 'IN', 'NOT IN', 'AND'.
            ),
        )
    );
    
    $query = new WP_Query( $args );
    
    if ( ! $query->have_posts() ) {
        wp_reset_query();
        exit();
    }
    
    $return = array();
    
    while( $query->have_posts() ) : $query->the_post();
    
    $return[] = array(
        'title' => '<a href="' . get_permalink() . '">' . get_the_title() . '</a>',
        'thumbnail' => '<a href="' . get_permalink() . '">' . get_the_post_thumbnail( $post->ID, 'thumbnail-medium' ) . '</a>',
        'excerpt' => wi_subword( get_the_excerpt(), 0, 12 ),
    );
    
    endwhile;
    
    echo json_encode( $return );
    
    wp_reset_query();
    exit();
}

endif;

if ( ! function_exists( 'wi_navigation' ) ) :
/**
 * Navigation Items
 *
 * @since 2.9
 */
function wi_navigation() {
    
    if (has_nav_menu('primary')):?>

    <nav id="wi-mainnav" class="navigation-ele wi-mainnav" role="navigation" itemscope itemtype="https://schema.org/SiteNavigationElement">
        <?php wp_nav_menu(array(
            'theme_location'	=>	'primary',
            'depth'				=>	3,
            'container_class'	=>	'menu',
        ));?>
    </nav><!-- #wi-mainnav -->

    <?php else: ?>

    <?php echo '<div id="wi-mainnav"><em class="no-menu">'.sprintf(__('Go to <a href="%s">Appearance > Menu</a> to set "Primary Menu"','wi'),get_admin_url('','nav-menus.php')).'</em></div>'; ?>

    <?php endif; ?>

    <?php if (!get_theme_mod('wi_disable_header_social')):?>
    <div id="header-social" class="header-social social-list">
        <ul>
            <?php wi_social_list(!get_theme_mod('wi_disable_header_search')); ?>
        </ul>
    </div><!-- .header-social -->
    <?php endif; // header-social
    
}
endif;

if ( ! function_exists( 'wi_toggle_btn' ) ) :
/**
 * Toggle Button
 *
 * @since 2.9
 */
function wi_toggle_btn() { ?>

    <a class="toggle-menu">
        <span></span>
        <span></span>
        <span></span>
    </a>

<?php    
}
endif;

if ( ! function_exists( 'wi_site_branding' ) ) :
/**
 * Site Branding
 *
 * @since 2.9
 */
function wi_site_branding() {
    ?>
    <div id="logo-area">
        
        <div id="wi-logo">
            
            <?php wi_toggle_btn(); ?>
            
            <h2 class="wi-logo-main">
                
                <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
                    <?php if (!get_theme_mod('wi_logo')):?>

                        <img src="<?php echo get_template_directory_uri(); ?>/images/logo.png" alt="Logo" data-retina="<?php echo get_template_directory_uri(); ?>/images/logo@2x.png" />

                    <?php else: ?>

                        <img src="<?php echo get_theme_mod('wi_logo');?>" alt="Logo"<?php echo get_theme_mod('wi_logo_retina') ? ' data-retina="'.get_theme_mod('wi_logo_retina').'"' : '';?> />

                    <?php endif; // logo ?>
                </a>
                
            </h2>

        </div><!-- #wi-logo -->

        <?php if (!get_theme_mod('wi_disable_header_slogan') ): $hide_mobile_class = get_theme_mod( 'wi_disable_header_slogan_mobile' ) ? ' hide_on_mobile' : '' ?>
        
        <h3 class="slogan<?php echo $hide_mobile_class; ?>"><?php bloginfo('description');?></h3>
        
        <?php endif; ?>

    </div><!-- #logo-area -->
    <?php
}
endif;

if ( ! function_exists( 'wi_header_searchbox' ) ) :
/**
 * Header Search Box
 *
 * @since 2.9
 */
function wi_header_searchbox() {
    
    if (!get_theme_mod('wi_disable_header_search')):?>
    <div class="header-search" id="header-search">
        
        <div class="container">
        
            <form role="search" method="get" action="<?php echo home_url();?>" itemprop="potentialAction" itemscope itemtype="https://schema.org/SearchAction">
                <input type="text" name="s" class="s" value="<?php echo get_search_query();?>" placeholder="<?php _e('Type & hit enter...','wi');?>" />
                <button class="submit" role="button" title="<?php _e('Go','wi');?>"><span><?php _e('Go','wi');?></span></button>
            </form>
            
        </div>
            
    </div><!-- .header-search -->
    <?php endif;
    
}
endif;

if ( ! function_exists( 'wi_main_header' ) ) :
/**
 * Site Branding
 *
 * @since 2.9
 */
function wi_main_header() {
    ?>

    <div id="wi-header" class="wi-header">
        
        <div class="container">

            <?php wi_site_branding(); ?>

            <div class="clearfix"></div>

            <?php 
            /**
             * Header Area
             *
             * @since 2.1.4
             *
             * Place ad widgets here
             */
            if ( is_active_sidebar( 'header' ) ) : ?>

            <aside id="header-area" class="widget-area" role="complementary" itemscope itemptype="https://schema.org/WPSideBar">

                <?php dynamic_sidebar( 'header' ); ?>

            </aside><!-- .widget-area -->

            <?php endif; ?>

        </div><!-- .container -->

    </div><!-- #wi-header -->
    
    <?php
}
endif;