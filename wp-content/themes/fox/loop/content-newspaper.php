<article id="post-<?php the_ID(); ?>" <?php post_class('post-newspaper'); ?> itemscope itemtype="http://schema.org/CreativeWork">
    
    <section class="post-body">
        
        <?php if ( !get_theme_mod('wi_disable_blog_image') ) wi_entry_thumbnail(); ?>
    
        <header class="newspaper-header">
            
            <?php wi_post_title( 'newspaper-title' ); ?>
            
            <div class="newspaper-meta">

                <?php if (!get_theme_mod('wi_disable_blog_date')):?>
                <?php wi_entry_date(); ?>
                <?php endif; ?>
                
                <?php if (!get_theme_mod('wi_disable_blog_categories') ):?>
                <?php wi_entry_categories(); ?>
                <?php endif; ?>
                
                <?php if (!get_theme_mod('wi_disable_blog_author')):?>
                <?php wi_entry_author(); ?>
                <?php endif; ?>
                
                <?php if ( get_theme_mod('wi_blog_view_count')):?>
                <?php wi_view_count(); ?>
                <?php endif; ?>
                
            </div><!-- .newspaper-meta -->

        </header><!-- .newspaper-header -->
        
        <div class="post-content" itemprop="text">
            
            <?php if (get_theme_mod('wi_blog_standard_display') == 'excerpt'): ?>
            
            <div class="newspaper-content newspaper-excerpt">
                <?php the_excerpt(); ?>
                
                <?php if (!get_theme_mod('wi_disable_blog_readmore')):?>
                <p class="p-readmore">
                    <a href="<?php the_permalink();?>" class="more-link"><span class="post-more"><?php _e('Keep Reading','wi');?></span></a>
                </p>
                <?php endif; ?>
                
            </div><!-- .entry-content -->
            
            <?php else: ?>
            
            <div class="newspaper-content dropcap-content small-dropcap-content">
                
                <?php the_content('<span class="post-more">' . __('Keep Reading','wi') . '</span>');?>
                
            </div><!-- .newspaper-content -->
            
            <?php endif; // display ?>

            <div class="clearfix"></div>
            
            <?php if (!get_theme_mod('wi_disable_blog_share')):?>
                <?php wi_share(true); ?>
            <?php endif; ?>
            
            <div class="clearfix"></div>
            
            <?php /*------------------------		RELATED		------------------------------- */ ?>
        <?php if( !get_theme_mod('wi_disable_blog_related')): ?>

            <?php
            
            $related_query = wi_related_query();

            if ( $related_query && $related_query->have_posts() ) { ?>
                
                <div class="related-area">

                    <h3 class="newspaper-related-heading"><span><?php _e('You might be interested in','wi');?></span></h3>

                    <div class="newspaper-related">
                        <?php while ( $related_query->have_posts() ) : $related_query->the_post(); ?>

                            <?php get_template_part('loop/content', 'related-newspaper' ); ?>

                        <?php endwhile; ?>

                        <?php wp_reset_postdata(); ?>

                        <div class="clearfix"></div>

                    </div><!-- .blog-related -->
                </div><!-- #related-posts -->

                <?php
            }

            wp_reset_query();
            ?>

        <?php endif; // blog related ?>

        </div><!-- .post-content -->
        
    </section><!-- .post-body -->
    
    <div class="clearfix"></div>
    
</article><!-- .post-newspaper -->
