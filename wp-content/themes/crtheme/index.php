<?php get_header(); ?>

<?php
    echo 'index';
?>

<div class="wi-content">
    
    <div class="container">

        <div class="content-area primary" id="primary" role="main">

            <div class="theiaStickySidebar">
                <?php
                while (have_posts()) :
                    the_post();
                    the_content();

                endwhile; // End of the loop.
                ?>

            </div><!-- .theiaStickySidebar -->

        </div><!-- .content-area -->


    </div><!-- .container -->
    
</div><!-- .wi-content -->

<?php get_footer(); ?>