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


if ( ! function_exists( 'cr_loading' ) ) :
/**
 * Loading
 *
 * @since 2.9
 */
function cr_loading() {
    ?>
    <div class="loading">
        <div class="loading__inner">
            <div class="loading__list">
                <span>L</span><span>O</span><span>A</span><span>D</span><span>I</span><span>N</span><span>G</span>
            </div>
        </div>
    </div>
    <?php
}
endif;

if ( ! function_exists( 'cr_navigation' ) ) :
/**
 * Navigation Items
 *
 * @since 2.9
 */
function cr_navigation() {
    
    if (has_nav_menu('primary')):?>

        <?php wp_nav_menu(array(
            'theme_location'	=>	'primary',
            'depth'				=>	3,
            'menu_class' => 'header__navigation nav d-flex flex-column flex-lg-row justify-content-center align-items-center',
            'container_class'	=>	'',
        ));?>

    <?php else: ?>

    <?php echo '<div id="cr-mainnav"><em class="no-menu">'.sprintf(__('Go to <a href="%s">Appearance > Menu</a> to set "Primary Menu"','cr'),get_admin_url('','nav-menus.php')).'</em></div>'; ?>

    <?php endif; ?>

    <?php
}
endif;

if ( ! function_exists( 'cr_site_branding' ) ) :
/**
 * Site Branding
 *
 * @since 2.9
 */
function cr_site_branding() {
    ?>
    <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
        <h1 class="header__logo m-0">
            <?php if (!the_field('logo_option', 'option')):?>
                <img class="light" src="<?php echo get_template_directory_uri(); ?>/assets/img/logo.png" alt="logo" />
                <img class="dark" src="<?php echo get_template_directory_uri(); ?>/assets/img/logo-dark.png" alt="logo" />
            <?php else: ?>
                <img class="light" src="<?php echo get_template_directory_uri(); ?>/assets/img/logo.png" alt="logo" />
                <img class="dark" src="<?php echo get_template_directory_uri(); ?>/assets/img/logo-dark.png" alt="logo" />
            <?php endif; // logo ?>
        </h1>
    </a>
    <?php
}
endif;

if ( ! function_exists( 'cr_header_searchbox' ) ) :
/**
 * Header Search Box
 *
 * @since 2.9
 */
function cr_header_searchbox() {
    
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
