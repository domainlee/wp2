<article id="post-<?php the_ID(); ?>" <?php post_class( [ 'post-item', 'post-masonry' ] ); ?>  itemscope itemtype="http://schema.org/CreativeWork">
    
    <section class="post-body">
        
        <?php global $first; if ($first):
        
        wi_display_thumbnail('full','post-item-thumbnail masonry-thumbnail', true, false, true);

        else:

        wi_display_thumbnail('thumbnail-medium-nocrop','post-item-thumbnail masonry-thumbnail', true, false, true); 
        
        endif;

        $first = false;

        ?>
    
        <header class="masonry-header">
            
            <?php wi_short_meta( 'masonry-meta' ); ?>
            
            <?php wi_post_title( 'masonry-title' ); ?>

        </header><!-- .masonry-header -->
        
        
        
        <div class="post-content">
            
            <div class="masonry-content dropcap-content small-dropcap-content" itemprop="text">
                <p>
                    <?php echo get_the_excerpt(); ?>
                    
                    <?php if (!get_theme_mod('wi_disable_blog_readmore')):?>
                    <a href="<?php the_permalink();?>" class="readmore"><?php _e('Keep Reading','wi');?></a>
                    <?php endif; ?>
                    
                </p>
            </div><!-- .masonry-content -->

            <div class="clearfix"></div>

        </div><!-- .post-content -->
        
    </section><!-- .post-body -->
    
    <div class="clearfix"></div>
    
</article><!-- .post-masonry -->