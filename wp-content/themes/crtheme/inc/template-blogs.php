<?php
/**
 * Reusable blog templates
 *
 * @package Fox
 * @since 3.0
 */

/* ---------------------            BLOG LIST           --------------------- */
if ( ! function_exists( 'wi_blog_list' ) ) :
/**
 * $query is a WP_Query instance
 * $layout_args is option to pass to blog class
 *
 * @since 3.0
 */
function wi_blog_list( $query = [], $layout_args = [] ) {
    
    $container_class = [
        'blog-container',
        'blog-container-list'
    ];
    
    $class = [
        'wi-blog',
        'blog-list'
    ];
    
    $container_class = join( ' ', $container_class );
    $class = join( ' ', $class );
    
    if ( ! $query ) {
        global $wp_query;
        $query = $wp_query;
    }
    
    if ( $query->have_posts() ) :
    
?>

<div class="<?php echo esc_attr( $container_class ); ?>">
    
    <div class="<?php echo esc_attr( $class ); ?>">
    
        <?php while( $query->have_posts() ) : $query->the_post(); ?>

        <?php get_template_part( 'loop/content', 'list' ); ?>

        <?php endwhile; ?>
        
    </div><!-- .wi-blog -->
    
</div><!-- .blog-container -->

<?php
    endif; // have_posts
}
endif;

/* ---------------------            BLOG GRID           --------------------- */
if ( ! function_exists( 'wi_blog_grid' ) ) :
/**
 * $query is a WP_Query instance
 * $layout_args is option to pass to blog class
 *
 * @since 3.0
 */
function wi_blog_grid( $query = [], $layout_args = [] ) {
    
    $container_class = [
        'blog-container',
        'blog-container-grid'
    ];
    
    $class = [
        'wi-blog',
        'blog-grid'
    ];
    
    $column = isset( $layout_args[ 'column' ] ) ? $layout_args[ 'column' ] : 3;
    if ( $column < 2 || $column > 4 ) $column = 3;
    
    $class[] = 'column-' . $column;
    
    $container_class = join( ' ', $container_class );
    $class = join( ' ', $class );
    
    if ( ! $query ) {
        global $wp_query;
        $query = $wp_query;
    }
    
    if ( $query->have_posts() ) :
    
?>

<div class="<?php echo esc_attr( $container_class ); ?>">
    
    <div class="<?php echo esc_attr( $class ); ?>">
    
        <?php while( $query->have_posts() ) : $query->the_post(); ?>

        <?php get_template_part( 'loop/content', 'grid' ); ?>

        <?php endwhile; ?>
        
        <div class="clearfix"></div>
        
    </div><!-- .wi-blog -->
    
</div><!-- .blog-container -->

<?php
    endif; // have_posts
}
endif;

/* ---------------------            BLOG BIG           --------------------- */
if ( ! function_exists( 'wi_blog_big' ) ) :
/**
 * $query is a WP_Query instance
 * $layout_args is option to pass to blog class
 *
 * @since 3.0
 */
function wi_blog_big( $query = [], $layout_args = [] ) {
    
    if ( ! $query ) {
        global $wp_query;
        $query = $wp_query;
    }
    
    if ( $query->have_posts() ) : ?>

<div class="wi-big">
    
    <?php while( $query->have_posts()): $query->the_post();
    
        get_template_part('loop/content','big');
    
    endwhile; ?>
    
</div><!-- .wi-big -->
    
<?php
    endif;
    
}
endif;

/* ---------------------            BLOG SLIDER           --------------------- */
if ( ! function_exists( 'wi_blog_slider' ) ) :
/**
 * $query is a WP_Query instance
 * $layout_args is option to pass to blog class
 *
 * @since 3.0
 */
function wi_blog_slider( $query = [], $layout_args = [] ) {
    
    if ( ! $query ) {
        global $wp_query;
        $query = $wp_query;
    }
    
    if ( $query->have_posts() ) :
    
    ?>

<div class="wi-flexslider blog-slider">
            
    <div class="flexslider">
        
        <ul class="slides">
            
            <?php while( $query->have_posts()): $query->the_post();?>
            <li>
                <?php get_template_part( 'loop/content','slider' );?>
            </li>
            
            <?php endwhile;?>
            
        </ul>
        
    </div><!-- .flexslider -->

</div><!-- .wi-flexslider -->

<?php
    
    endif; // have_posts
}
endif;

/* ---------------------            BLOG VERTICAL           --------------------- */
if ( ! function_exists( 'wi_blog_vertical' ) ) :
/**
 * $query is a WP_Query instance
 * $layout_args is option to pass to blog class
 *
 * @since 3.0
 */
function wi_blog_vertical( $query = [], $layout_args = [] ) {
    
    $container_class = [
        'blog-container',
        'blog-container-vertical'
    ];
    
    $class = [
        'wi-blog',
        'blog-vertical'
    ];
    
    $container_class = join( ' ', $container_class );
    $class = join( ' ', $class );
    
    if ( ! $query ) {
        global $wp_query;
        $query = $wp_query;
    }
    
    if ( $query->have_posts() ) : ?>

<div class="<?php echo esc_attr( $container_class ); ?>">
    
    <div class="<?php echo esc_attr( $class ); ?>">
    
        <?php while( $query->have_posts() ) : $query->the_post(); ?>

        <?php get_template_part( 'loop/content', 'vertical' ); ?>

        <?php endwhile; ?>
        
    </div><!-- .wi-blog -->
    
</div><!-- .blog-container -->

    <?php endif; // have posts
}
endif;

/* ---------------------            BLOG GROUP 1           --------------------- */
if ( ! function_exists( 'wi_blog_group1' ) ) :
/**
 * $query is a WP_Query instance
 * $layout_args is option to pass to blog class
 *
 * @since 3.0
 */
function wi_blog_group1( $query = [], $layout_args = [] ) {
    
    $container_class = [
        'blog-container',
        'blog-container-group',
        'blog-container-group-1'
    ];
    
    $class = [
        'wi-blog',
        'blog-group',
        'blog-group-1'
    ];
    
    $container_class = join( ' ', $container_class );
    $class = join( ' ', $class );
    
    if ( ! $query ) {
        global $wp_query;
        $query = $wp_query;
    }
    
    if ( $query->have_posts() ) : $count = 0; ?>

<div class="wi-newsblock newsblock-1">

<?php while ( $query->have_posts() ) { $query->the_post(); $count++; ?>

    <?php if ( 1 == $count ) {
        
        $cl = 'post-item article-big';
        $ex_length = 22;
        $avatar = true;
        $show_author = true;
        $show_date = true;
        
    } else {
            
        $cl = 'post-item article-small-list article-small';
        $ex_length = 22;
        $avatar = false;
        $show_author = false;
        $show_date = true;
        $thumbnail = 'thumbnail-medium';
        
    } ?>
    
    <?php if ( 1 == $count ) { echo '<div class="article-big-wrapper">'; } ?>
    <?php if ( 2 == $count ) { echo '<div class="article-small-wrapper">'; } ?>
    
    <article <?php post_class( $cl ); ?> itemscope itemtype="http://schema.org/CreativeWork">

        <div class="article-inner">
        
            <?php if ( 1 == $count ) { ?>
            
            <?php wi_display_thumbnail( 'large' ); ?>
            
            <?php } else { ?>
            
                <?php wi_display_thumbnail( $thumbnail ); ?>
            
            <?php } ?>
            
            <div class="post-item-text" itemprop="text">
                
                <div class="post-item-header">
                    
                    <?php wi_short_meta(); ?>
                    <?php wi_post_title(); ?>

                </div><!-- .post-item-header -->
                
                <?php wi_entry_excerpt( $ex_length ); ?>
                
            </div><!-- .post-item-text -->
            
        </div><!-- .post-item-inner -->

    </article><!-- .post-item -->
    
    <?php do_action( 'wi_after_render_post' ); ?>
    
    <?php if ( 1 == $count ) { echo '</div><!-- .article-big-wrapper -->'; } ?>

<?php } // endwhile ?>
    
    <?php if ( 2 <= $count ) { echo '</div><!-- .article-small-wrapper -->'; } ?>

</div><!-- .wi-newsblock -->

    <?php endif; // have posts
}
endif;

/* ---------------------            BLOG GROUP           --------------------- */
if ( ! function_exists( 'wi_blog_group2' ) ) :
/**
 * $query is a WP_Query instance
 * $layout_args is option to pass to blog class
 *
 * @since 3.0
 */
function wi_blog_group2( $query = [], $layout_args = [] ) {
    
    $container_class = [
        'blog-container',
        'blog-container-group',
        'blog-container-group-2'
    ];
    
    $class = [
        'wi-blog',
        'blog-group',
        'blog-group-2'
    ];
    
    $container_class = join( ' ', $container_class );
    $class = join( ' ', $class );
    
    if ( ! $query ) {
        global $wp_query;
        $query = $wp_query;
    }
    
    if ( $query->have_posts() ) : $count = 0; ?>

<div class="wi-newsblock2">

<?php while ( $query->have_posts() ) { $query->the_post(); $count++; ?>

    <?php if ( 1 == $count ) {
        $cl = 'post-item article-big';
        $ex_length = 18;
        $avatar = true;
        $footer = true;
    } elseif ( 2 <= $count && $count <= 4 ) {
        $cl = 'post-item article-small-grid article-small';
        $ex_length = 0;
        $footer = false;
        $thumbnail = 'thumbnail-medium';
    } else {
        $cl = 'post-item article-small-grid article-tall';
        $ex_length = 40;
        $avatar = false;
        $footer = true;
        $thumbnail = 'large';
    } ?>
    
    <?php if ( 1 == $count ) { echo '<div class="article-col article-col-big">'; } ?>
    <?php if ( 2 == $count ) { echo '<div class="article-col article-col-small">'; } ?>
    <?php if ( 5 == $count ) { echo '<div class="article-col article-col-tall">'; } ?>
    
    <article <?php post_class( $cl ); ?> itemscope itemtype="http://schema.org/CreativeWork">

        <div class="post-item-inner">
        
            <?php if ( 1 == $count ) { ?>
            
            <?php wi_display_thumbnail( 'large' ); ?>
            
            <?php } else { ?>
            
            <?php wi_display_thumbnail( $thumbnail ); ?>
            
            <?php } ?>
            
            <div class="post-item-text" itemprop="text">
                
                <div class="post-item-header">
                    
                    <?php wi_short_meta(); ?>
                    <?php wi_post_title(); ?>

                </div><!-- .post-item-header -->
                
                <?php if ( $ex_length ) wi_entry_excerpt( $ex_length ); ?>
                
            </div><!-- .post-item-text -->
            
        </div><!-- .post-item-inner -->

    </article><!-- .post-item -->
    
    <?php do_action( 'wi_after_render_post' ); ?>
    
    <?php if ( 1 == $count ) { echo '</div><!-- .article-col-big -->'; } ?>
    <?php if ( 4 == $count ) { echo '</div><!-- .article-col-small -->'; } ?>
    <?php if ( 5 == $count ) { echo '</div><!-- .article-col-tall -->'; } ?>

<?php } // endwhile ?>
    
    <?php if ( 2 <= $count && $count < 4 ) { echo '</div><!-- .article-col-small -->'; } ?>

</div><!-- .wi-newsblock2 -->

    <?php endif; // have posts
}
endif;