<?php
extract( $args );
extract( wp_parse_args( $instance, array(
    'title' => '',
    'number' => '4',
    'category' => '',
    'tag' => '',
    'orderby' => '',
) ) );
echo $before_widget;

$title = apply_filters( 'widget_title', $title, $instance, $this->id_base );
if ( !empty( $title ) ) {	
    echo $before_title . $title . $after_title;
}

if ( 'date' !== $orderby ) $orderby = 'score';

$args = array(
    'post_type'			=>	'post',
    'ignore_sticky_posts'=>	true,
    'posts_per_page'	=>	$number,
    'no_found_rows' => true,
    'cache_results' => false,

    'orderby' => 'meta_value_num',
    'order' => 'DESC',
    'meta_key' => '_wi_review_average',
    'meta_value_num' => '0',
    'meta_compare' => '>',
);

if ( 'date' === $orderby ) {
    $args[ 'orderby' ] = 'date';
}

if ($category) $args['cat'] = $category;
if ($tag) $args['tag_id'] = $tag;

$latest = new WP_Query($args);?>
<?php if ( $latest->have_posts() ): ?>

    <div class="best-rated-posts">

        <ul class="rated-list">

    <?php while( $latest->have_posts() ) : $latest->the_post();

$average = get_post_meta( get_the_ID(), '_wi_review_average', true );
$average = number_format((float)$average, 1, '.', '');

            ?>		

        <li class="rated-article format-<?php echo get_post_format() ? get_post_format() : 'standard';?>">

            <?php if (has_post_thumbnail()):?>
            <figure class="rated-article-thumb">
                <a href="<?php the_permalink();?>">
                    <?php the_post_thumbnail('thumbnail-medium');?>
                    <?php echo '<span class="score">' . $average . '</span>'; ?>
                </a>
            </figure><!-- .rated-article-thumb -->
            <?php elseif (  $attachments = get_posts( array(
                'post_type' => 'attachment',
                'posts_per_page' => 1,
                'post_parent' => get_the_ID(),
            ) )
                            ): // get all attachemnts ?>

            <figure class="rated-article-thumb">
                <a href="<?php the_permalink();?>">
                    <?php $image = wp_get_attachment_image_src($attachments[0]->ID,'thumbnail-medium');?>
                    <img src="<?php echo esc_url($image[0]);?>" width="<?php echo esc_attr($image[1]);?>" height="<?php echo esc_attr($image[2]);?>" alt="<?php echo get_post_meta($attachments[0]->ID, '_wp_attachment_image_alt', true);?>" />

                    <?php echo '<span class="score">' . $average . '</span>'; ?>

                </a>
            </figure><!-- .rated-article-thumb -->

            <?php else: // no attachments ?>
            <div class="rated-pseudo-thumb rated-article-thumb">
                <span class="format-indicator"><i class="fa fa-<?php echo wi_format_icon(get_post_format());?>"></i></span>
                <?php echo '<span class="score">' . $average . '</span>'; ?>
            </div><!-- .rated-article-thumb -->
            <?php endif; ?>
            <section class="rated-article-content">
                <h3 class="rated-article-title" itemprop="headline"><a href="<?php the_permalink();?>"><?php the_title();?></a></h3>
                <time class="rated-article-date" datetime="<?php echo get_the_date('c');?>"><?php echo get_the_date( get_option('date_format') );?></time>
            </section>

            <div class="clearfix"></div>

        </li><!-- .rated-article -->

    <?php endwhile; ?>

        </ul>

        <div class="clearfix"></div>

    </div><!-- .best-rated-posts -->

<?php endif; // have posts

wp_reset_query();

echo $after_widget;