<?php
/**
 * Custom template tags for this theme
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package WordPress
 * @subpackage Fox
 * @since 2.8
 */

if ( ! function_exists( 'wi_content_column' ) ) :
/**
 * Returns 1 or 2
 *
 * @since 3.0
 */
function wi_content_column() {
    
    // changed since 3.0
    $column = get_post_meta( get_the_ID(), '_wi_column_layout', true );

    if ( 'single-column' == $column ) {
        $column = '1';
    } elseif ( 'two-column' == $column ) {
        $column = '2';
    } else {
        $column = get_theme_mod( 'wi_blog_content_column', '1' );
    }
    if ( '2' != $column ) $column = '1';
    
    return $column;
    
}
endif;

if ( ! function_exists( 'wi_entry_author' ) ) :
/**
 * Prints HTML with meta information for the current post-date/time and author.
 *
 * @since 2.8
 */
function wi_entry_author() {

	// Get the author name; wrap it in a link.
	$byline = sprintf(
		/* translators: %s: post author */
		esc_html__( 'by %s', 'wi' ),
		'<span class="author vcard"><a class="url fn" itemprop="url" rel="author" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '"><span itemprop="name">' . get_the_author() . '</span></a></span>'
	);

	// Finally, let's write all of this to the page.
	echo '<span class="entry-author meta-author" itemprop="author" itemscope itemtype="https://schema.org/Person">';
    
    echo '<span class="byline"> ' . $byline . '</span>';
    
    echo '</span>';
}
endif;

if ( ! function_exists( 'wi_entry_date' ) ) :
/**
 * Gets a nicely formatted string for the published date.
 * @since 2.8
 
 * add human difference time
 * @since 3.0
 */
function wi_entry_date() {
    
    $time_style = get_theme_mod( 'wi_time_style', 'human' );
    
    if ( 'human' === $time_style ) :
    
        echo '<span class="entry-date meta-time human-time">';
    
        printf( esc_html_x( '%s ago', '%s = human-readable time difference', 'wi' ), human_time_diff( get_the_time( 'U' ), current_time( 'timestamp' ) ) );
    
        echo '</span>';
    
    else :
    
        $time_string = '<time class="published updated" itemprop="datePublished" datetime="%1$s">%2$s</time>';
        if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
            $time_string = '<time class="published" itemprop="datePublished" datetime="%1$s">%2$s</time><time class="updated" itemprop="dateModified" datetime="%3$s">%4$s</time>';
        }

        $time_string = sprintf( $time_string,
            get_the_date( DATE_W3C ),
            get_the_date(),
            get_the_modified_date( DATE_W3C ),
            get_the_modified_date()
        );

        // Wrap the time string in a link, and preface it with 'Posted on'.
        echo '<span class="entry-date meta-time machine-time">';
    
        printf(
            /* translators: %s: post date */
            wp_kses( '<span class="published-label">' . esc_html__( 'Published on', 'wi' ) . '</span> %s', wi_allowed_html() ),
            $time_string
        );
    
        echo '</span>';
    
    endif;
    
}
endif;

if ( ! function_exists( 'wi_short_date' ) ) :
/**
 * Gets a nicely formatted string for the published date.
 */
function wi_short_date() {
	$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
	if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
		$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
	}

	$time_string = sprintf( $time_string,
		get_the_date( DATE_W3C ),
		get_the_date(),
		get_the_modified_date( DATE_W3C ),
		get_the_modified_date()
	);

	// Wrap the time string in a link, and preface it with 'Posted on'.
	echo '<span class="grid-date">' . sprintf(
		/* translators: %s: post date */
		wp_kses( '<span class="screen-reader-text">' . esc_html__( 'Posted on', 'wi' ) . '</span> %s', wi_allowed_html() ),
		$time_string
	) . '</span>';
}
endif;

if ( ! function_exists( 'wi_entry_categories' ) ) :
/**
 * Prints post categories
 */
function wi_entry_categories() {
    
    if ( 'post' !== get_post_type() ) return;
    
    $separate_meta = '<span class="sep">' . esc_html__( '/', 'wi' ) . '</span>';
    ?>

    <span class="entry-categories meta-categories">

        <?php printf( esc_html__( '%s %s', 'wi' ), '<span class="in-word">' . esc_html__( 'in', 'wi' ) . '</span>', get_the_category_list( $separate_meta ) ); ?>

    </span>

    <?php
    
}
endif;

if ( ! function_exists( 'wi_entry_excerpt' ) ) :
/**
 * Displays the excerpt
 * @since 3.0
 */
function wi_entry_excerpt( $length = -1, $more = null, $extra_class = '' ) {
    
    $class = [ 'post-item-excerpt' ];
    if ( $extra_class ) {
        $class[] = $extra_class;
    }
    
    $class = join( ' ', $class );
    
    $excerpt = get_the_excerpt();
    if ( $length > 0 ) {
        $excerpt = wi_subword( $excerpt , 0 , $length ) . '&hellip;';
    }
    ?>

    <div class="<?php echo esc_attr( $class ); ?>" itemprop="text">
        <p> 
            <?php echo $excerpt; ?>
            
            <?php if ( null === $more ) $more = ! get_theme_mod( 'wi_disable_blog_readmore' ); ?>

            <?php if ( $more ): ?>
            <a href="<?php the_permalink();?>" class="readmore"><?php _e('Keep Reading','wi');?></a>
            <?php endif; ?>
        </p>
    </div><!-- .post-item-excerpt -->

    <?php
    
}
endif;

if ( ! function_exists( 'wi_short_meta' ) ) :
/**
 * Displays the post meta
 * @since 3.0
 */
function wi_short_meta( $extra_class = ''  ) {
    
    $class = [ 'post-item-meta' ];
    if ( $extra_class ) {
        $class[] = $extra_class;
    }
    
    $class = join( ' ', $class );
    
    ?>

<div class="<?php echo esc_attr( $class ); ?>">

    <?php if (!get_theme_mod('wi_disable_blog_date')):?>
    <?php wi_short_date(); ?>
    <?php endif; ?>

    <?php if (!get_theme_mod('wi_disable_blog_categories')):?>
    <?php wi_entry_categories(); ?>
    <?php endif; ?>

</div><!-- .post-item-meta -->

    <?php
}
endif;

if ( ! function_exists( 'wi_post_title' ) ) :
/**
 * Displays the post title
 * @since 3.0
 */
function wi_post_title( $extra_class = ''  ) {
    
    $class = [ 'post-item-title' ];
    if ( $extra_class ) {
        $class[] = $extra_class;
    }
    
    $class = join( ' ', $class );
    
    ?>

<h2 class="<?php echo esc_attr( $class ); ?>" itemprop="headline">

    <a href="<?php the_permalink();?>" rel="bookmark"><?php the_title();?></a>

</h2>

    <?php
}
endif;

if ( ! function_exists( 'wi_post_thumbnail' ) ) :
/**
 * Post Thumbnail
 * @since 2.8
 */
function wi_post_thumbnail( $args = array() ) {
    
    extract( wp_parse_args( $args, array(
        'basis' => array( 'grid' ),
        'thumbnail_ratio' => '',
        'thumbnail_ratio_custom' => '',
        'review' => false, // note that this is boolean value
        'view_count' => '',
        'format_indicator' => 'true',
        'thumbnail' => 'large',
    ) ) );
    
    $thumbnail_class = '';
    foreach ( $basis as $base ) {
        $thumbnail_class .= ' post-' . $base .'-thumbnail';
    }
    
    if ( ! has_post_thumbnail() ) return;
    
    /* Thumbnail Ratio
    ------------------------ */
    $ratio = '';
    if ( $thumbnail_ratio === 'custom' ) {
        $ratio = $thumbnail_ratio_custom;
    } else {
        $ratio = $thumbnail_ratio;
    }
    $ratio = explode( 'x', $ratio );
    $w = isset( $ratio[0] ) ? $ratio[0] : 0;
    $h = isset( $ratio[1] ) ? $ratio[1] : 0;
    $w = absint( $w ); $h = absint( $h );
    if ( $w < 1 || $h < 1 || $w/$h < 0.1 || $h/$w < 0.1 ) $w = $h = 1;
    $height_css = '';
    if ( $w/$h != 1 ) $height_css = ' style="padding-bottom:' . ( $h/$w * 100 ). '%;"';
    
    ?>

    <div class="<?php echo esc_attr( $thumbnail_class ); ?>" itemscope itemtype="http://schema.org/ImageObject">
            
        <?php $full_img = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full' ); ?>

        <meta itemprop="url" content="<?php echo esc_url( $full_img[0] ); ?>">
        <meta itemprop="width" content="<?php echo absint( $full_img[1] ); ?>">
        <meta itemprop="height" content="<?php echo absint( $full_img[2] ); ?>">

        <a href="<?php the_permalink(); ?>" rel="bookmark">

            <?php if ( 'auto' === $thumbnail_ratio ) { ?>

            <?php the_post_thumbnail( $thumbnail ); ?>

            <?php } else {

                $featured_image = wp_get_attachment_image_src( get_post_thumbnail_id(), $thumbnail );
                $bg_css = ' style="background-image:url(' . esc_url( $featured_image[0] ) . ')"';

            ?>

            <div class="bg-thumb">

                <div class="bg-element"<?php echo $bg_css; ?>></div>
                <div class="height-element"<?php echo $height_css; ?>></div>

            </div><!-- .bg-thumb -->

            <?php } ?>

            <?php if ( $review ) { wi_review_score(); } ?>

            <?php if ( 'true' === $format_indicator ) wi_format_indicator(); ?>

            <?php if ( 'true' === $view_count ) { wi_view_count(); } ?>

        </a>

    </div><!-- .post-grid-thumbnail -->

<?php
}
endif;

if ( ! function_exists( 'wi_post_header' ) ) :
/**
 * Post Header
 *
 * @since 2.8
 */
function wi_post_header( $args = array() ) {
    
    extract( wp_parse_args( $args, array(
        'basis' => array( 'grid' ),
        'categories' => '',
        'date' => '',
        'title' => '',
    ) ) );
    
    if ( 'true' !== $categories && 'true' !== $date && 'true' !== $title ) return;
    
    $header_class = $meta_class = $title_class = '';
    foreach ( $basis as $base ) {
        $header_class .= ' post-' . $base . '-header';
        $meta_class .= ' post-' . $base . '-meta';
        $title_class .= ' post-' . $base . '-title';
    }
    
?>
    
    <header class="<?php echo esc_attr( $header_class ); ?>">
        
        <?php if ( 'true' == $title ) { ?>

        <h2 class="<?php echo esc_attr( $title_class ); ?>" itemprop="headline">

            <a href="<?php the_permalink(); ?>" rel="bookmark">

                <?php the_title(); ?>

            </a>

        </h2>

        <?php } // show title ?>

        <?php if ( 'true' === $categories || 'true' === $date ) { ?>

        <div class="<?php echo esc_attr( $meta_class ); ?>">

            <?php if ( 'true' === $categories ) {
                wi_entry_categories(); } ?>

            <?php if ( 'true' === $date ) {
                wi_entry_date(); } ?>

        </div><!-- .post-grid-meta -->

        <?php } ?>

    </header><!-- .post-grid-header -->
<?php
}
endif;

if ( ! function_exists( 'wi_post_footer' ) ) :
/**
 * Post Footer
 * @since 2.8
 */
function wi_post_footer( $args = array() ) {
    
    extract( wp_parse_args( $args, array(
        'basis' => array( 'grid' ),
        'author' => '',
        'comment_link' => '',
    ) ) );
    
    if ( 'true' !== $author && 'true' !== $comment_link ) return;
    
    $footer_class = '';
    foreach ( $basis as $base ) {
        $footer_class .= ' post-' . $base . '-footer';
    }
    ?>

    <div class="<?php echo esc_attr( $footer_class ); ?>">
            
        <?php if ( 'true' === $author ) {
            wi_entry_author();
        } ?>

        <?php if ( 'true' === $comment_link ) {
            wi_comment_link();
        } ?>

    </div><!-- .post-grid-footer -->

    <?php
}
endif;

if ( ! function_exists( 'wi_excerpt' ) ) :
/**
 * Prints post excerpt
 *
 * @since 2.8
 */
function wi_excerpt( $excerpt_length, $args = array() ) {
    
    extract( wp_parse_args( $args, array(
        'basis' => array( 'grid' ),
    ) ) );
    
    $excerpt_class = '';
    foreach ( $basis as $base ) {
        $excerpt_class .= ' post-' . $base . '-excerpt';
    }
    
    $ex = get_the_excerpt();
    echo '<div class="' . esc_attr( $excerpt_class ) . '" itemprop="text">' . wpautop( wi_word_substr( $ex, 0, $excerpt_length ) ) . '</div>';

}
endif;

if ( ! function_exists( 'wi_related_query' ) ) :
/**
 * Returns a query of related posts
 *
 * @since 3.0
 */
function wi_related_query( $number = 3 ) {
    
    if ( wi_related_jetpack() ) {
        
        $related = Jetpack_RelatedPosts::init_raw()
            ->set_query_name( 'jetpackme-shortcode' ) // Optional, name can be anything
            ->get_for_post_id(
                get_the_ID(),
                array( 'size' => $number )
            );
        
        if ( $related ) {
            
            $related_ids = array();
            foreach ( $related as $result ) {
                $related_ids[] = $result[ 'id' ];
            }
            
            return new WP_Query( array( 'post__in' => $related_ids ) );
            
        }
        
        return;
        
    } else {
    
        global $post;
        $current_ID = $post->ID;
        $tags = wp_get_post_tags( $current_ID, array( 'fields' => 'ids' ) );
        $args = array(
            
            'post_type' => 'post',
            'posts_per_page' => $number,

            'ignore_sticky_posts'   =>  true,
            'no_found_rows' => true,
            'cache_results' => false,
            'post__not_in' => array( $current_ID ),
            
        );
        if ( empty( $tags ) ) return;

        $args[ 'tag__in' ] = $tags;

        $related_query = new WP_Query( $args );

        return $related_query;
        
    }
    
}
endif;

if ( ! function_exists( 'wi_related_posts' ) ) :
/**
 * Display related posts of current post
 *
 * @since 3.0
 */
function wi_related_posts() {
    
    $related_query = wi_related_query( 3 );
    if ( $related_query && $related_query->have_posts() ) { ?>

    <div class="related-posts" id="related-posts">

        <h3 class="related-heading"><span><?php _e('You might be interested in','wi');?></span></h3>

        <div class="related-list blog-grid column-3">
            <?php while ( $related_query->have_posts() ): $related_query->the_post();?>

                <?php get_template_part('loop/content-related', 'single' ); ?>

            <?php endwhile; ?>

            <div class="clearfix"></div>

        </div><!-- .related-list -->

    </div><!-- #related-posts -->

    <?php
    } // related_posts

    wp_reset_query();

}
endif;

if ( ! function_exists( 'wi_thumbnail_carousel' ) ) :
/**
 * Display carousel gallery format
 *
 * @since 2.8
 */
function wi_thumbnail_carousel() {
    
    if (get_post_format()!='gallery') return;
    
    $effect = get_post_meta( get_the_ID(), '_format_gallery_effect', true);
    
    if ($effect!='carousel') return;
    
    // attachments
    $attachments = get_post_meta( get_the_ID() , '_format_gallery_images', true );
    if ( ! is_array( $attachments ) ) {
        $attachments = explode( ',', $attachments );
        $attachments = array_map( 'trim', $attachments );
    }

    if (  count($attachments) == 0 )	// nothing at all
            return;
?>

    <div class="wi-carousel">

        <div class="wi-slick">

            <?php
            foreach ( $attachments as $attachment):
                $attachment_src = wp_get_attachment_image_src( $attachment, 'thumbnail-vertical' );
                $full_src = wp_get_attachment_image_src( $attachment, 'full' );
                $attachment_post = get_post($attachment);
                ?>
                    <figure class="slick-item slide" itemscope itemtype="http://schema.org/ImageObject">
                        
                        <meta itemprop="url" content="<?php echo esc_url( $full_src[0] ); ?>">
                        <meta itemprop="width" content="<?php echo absint( $full_src[1] ); ?>">
                        <meta itemprop="height" content="<?php echo absint( $full_src[2] ); ?>">
                        
                        <a href="<?php echo esc_url($full_src[0]);?>" class="wi-colorbox" rel="carouselPhotos">
                            <img src="<?php echo esc_url ( $attachment_src[0] );?>" width="<?php echo esc_attr($attachment_src[1]);?>" height="<?php echo esc_attr($attachment_src[2]);?>" alt="<?php echo basename( $attachment_src[0] );?>" />

                            <?php if ($caption = $attachment_post->post_excerpt){?>
                            <span class="slide-caption"><?php echo strip_tags( $caption );?></span>
                            <?php } ?>
                        </a><!-- .wi-colorbox -->
                        
                    </figure>

            <?php
            endforeach;
            ?>

        </div><!-- .wi-slick -->
        
    </div><!-- .wi-carousel -->

<?php return;
    
}
endif;

/* -------------------------------------------------------------------- */
/* MEDIA RESULT
/* -------------------------------------------------------------------- */
if (!function_exists('wi_get_media_result')) {
function wi_get_media_result($size = 'full') {
    
	// get data
	$type = get_post_format();	
	if ($type=='audio') $media_code = trim( get_post_meta( get_the_ID(), '_format_audio_embed' , true ) );
	elseif ($type=='video') $media_code = trim( get_post_meta( get_the_ID(), '_format_video_embed' , true ) );
	else $media_code = '';
	
	// return none
	if (!$media_code) return;
	
	// iframe
	if ( stripos($media_code,'<iframe') > -1) return $media_code;

	// case url	
	// detect if self-hosted
	$url = $media_code;
	$parse = parse_url(home_url());
	$host = preg_replace('#^www\.(.+\.)#i', '$1', $parse['host']);
	$media_result = '';
	
	// not self-hosted
	if (strpos($url,$host)===false) {
		global $wp_embed;
		return $wp_embed->run_shortcode('[embed]' . $media_code . '[/embed]');
	
	// self-hosted	
	} else {
		if ($type=='video') {
			$args = array('src' => esc_url($url), 'width' => '643' );
			if ( has_post_thumbnail() ) {
				$full_src = wp_get_attachment_image_src( get_post_thumbnail_id() , $size );
				$args['poster'] = $full_src[0];
			}
			$media_result = '<div class="wi-self-hosted-sc">'.wp_video_shortcode($args).'</div>';
            $video_id = attachment_url_to_postid( $url );
            if ( $video_id ) {
                $caption = wp_get_attachment_caption( $video_id ); 
                if ( $caption ) {
                    $media_result .= '<figcaption class="post-thumbnail-caption video-caption wp-caption-text">';
                    $media_result .= wp_kses( $caption, wi_allowed_html() );
                    $media_result .= '</figcaption>';
                }
            }
		} elseif ($type=='audio') {
            
            if ( has_post_thumbnail() ) {
				$full_src = wp_get_attachment_image_src( get_post_thumbnail_id() , $size );
			}
            
			$media_result = '<figure class="wi-self-hosted-audio-poster"><img src="'.esc_url($full_src[0]).'" width="'.$full_src[1].'" height="'.$full_src[2].'" alt="'.esc_attr(get_post_meta(get_post_thumbnail_id(), '_wp_attachment_image_alt', true)) .'" /></figure>' . wp_audio_shortcode(array('src' => esc_url($url)));
		}
	}
	
	return $media_result;
	
}
}

if ( ! function_exists( 'wi_entry_thumbnail' ) ) :
/**
 * Display post thumbnail for various post formats
 *
 * @since 2.8
 */
function wi_entry_thumbnail() {
    
    $format = get_post_format();
    
    if ( 'video' === $format ) {
        
        echo '<div class="post-thumbnail thumbnail-video"><div class="media-container">' . wi_get_media_result() . '</div></div>';
        
    } elseif ( 'audio' === $format ) {
        
        echo '<div class="post-thumbnail thumbnail-audio"><div class="media-container">' . wi_get_media_result() . '</div></div>';
        
    } elseif ( 'gallery' === $format ) {
        
        $effect = get_post_meta( get_the_ID(), '_format_gallery_effect', true );
        if ( is_single() && $effect=='carousel' ) return;
        if ($effect =='carousel') {
            wi_thumbnail_carousel();
            return;
        }
        
        if ( $effect!='fade' ) $effect = 'slide';
        
        // attachments
        $attachments = get_post_meta( get_the_ID() , '_format_gallery_images', true );
        if ( ! is_array( $attachments ) ) {
            $attachments = explode( ',', $attachments );
            $attachments = array_map( 'trim', $attachments );
        }
        
        if (  count($attachments) == 0 )	// nothing at all
                return;
        
        $options = array(
            'animation' => $effect,
        );
        ?>

        <div class="post-thumbnail thumbnail-gallery thumbnail-<?php echo esc_attr($effect);?>">
            
            <div class="wi-flexslider" data-options='<?php echo json_encode( $options ); ?>' data-effect="<?php echo esc_attr($effect);?>">
                <div class="flexslider">
                    <ul class="slides">
                        
                        <?php
                        foreach ( $attachments as $attachment):
                            $attachment_src = wp_get_attachment_image_src( $attachment, 'full' );
                            $attachment_post = get_post( $attachment );
                            ?>
                            <li class="slide">
                                
                                <figure itemscope itemtype="http://schema.org/ImageObject">
                                    
                                    <meta itemprop="url" content="<?php echo esc_url( $attachment_src[0] ); ?>">
                                    <meta itemprop="width" content="<?php echo absint( $attachment_src[1] ); ?>">
                                    <meta itemprop="height" content="<?php echo absint( $attachment_src[2] ); ?>">
                                    
                                    <img src="<?php echo esc_url ( $attachment_src[0] );?>" width="<?php echo esc_attr($attachment_src[1]);?>" height="<?php echo esc_attr($attachment_src[2]);?>" alt="<?php echo basename( $attachment_src[0] );?>" />
                                
                                </figure>
                                <?php if ($caption = $attachment_post->post_excerpt){?>
                                <span class="slide-caption"><?php echo strip_tags( $caption );?></span>
                                <?php } ?>
                                
                            </li>
                        <?php
                        endforeach;
                        ?>
                    </ul><!-- .slides -->
                </div><!-- .flexslider -->
            </div><!-- .wi-flexslider -->

        </div><!-- .post-thumbnail -->

    <?php
    
    } else {
    
        if ( '' !== get_the_post_thumbnail() ) { ?>

        <figure class="post-thumbnail" itemscope itemtype="http://schema.org/ImageObject">
            
            <?php $full_img = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full' ); ?>

            <meta itemprop="url" content="<?php echo esc_url( $full_img[0] ); ?>">
            <meta itemprop="width" content="<?php echo absint( $full_img[1] ); ?>">
            <meta itemprop="height" content="<?php echo absint( $full_img[2] ); ?>">
            
            <div class="post-thumbnail-inner">
            
                <?php if ( ! is_single() ) { ?>

                <a href="<?php the_permalink(); ?>">

                    <?php the_post_thumbnail( 'full' ); ?>

                </a>

                <?php } else { ?>

                <?php the_post_thumbnail( 'full' ); ?>

                <?php } ?>
                
            </div><!-- .post-thumbnail-inner -->
            
            <?php $caption = get_the_post_thumbnail_caption(); if ( $caption ) { ?>
            <figcaption class="post-thumbnail-caption wp-caption-text">
                <?php echo wp_kses( $caption, wi_allowed_html() ) ;?>
            </figcaption>
            <?php } ?>

        </figure><!-- .post-thumbnail -->

        <?php } else {
        
            echo '<div class="no-thumbnail-line"></div>';
        
        }

    }
    
}
endif;

/* -------------------------------------------------------------------- */
/* FORMAT ICON
/* -------------------------------------------------------------------- */
if (!function_exists('wi_format_icon')) {
    function wi_format_icon($format = '') {
        if (!$format) $format = get_post_format();
        if ($format=='quote') return 'quote-left';
        elseif ($format=='gallery') return 'camera';
        elseif ($format=='audio') return 'music';
        elseif ($format=='video') return 'play';
        else return 'file-text-o';
    }
}

/* -------------------------------------------------------------------- */
/* GET THUMBNAIL WHEN HAS NO THUMBNAIL
 * @since 2.0
 * thumbnail
 * class (grid, masonry...)
 * link (link to single post
 * placeholder image when there's no image
 * $view_count to show or not (since 2.8)
/* -------------------------------------------------------------------- */
if ( !function_exists('wi_display_thumbnail') ) {
function wi_display_thumbnail( $thumbnail = 'thumbnail', $class = '', $link = true, $placeholder = false, $view_count = false, $echo = true ){
    
    if ( ! $echo ) {
        ob_start();
    }
    
    if ( ! $class ) {
        $class = 'post-item-thumbnail';
    }
    
    if (has_post_thumbnail()) {?>
        <figure class="<?php echo esc_attr($class);?>" itemscope itemtype="http://schema.org/ImageObject">
            
            <?php $full_img = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full' ); ?>
            
            <meta itemprop="url" content="<?php echo esc_url( $full_img[0] ); ?>">
            <meta itemprop="width" content="<?php echo absint( $full_img[1] ); ?>">
            <meta itemprop="height" content="<?php echo absint( $full_img[2] ); ?>">
            
            <?php if ($link) echo '<a href="'.get_permalink().'">';?>
                <?php the_post_thumbnail( $thumbnail ); ?>
            
                <?php echo get_post_format( ) ? '<span class="format-sign sign-' . get_post_format() . '"><i class="fa fa-'.wi_format_icon().'"></i></span>' : ''; ?>
            
            <?php if ( $view_count && get_theme_mod('wi_blog_view_count')):?>
            <?php wi_view_count(); ?>
            <?php endif; ?>
            
            <?php if ($link) echo '</a>';?>
            
        </figure>
    <?php
                              } 
    elseif ( $attachments = get_posts( array(
    'post_type' => 'attachment',
    'posts_per_page' => 1,
    'post_parent' => get_the_ID(),
    ) ) ) {
        $image = wp_get_attachment_image_src($attachments[0]->ID, $thumbnail);?>

        <figure class="<?php echo esc_attr($class . ' thumbnail-type-secondary');?>" itemscope itemtype="http://schema.org/ImageObject">
            
            <?php $full_img = wp_get_attachment_image_src( $attachments[0]->ID, 'full' ); ?>
            
            <meta itemprop="url" content="<?php echo esc_url( $full_img[0] ); ?>">
            <meta itemprop="width" content="<?php echo absint( $full_img[1] ); ?>">
            <meta itemprop="height" content="<?php echo absint( $full_img[2] ); ?>">
            
            <?php if ($link) echo '<a href="'.get_permalink().'">';?>

                <img src="<?php echo esc_url($image[0]);?>" width="<?php echo esc_attr($image[1]);?>" height="<?php echo esc_attr($image[2]);?>" alt="<?php echo esc_attr(get_post_meta($attachments[0]->ID, '_wp_attachment_image_alt', true));?>" />
            
                <?php echo get_post_format() ? '<span class="format-sign sign-'.get_post_format().'"><i class="fa fa-'.wi_format_icon().'"></i></span>' : ''; ?>
            
            <?php if ($link) echo '</a>';?>
        </figure>
    <?php
    } elseif ($placeholder) {
        ?>
        <figure class="<?php echo esc_attr($class . ' thumbnail-pseudo');?>">
            <?php if ($link) echo '<a href="'.get_permalink().'">';?>
        
                <img src="<?php echo get_template_directory_uri();?>/images/thumbnail-medium.png" width="400" height="320" alt="Placeholder" />
                <span class="format-indicator"><i class="fa fa-<?php echo wi_format_icon(get_post_format());?>"></i></span>
            
            <?php if ($link) echo '</a>';?>
        </figure>
    <?php
    }
    
    if ( ! $echo ) {
        return ob_get_clean();
    }
    
}
}

if ( ! function_exists( 'wi_playable_video' ) ) :
/**
 * Playable Video
 * We assume that this is video post
 *
 * @since 2.8
 */
function wi_playable_video() {
    
    global $post;
    
    $media_code = trim( get_post_meta( $post->ID, '_format_video_embed' , true ) );
    if ( stripos($media_code,'<' . 'iframe') === false ) {
        global $wp_embed;
        $code_result = $wp_embed->run_shortcode( '[embed]' . $media_code . '[/embed]' );
    } else {
        $code_result = $media_code;
    }
    if ( ! $code_result ) return;
    
    $case = '';
    if (strpos($media_code, 'youtube') > 0 || strpos($media_code, 'youtu.be') > 0) {
        $case = 'youtube';
    } elseif (strpos($media_code, 'vimeo') > 0) {
        $case = 'vimeo';
    }
    
    if ( has_post_thumbnail() ) {
        
        $thumb = wp_get_attachment_url( get_post_thumbnail_id() );
        $attrs = array();

        $attrs[] = 'data-html="' . esc_attr( $code_result ). '"';
        $attrs[] = 'data-video-type="' . esc_attr( $case ). '"';
        $attrs[] = 'class="wi-video-wrapper video-has-thumbnail"';

        $attrs = join( ' ', $attrs );

        echo '<div ' . $attrs . '><div class="video-container"><div class="video-thumb" style="background-image:url(' . esc_url( $thumb ) . ')"></div><span class="video-format-indicator"></span></div></div>';
    
    } else {
        
        echo '<div class="media-container">' . $code_result . '</div>';
    
    }
    
}
endif;

if ( ! function_exists( 'wi_format_indicator' ) ) :
/**
 * Format Indicator
 *
 * @since 2.8
 */
function wi_format_indicator() {
    
    $format = get_post_format();
    
    if ( 'video' === $format ) {
        echo '<span class="video-format-indicator"></span>';
    }
    
    if ( 'gallery' === $format ) {
        echo '<span class="post-format-indicator gallery-format-indicator"><span class="ic-gallery"></span></span>';
    }
    
    if ( 'link' === $format ) {
        echo '<span class="post-format-indicator link-format-indicator"><i class="fa fa-external-link-alt"></i></span>';
    }
    
    if ( 'audio' === $format ) {
        echo '<span class="post-format-indicator audio-format-indicator"><i class="fa fa-volume-up"></i></span>';
    }
    
    
}
endif;

if ( ! function_exists( 'wi_pagination' ) ) :
/**
 * Pagination
 *
 * @since 1.0
 */
function wi_pagination( $query = false ) {
    
    if ( ! $query ) {
        global $wp_query;
        $query = $wp_query;
    }
    
    $prev_label = esc_html__( 'Previous', 'wi' );
    $next_label = esc_html__( 'Next &raquo;', 'wi' );
    
    $big = 999999999; // need an unlikely integer
	$pagination = paginate_links( array(
		'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
		'format' => '?paged=%#%',
		'current' => ( is_front_page() && ! is_home() ) ? max( 1, get_query_var('page') ) : max( 1, get_query_var('paged') ),
		'total' => $query->max_num_pages,
		'type'			=> 'plain',
		'before_page_number'	=>	'<span>',
		'after_page_number'	=>	'</span>',
		'prev_text'    => '<span>' . $prev_label . '</span>',
		'next_text'    => '<span>' . $next_label . '</span>',
	) );
	
	if ( $pagination ) {
        echo '<div class="wi-pagination"><div class="pagination-inner">' . $pagination  . '<div class="clearfix"></div></div></div>';
	}

}
endif;

if ( ! function_exists( 'wi_comment_nav' ) ) :
/**
 * Comment Nav
 *
 * @since 2.8
 */
function wi_comment_nav( $pos ) {

    if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // Are there comments to navigate through? ?>
    <nav id="comment-nav-<?php echo esc_attr( $pos ); ?>" class="navigation comment-navigation" role="navigation">
        <h2 class="screen-reader-text"><?php esc_html_e( 'Comment navigation', 'wi' ); ?></h2>
        <div class="nav-links">

            <div class="nav-previous"><?php previous_comments_link( esc_html__( 'Older Comments', 'wi' ) ); ?></div>
            <div class="nav-next"><?php next_comments_link( esc_html__( 'Newer Comments', 'wi' ) ); ?></div>

        </div><!-- .nav-links -->
    </nav><!-- #comment-nav-# -->
    <?php endif; // Check for comment navigation.
    
}
endif;

if ( ! function_exists( 'wi_page_links' ) ) :
/**
 * Page Links
 *
 * @since 2.8
 */
function wi_page_links() {
    
    wp_link_pages( array(
        'before'      => '<div class="page-links-container"><div class="page-links"><span class="page-links-label">' . esc_html__( 'Pages:', 'wi' ) . '</span>',
        'after'       => '</div></div>',
        'link_before' => '<span class="page-number">',
        'link_after'  => '</span>',
    ) );
    
}
endif;

if ( ! function_exists( 'wi_comment_link' ) ) :
/**
 * Comment Link
 *
 * @since 2.8
 */
function wi_comment_link() {
    
    comments_popup_link( 
        '<span class="ic-comment"><span class="line-inside"></span></span>',
        
        
        '<u>1</u> <span class="ic-comment"><span class="line-inside"></span></span>',
        
        
        '<u>%s</u> <span class="ic-comment"><span class="line-inside"></span></span>',
        
        'comment-link',
        
        '<span class="ic-comment off"><span class="line-inside"></span></span>'
    ); 

}
endif;

if ( ! function_exists( 'wi_comment_text_link' ) ) :
/**
 * Comment Text Link
 *
 * @since 2.8
 */
function wi_comment_text_link() {
    
    comments_popup_link(); 
    
}
endif;

if ( ! function_exists( 'wi_get_view' ) ) :
/**
 * return number of view
 * since 3.0
 */
function wi_get_view( $post_id = null ) {
    if ( ! $post_id ) {
        global $post;
        $post_id =  $post->ID;
    }
    return number_format_i18n( pvc_get_post_views( $post_id ) );
}
endif;

if ( ! function_exists( 'wi_view_count' ) ) :
/**
 * Displays view count
 * @since 2.8
 */
function wi_view_count() {
    
    $count = wi_get_view();
    echo '<span class="entry-view-count" title="' . sprintf( esc_html__( '%s views', 'wi' ), $count ) . '"><span>' . sprintf( esc_html__( '%s views', 'wi' ), $count ) . '</span></span>';
    
}
endif;

if ( ! function_exists( 'wi_comment' ) ) :
/**
 * Displays Comment in single
 *
 * @since 2.8
 */
function wi_comment() {
    
    // If comments are open or we have at least one comment, load up the comment template.
    if ( comments_open() || get_comments_number() ) :
        comments_template();
    endif;

}
endif;

if ( ! function_exists( 'wi_comment_hidden' ) ) :
/**
 * Displays comment in single
 *
 * @since 2.9
 */
function wi_comment_hidden() {
    ?>

<div class="comment-hidden">
    
    <button class="show-comment-btn wi-btn"><?php echo esc_html__( 'Show comments', 'wi' ); ?></button>
    
    <?php
    // If comments are open or we have at least one comment, load up the comment template.
    if ( comments_open() || get_comments_number() ) :
        comments_template();
    endif;
    ?>
    
</div><!-- .comment-hidden -->
    <?php
}
endif;

if ( ! function_exists( 'wi_autoload_post_navigation' ) ) :
/**
 * The Post Navigation in autoload mode
 *
 * @since 2.9
 */
function wi_autoload_post_navigation() {
    
    if ( ! wi_autoload() ) return; ?>
<div class="autoload-nav">
    <div class="container">
        
        <?php the_post_navigation(); ?>
        
    </div>
</div><!-- .autoload-nav -->
<?php }
endif;
    
if ( ! function_exists( 'wi_post_navigation' ) ) :
/**
 * The Post Navigation
 *
 * @since 2.9
 */
function wi_post_navigation() {
    
    if ( wi_autoload() ) return;
    
    $show_nav = get_post_meta( get_the_ID(), '_wi_post_navigation', true );
    if ( ! $show_nav ) $show_nav = get_option( 'wi_single_post_navigation', 'true' );
    if ( 'true' !== $show_nav ) return;
                                 
?>

<div class="wi-post-navigation">

    <?php the_post_navigation( array(
            'next_text' => '<span class="meta-nav" aria-hidden="true">' . __( 'Next Post', 'wi' ) . '<i class="fa fa-caret-right"></i></span> ' .
                '<span class="screen-reader-text">' . __( 'Next Post:', 'wi' ) . '</span> ' .
                '<span class="post-title">%title</span>',
            'prev_text' => '<span class="meta-nav" aria-hidden="true"><i class="fa fa-caret-left"></i>' . __( 'Previous Post', 'wi' ) . '</span> ' .
                '<span class="screen-reader-text">' . __( 'Previous Post:', 'wi' ) . '</span> ' .
                '<span class="post-title">%title</span>',
        ) ); ?>

</div><!-- .wi-post-navigation -->
    <?php
}
endif;

if ( ! function_exists( 'wi_author_social' ) ) :
/**
 * Author Social List
 *
 * @since 2.8
 */
function wi_author_social( $author_id = null ) {
    
    ?>
    <ul class="social-list">
        <?php $short_social_arr = 'twitter, instagram, facebook-square, snapchat, pinterest-p, tumblr, linkedin, youtube, vimeo, soundcloud, flickr, google-plus';
        $short_social_arr = explode(',',$short_social_arr);
        $short_social_arr = array_map('trim',$short_social_arr);
        ?>
        <?php foreach ( $short_social_arr as $sc ): ?>
            <?php if ( $url = get_the_author_meta( $sc, $author_id ) ): ?>
            <?php if ($sc == 'google-plus') $rel = 'publisher'; else $rel = 'alternate'; ?>
            <li><a href="<?php echo esc_url($url);?>" rel="<?php echo esc_attr($rel);?>" target="_blank"><i class="fas fa-<?php echo esc_attr($sc);?>"></i></a></li>

            <?php endif; ?>
        <?php endforeach; ?>
    </ul>
    <?php
}
endif;

if ( ! function_exists( 'wi_entry_share' ) ) :
/**
 * Entry Share
 *
 * @since 2.8
 */
function wi_entry_share() {
    
    $title = trim( get_the_title() );
    $title = strip_tags( $title );
    $url = get_permalink();
    $image = '';
    $via = trim( get_option( 'wi_twitter_username' ) );
    if ( has_post_thumbnail() ) {
        $image = wp_get_attachment_thumb_url();
    }

?>

<div class="entry-share">
    
    <span class="share-label"><?php echo esc_html__( 'Share', 'wi' ); ?></span>
    
    <div class="share-list">

        <ul>
            
            <li class="li-facebook">

                <?php
                $href = 'https://www.facebook.com/sharer/sharer.php?u=' . urlencode( $url );
                if ( $image ) {
                    $href .= '&amp;p[images][0]=' . urlencode( $image );
                }
                ?>

                <a data-href="<?php echo esc_url( $href ); ?>" title="<?php echo esc_html__( 'Facebook','wi' ); ?>" class="share share-facebook">
                    <span><?php echo esc_html__( 'Share', 'wi' ); ?></span>
                    <i class="fab fa-facebook"></i>
                </a>

            </li>

            <li class="li-twitter">

                <?php
                $href = 'https://twitter.com/intent/tweet?url=' . urlencode($url) .'&amp;text=' . $title;
                if ( $via ) {
                    $href .= '&amp;via=' . urlencode( $via );
                }
                ?>

                <a data-href="<?php echo esc_url( $href ); ?>" title="<?php echo esc_html__( 'Twitter','wi' ); ?>" class="share share-twitter">
                    <span><?php echo esc_html__( 'Tweet', 'wi' ); ?></span>
                    <i class="fab fa-twitter"></i>
                </a>

            </li>

            <li class="li-pinterest">

                <?php
                $href = 'http://pinterest.com/pin/create/button/?url=' . urlencode($url) . '&amp;description=' . $title;
                if ( $image ) {
                    $href .= '&amp;media=' . urlencode($image);
                }
                ?>

                <a data-href="<?php echo esc_url( $href ); ?>" title="<?php echo esc_html__( 'Pinterest','wi' ); ?>" class="share share-pinterest">
                    <span><?php echo esc_html__( 'Pin', 'wi' ); ?></span>
                    <i class="fab fa-pinterest"></i>
                </a>

            </li>

            <li class="li-email">

                <?php
                $href = 'mailto:?subject=' . urlencode($title) . '&amp;body=' . rawurlencode($url);
                ?>

                <a href="<?php echo esc_url( $href ); ?>" title="<?php echo esc_html__( 'Email','wi' ); ?>" class="email-share">

                    <span><?php echo esc_html__( 'Email', 'wi' ); ?></span>
                    <i class="fa fa-envelope"></i>

                </a>

            </li>

        </ul>
        
    </div>

</div><!-- .entry-share -->

<?php

}
endif;

/* -------------------------------------------------------------------- */
/* SHARE BUTTONS
/* -------------------------------------------------------------------- */
if ( !function_exists('wi_share') ) {
function wi_share($comment = false) {
    
    global $wp_query;
	if (in_the_loop() || is_single() || is_page()) {$url = get_permalink();}
    elseif (is_category() || is_tag()) {
        $url = get_term_link(get_queried_object());
    } else {
        return;
    }
    
    $title = trim( get_the_title() );
    $title = strip_tags( $title );
    
    $image = '';
    if ( has_post_thumbnail() ) {
        $image = wp_get_attachment_thumb_url();
    }
    $via = trim( get_theme_mod( 'wi_twitter_username' ) );
    
    $share_icons = get_theme_mod( 'wi_share_icons', 'facebook,twitter,pinterest,linkedin,email' );
    $share_icons = explode( ',',$share_icons );
    $share_icons = array_map( 'trim', $share_icons );
    $share_icons = array_slice( $share_icons, 0, 5 );
    
    if ($comment && !get_theme_mod('wi_disable_blog_comment') ) {
        $column = count( $share_icons ) + 1;
    } else {
        $column = count( $share_icons ); 
    }

?>

<div class="post-share share-<?php echo $column; ?>">
    
    <h4 class="share-label"><?php echo esc_html__( 'Share This', 'wi' ); ?></h4>
    
    <ul>
        <?php if ($comment && !get_theme_mod('wi_disable_blog_comment')):?>
        <li class="li-comment">
            <?php
        comments_popup_link( 
            '<i class="fa fa-comment"></i><span>' . __('No comments','wi') . '</span>', 
            '<i class="fa fa-comment"></i><span>' . __('1 comment','wi') . '</span>', 
            '<i class="fa fa-comment"></i><span>' . __('% comments','wi') . '</span>', 
            '',
            '<i class="fa fa-comment"></i><span>' . __('Off','wi') . '</span>'
        ); ?>
        </li>
        <?php endif; ?>
        
        <?php foreach ( $share_icons as $icon ) {
            if ( 'google' == $icon ) {
                $ic = 'google-plus';
                $label = 'Google+';
            } else {
                $ic = $icon;
                $label = ucfirst( $icon );
            }
        ?>
        
        <li class="li-<?php echo $ic; ?>">
            
            <?php 
            
            if ( 'facebook' == $icon ) {
                $href = 'https://www.facebook.com/sharer/sharer.php?u=' . urlencode( $url );
                if ( $image ) {
                    $href .= '&amp;p[images][0]=' . urlencode( $image );
                }
            } elseif ( 'twitter' == $icon ) {
                $href = 'https://twitter.com/intent/tweet?url=' . urlencode($url) .'&amp;text=' . urlencode( html_entity_decode( $title ) );
                if ( $via ) {
                    $href .= '&amp;via=' . urlencode( $via );
                }
            } elseif ( 'google' == $icon ) {
                
                $href = 'https://plus.google.com/share?url=' . urlencode( $url );
                
            } elseif ( 'pinterest' == $icon ) {
                
                $href = 'https://pinterest.com/pin/create/button/?url=' . urlencode($url) . '&amp;description=' . urlencode( html_entity_decode( $title ) );
                if ( $image ) {
                    $href .= '&amp;media=' . urlencode($image);
                }
                
            } elseif ( 'linkedin' == $icon ) {
                
                $href = 'https://www.linkedin.com/shareArticle?mini=true&url=' . urlencode( $url ) . '&amp;title=' . urlencode( html_entity_decode( $title ) );
            
            } elseif ( 'whatsapp' == $icon ) {
            
                $href = 'https://api.whatsapp.com/send?phone=&text=' . urlencode( $url );
            
            } elseif ( 'email' == $icon ) {
            
                $href = 'mailto:?subject=' . urlencode($title) . '&amp;body=' . rawurlencode($url);
            
            }
            
            ?>
            
            <?php if ( 'email' == $icon ) { ?>
            
            <a href="<?php echo esc_url( $href ); ?>" title="<?php echo esc_html__( 'Email','wi' ); ?>" class="email-share">

                <i class="fa fa-envelope"></i>
                <span><?php echo esc_html__( 'Email', 'wi' ); ?></span>

            </a>
            
            <?php } else { ?>
            
            <a data-href="<?php echo esc_url( $href ); ?>" title="<?php echo $label;?>" class="share share-<?php echo $icon; ?>">
                
                <i class="fa fa-<?php echo $ic; ?>"></i>
                <span><?php echo $label; ?></span>
            
            </a>
            
            <?php } ?>
        
        </li>
        
        <?php } ?>
        
    </ul>
    
</div>    
<?php  
}
}

if ( ! function_exists( 'wi_ad_spot' ) ) :
/**
 * Ad Spot
 * @since 2.8
 */
function wi_ad_spot( $spot = 'header' ) {
    
    $ad_type = get_option( 'wi_' . $spot . '_ad_type', 'image' );
    if ( 'code' === $ad_type ) {
        $ad_code = trim( get_option( 'wi_' . $spot . '_ad_code' ) );
        if ( $ad_code ) {
            echo '<div class="wi-' . $spot . '-ad wi-ad wi-ad-code">' . $header_ad_code . '</div>';
        }
    } else {

        $ad_desktop = get_option( 'wi_' . $spot . '_ad_desktop' );
        $ad_tablet = get_option( 'wi_' . $spot . '_ad_tablet' );
        if ( ! $ad_tablet ) $ad_tablet = $ad_desktop;
        $ad_phone = get_option( 'wi_' . $spot . '_ad_phone' );
        if ( ! $ad_phone ) $ad_phone = $ad_tablet;
        
        $ad_url = trim( get_option( 'wi_' . $spot . '_ad_url' ) );
        $ad_url_target = get_option( 'wi_' . $spot . '_ad_url_target', '_blank' );
        if ( '_self' !== $ad_url_target ) $ad_url_target = '_blank';
        
        if ( $ad_desktop ) {
        ?>

<div class="<?php echo esc_attr( 'wi-ad-banner ' . $spot . '-ad ' . $spot . '-ad-banner' ); ?>">
    
    <?php if ( $ad_url ) { ?>
    <a href="<?php echo esc_url( $ad_url ); ?>" target="<?php echo esc_attr( $ad_url_target ); ?>">
    <?php } ?>
        
        <div class="show_on_desktop">
            <img src="<?php echo esc_url( $ad_desktop ); ?>" alt="<?php echo esc_html__( 'Banner', 'wi' ); ?>" />
        </div>
        
        <div class="show_on_tablet_landscape">
            <img src="<?php echo esc_url( $ad_desktop ); ?>" alt="<?php echo esc_html__( 'Banner', 'wi' ); ?>" />
        </div>
        
        <div class="show_on_tablet_portrait">
            <img src="<?php echo esc_url( $ad_tablet ); ?>" alt="<?php echo esc_html__( 'Banner Tablet', 'wi' ); ?>" />
        </div>
        
        <div class="show_on_phone">
            <img src="<?php echo esc_url( $ad_phone ); ?>" alt="<?php echo esc_html__( 'Banner Phone', 'wi' ); ?>" />
        </div>
        
    <?php if ( $ad_url ) { ?>
    </a>
    <?php } ?>    
        
</div>
        
        <?php
        }
    
    }
    
}
endif;

/* COOL POST
------------------------------------------------------------------------------------------ */
if ( ! function_exists( 'wi_is_cool_post' ) ) :
/**
 * Check if we are displaying a cool post
 * @since 2.9
 */
function wi_is_cool_post() {
    
    return get_theme_mod( 'wi_cool_post_all' ) || ( 'true' == get_post_meta( get_the_ID(), '_wi_cool', true ) );
    
}
endif;

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

// since 2.9
add_filter( 'body_class', 'wi_single_body_class' );
function wi_single_body_class( $class ) {

    if ( is_singular() ) {
    
        if ( wi_is_cool_post() ) {
            $class[] = 'cool-post';
            
            $cool_thumbnail_size = get_post_meta( get_the_ID(), '_wi_cool_thumbnail_size', true );
            if ( ! $cool_thumbnail_size ) {
                $cool_thumbnail_size = get_theme_mod( 'wi_cool_thumbnail_size', 'big' );
            }
            
            if ( 'full' != $cool_thumbnail_size ) $cool_thumbnail_size = 'big';
            $class[] = 'cool-thumbnail-size-' . $cool_thumbnail_size ;
        
        }
        
        // hero header
        // @since 3.0
        $hero = wi_hero();
        if ( 'full' == $hero || 'half' == $hero ) {
            $class[] = 'post-hero';
        }
        if ( 'full' == $hero ) {
            $class[] = 'post-hero-full';
        } elseif ( 'half' == $hero ) {
            $class[] = 'post-hero-half';
        }
    
    }
    
    return $class;
    
}

add_filter( 'wi_sidebar_state', 'wi_cool_post_sidebar_state' );
function wi_cool_post_sidebar_state( $state ) {
    
    if ( is_singular() && wi_is_cool_post() ) {
        
        return 'no-sidebar';
            
    }
    
    return $state;
    
}

/* AUTOLOAD NEXT POST
------------------------------------------------------------------------------------------ */
if ( ! function_exists( 'wi_autoload' ) ) :
/**
 * Check if autoload option enabled
 * @since 2.9
 */
function wi_autoload() {
    
    return get_theme_mod( 'wi_autoload_post' );
    
}
endif;

/* RELATED POSTS SOURCE
------------------------------------------------------------------------------------------ */
if ( ! function_exists( 'wi_related_jetpack' ) ) :
/**
 * Check if related posts source from Jetpack
 * @since 2.9
 */
function wi_related_jetpack() {
    
    return 'jetpack' === get_theme_mod( 'wi_related_source' ) && class_exists( 'Jetpack_RelatedPosts' ) && method_exists( 'Jetpack_RelatedPosts', 'init_raw' );
    
}
endif;

if ( ! function_exists( 'wi_jetpackme_remove_rp' ) ):
/**
 * Remove Jetpack Related Posts
 *
 * @since 2.9
 */
function wi_jetpackme_remove_rp() {
    
    if ( wi_related_jetpack() ) {
    
        $jprp = Jetpack_RelatedPosts::init();
        $callback = array( $jprp, 'filter_add_target_to_dom' );
        remove_filter( 'the_content', $callback, 40 );
        
    }
    
}
add_filter( 'wp', 'wi_jetpackme_remove_rp', 20 );
endif;