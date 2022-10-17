<?php
extract( $args );
extract( wp_parse_args( $instance, array(
    'title' => '',
    'number' => '4',
    'category' => '',
    'tag' => '',
    'show_excerpt' => '',
    'layout' => 'small',
) ) );
echo $before_widget;

$title = apply_filters( 'widget_title', $title, $instance, $this->id_base );
if ( !empty( $title ) ) {	
    echo $before_title . $title . $after_title;
}

if ( 'big' !== $layout ) $layout = 'small';

$args = array(
    'post_type'			=>	'post',
    'ignore_sticky_posts'=>	true,
    'posts_per_page'	=>	$number,
    'no_found_rows' => true,
    'cache_results' => false,
);

if ($category) $args['cat'] = $category;
if ($tag) $args['tag_id'] = $tag;

$latest = new WP_Query($args); ?>
<?php if ( $latest->have_posts() ):?>

    <div class="latest-posts latest-layout-<?php echo esc_attr( $layout ); ?>">

        <ul class="latest-list">

    <?php while( $latest->have_posts() ) : $latest->the_post();?>		

        <li class="latest-article format-<?php echo get_post_format() ? get_post_format() : 'standard';?>">

            <?php if (has_post_thumbnail()):?>
            <figure class="latest-thumb">
                <a href="<?php the_permalink();?>">
                    <?php the_post_thumbnail('thumbnail-medium');?>
                </a>
            </figure><!-- .latest-thumb -->
            <?php elseif ( $attachments = get_posts( array(
                'post_type' => 'attachment',
                'posts_per_page' => 1,
                'post_parent' => get_the_ID(),
            ) )
                            ): // get all attachemnts ?>

            <figure class="latest-thumb">
                <a href="<?php the_permalink();?>">
                    <?php $image = wp_get_attachment_image_src($attachments[0]->ID,'thumbnail-medium');?>
                    <img src="<?php echo esc_url($image[0]);?>" width="<?php echo esc_attr($image[1]);?>" height="<?php echo esc_attr($image[2]);?>" alt="<?php echo get_post_meta($attachments[0]->ID, '_wp_attachment_image_alt', true);?>" />

                </a>
            </figure><!-- .latest-thumb -->

            <?php else: // no attachments ?>
            <div class="latest-pseudo-thumb latest-thumb">
                <span class="format-indicator"><i class="fa fa-<?php echo wi_format_icon(get_post_format());?>"></i></span>
            </div><!-- .latest-thumb -->
            <?php endif; ?>
            <section class="latest-content">
                <time class="latest-date" datetime="<?php echo get_the_date('c');?>"><?php echo get_the_date( get_option('date_format') );?></time>
                
                <h3 class="latest-title" itemprop="headline"><a href="<?php the_permalink();?>"><?php the_title();?></a></h3>
                
                <?php if ( $show_excerpt ) { ?>
                <div class="latest-excerpt" itemprop="text">
                    <p><?php echo wi_subword( get_the_excerpt(), 0, 12 ); ?></p>
                </div>
                <?php } ?>
                
            </section>

            <div class="clearfix"></div>

        </li><!-- .post-item -->

    <?php endwhile; ?>

        </ul>

        <div class="clearfix"></div>

    </div><!-- .latest--posts -->

<?php endif; // have_posts

wp_reset_query();

echo $after_widget;