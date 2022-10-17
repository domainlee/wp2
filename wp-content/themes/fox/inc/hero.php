<?php
/**
 * HERO HEADER OF SINGLE POST
 *
 * @since 3.0
 */
if ( ! function_exists( 'wi_hero' ) ) :
/**
 * Check if we are displaying a hero featured image
 * @since 3.0
 *
 * return hero layout for single posts
 */
function wi_hero() {
    
    $hero = get_post_meta( get_the_ID(), '_wi_hero', true );
    if ( 'none' == $hero || 'full' == $hero || 'half' == $hero ) {
        return $hero;
    } else {
        $hero = get_theme_mod( 'wi_hero' );
        if ( 'full' == $hero || 'half' == $hero ) {
            return $hero;
        }
    }
    
    return;

}

endif;

add_action( 'wi_before_single', 'wi_single_hero_header' );
if ( ! function_exists( 'wi_single_hero_header' ) ) :
/**
 * Adds big hero header to single posts
 *
 * @since 3.0
 */
function wi_single_hero_header() {
    
    if ( ! is_single() ) return;
    
    $hero = wi_hero();
    
    if ( 'full' != $hero && 'half' != $hero ) return;
    $bg = '';
    if ( has_post_thumbnail() ) {
        $image_attributes = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full' );
        $bg = ' style="background-image:url(' . esc_url( $image_attributes[0] ) . ')"';
    }
    ?>

<?php if ( 'full' == $hero ) : ?>

<div id="hero" class="hero-full">
    
    <div class="hero-background">
        
        <div class="hero-height"></div>
        <div class="hero-bg"<?php echo $bg?>></div>
        <div class="hero-overlay"></div>
        
    </div><!-- .hero-background -->
    
    <div class="hero-content">
    
        <div class="hero-meta">
            <?php wi_entry_categories(); ?>
            <?php echo wi_entry_date(); ?>
        </div><!-- .hero-meta -->
        
        <h1 class="hero-headline"><?php the_title(); ?></h1>
        
        <div class="hero-excerpt">
            <?php the_excerpt(); ?>
        </div>
        
    </div><!-- .hero-content -->

</div><!-- #hero -->

<?php else : ?>

<div id="hero" class="hero-half">
    
    <div class="hero-background">
        
        <div class="hero-height"></div>
        <div class="hero-bg"<?php echo $bg?>></div>
        <div class="hero-overlay"></div>
        
    </div>
    
    <div class="hero-content">
        
        <div class="hero-content-inner">
    
            <div class="hero-meta">
                <?php wi_entry_categories(); ?>
                <?php echo wi_entry_date(); ?>
            </div><!-- .hero-meta -->

            <h1 class="hero-headline"><?php the_title(); ?></h1>

            <div class="hero-excerpt">
                <?php the_excerpt(); ?>
            </div>
            
        </div><!-- .hero-content-inner -->
        
    </div><!-- .hero-content -->

</div><!-- #hero -->

<?php endif; ?>

    <?php
    
}
endif;

add_action( 'wi_after_header', 'wi_hero_header' );
function wi_hero_header() {
    
    if ( ! is_singular() ) return;
    $hero = wi_hero();
    if ( 'full' != $hero && 'half' != $hero ) return;
    
?>

<div class="minimal-header top-mode" id="minimal-header">
    
    <div class="minimal-header-inner">
        
        <?php wi_toggle_btn(); ?>

        <?php
    $logo_minimal = get_theme_mod( 'wi_logo_minimal' );
    $logo_white = '';
    if ( 'full' == $hero ) {
        $logo_white = get_theme_mod( 'wi_logo_minimal_white' );
    }
    if ( $logo_minimal ) { ?>
        
        <div class="minimal-logo">
            
            <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
                
                <img src="<?php echo esc_attr( $logo_minimal ); ?>" alt="Minimal Logo" class="minimal-logo-img" />
                <?php if ( $logo_white ) { ?>
                <img src="<?php echo esc_attr( $logo_white ); ?>" alt="Minimal Logo White" class="minimal-logo-img-white" />
                <?php } ?>
                
            </a>
        
        </div><!-- .minimal-logo -->
        
        <?php } ?>
        
    </div>

</div><!-- #minimal-header -->

<?php
    
}