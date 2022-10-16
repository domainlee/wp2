<?php get_header(); ?>

<div class="wi-content">
    <div class="container">
        <div class="content-area primary" id="primary" role="main">
            <div class="theiaStickySidebar">
                <?php
                while (have_posts()) :
                    the_post();
                    the_content();
                endwhile;
                ?>
            </div>
        </div>
    </div>
</div>

<?php get_footer(); ?>