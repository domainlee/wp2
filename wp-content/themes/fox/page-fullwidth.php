<?php
/*
Template Name: Page fullwidth
*/
?>
<?php get_header(); ?>

<?php
    // Start the loop.
    while ( have_posts() ) : the_post();
?>

<div class="container">
    
    <header class="single-header page-header">

        <h1 class="single-title page-title"><span><?php the_title();?></span></h1>

    </header><!-- .single-header -->
    
    <div class="content">
    
        <main id="primary" class="content-area primary" role="main">

            <div class="single-body">

                <div class="entry-content dropcap-content">
                    <?php
                        the_content(); wi_page_links();
                    ?>
                    <div class="clearfix"></div>
                    
                </div><!-- .entry-content -->
                
                <?php if ( ! get_theme_mod('wi_disable_page_share') && 'true' != get_post_meta( get_the_ID(), '_wi_disable_share', true ) ) : ?>
                <?php wi_share();?>
                <?php endif; ?>

            </div><!-- .single-body -->

            <div class="clearfix"></div>

            <?php if( !get_theme_mod('wi_disable_page_comment')): ?>

            <?php wi_comment(); ?>

            <?php endif; ?>

        </main><!-- .content-area -->
        
        <div class="clearfix"></div>
    </div><!-- .content -->
</div><!-- .container -->
    
<?php
// End the loop.
endwhile;
?>

<?php get_footer(); ?>