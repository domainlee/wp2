<?php /* ==============================         MAIN STREAM         ============================== */ ?>

<?php if ( !get_theme_mod('wi_disable_main_stream') ): ?>

<div class="main-stream wi-section" id="main-stream">

    <?php $hd = trim( get_theme_mod( 'main_stream_heading' ) ); if ( $hd ) { ?>

    <h3 class="section-heading">
        <span><?php echo esc_html( $hd );?></span>
    </h3>

    <?php } // heading ?>

    <main class="content-area primary" id="primary" role="main">

        <div class="theiaStickySidebar">

<?php if ( have_posts() ) : global $first; $first = true; ?>

        <div class="<?php echo esc_attr($blog_container_class);?>">

            <div class="<?php echo esc_attr($blog_class);?>">

                <?php $count = 0; while ( have_posts()): the_post(); $count++;

                    $display_ad = false;
                    if ( 'grid' === $loop || 'masonry' === $loop ) {
                    if ( '2' == $column && 3 === $count % 4 ) {
                    $display_ad = true;
                    } elseif ( '3' == $column && 4 === $count % 9  ) {
                    $display_ad = true;
                    } elseif ( '4' === $column && 5 === $count % 12 ) {
                    $display_ad = true;
                    }
                    } else {

                    if ( 3 == $count % 5 ) {
                    $display_ad = true;
                    }

                    }

                    if ( $display_ad ) {

                        get_template_part('loop/content', 'ad' );

                    }

                    get_template_part('loop/content', $loop );

                    endwhile
                ?>
                <div class="clearfix"></div>
                <div class="grid-sizer"></div>
            </div><!-- .wi-blog -->

            <?php echo wi_pagination(); ?>

        </div><!-- .wi-blog-container -->

<?php endif; // have_posts ?>

        </div><!-- .theiaStickySidebar -->

    </main><!-- .content-area -->

    <?php if ( wi_sidebar_state() != 'no-sidebar' ) get_sidebar(); ?>

    <div class="clearfix"></div>

</div><!-- #main-stream -->

<?php endif; // disable main stream ?>