<?php
/**
 * Post View Plugin Concerning
 */
add_filter( 'pvc_most_viewed_posts_html', 'wi_custom_most_viewed_posts_html', 10, 2 );

/**
 * @since 2.9
 */
function wi_custom_most_viewed_posts_html( $html, $args ) {
    
    $defaults = array(
        'number_of_posts'		 => 5,
        'post_type'				 => array( 'post' ),
        'order'					 => 'desc',
        'thumbnail_size'		 => 'thumbnail',
        'show_post_views'		 => true,
        'show_post_thumbnail'	 => false,
        'show_post_excerpt'		 => false,
        'no_posts_message'		 => esc_html__( 'No Posts', 'wi' ),
        'item_before'			 => '',
        'item_after'			 => ''
    );

    $args = apply_filters( 'pvc_most_viewed_posts_args', wp_parse_args( $args, $defaults ) );

    $args['show_post_views'] = (bool) $args['show_post_views'];
    $args['show_post_thumbnail'] = (bool) $args['show_post_thumbnail'];
    $args['show_post_excerpt'] = (bool) $args['show_post_excerpt'];

    $posts = pvc_get_most_viewed_posts(
    array(
        'posts_per_page' => (isset( $args['number_of_posts'] ) ? (int) $args['number_of_posts'] : $defaults['number_of_posts']),
        'order'			 => (isset( $args['order'] ) ? $args['order'] : $defaults['order']),
        'post_type'		 => (isset( $args['post_type'] ) ? $args['post_type'] : $defaults['post_type'])
    )
    );
    
    $html = '';
    
    global $post;

    if ( ! empty( $posts ) ) {
        $html = '
    <ul>';
        
        $count = 0;

        foreach ( $posts as $post ) {
            setup_postdata( $post );
            $count++;

            $html .= '
        <li>';

            $html .= apply_filters( 'pvc_most_viewed_posts_item_before', $args['item_before'], $post );

            if ( $args['show_post_thumbnail'] ) {
                $html .= '
                <div class="popular-thumbnail-container">' . wi_display_thumbnail( $args['thumbnail_size'] ,'popular-thumbnail',true,true, false, false ) . 
                
                ($args['show_post_views'] ? ' <span class="view-count">' . sprintf( esc_html__( '%s views', 'wi' ), number_format_i18n( pvc_get_post_views( $post->ID ) ) ) . '</span>' : '') .
                
                '<span class="popular-counter">' . sprintf('%02d',$count) . '</span></div>';
            }

            $html .= '
                <h3 class="popular-title"><a href="' . get_permalink( $post->ID ) . '">' . get_the_title( $post->ID ) . '</a></h3>';

            $excerpt = '';

            if ( $args['show_post_excerpt'] ) {
                
                $html .= '

            <div class="popular-excerpt"><p>' . wi_subword(get_the_excerpt(),0,20) . ' &hellip; <a href="' . get_permalink() . '" class="readmore">' . esc_html__( 'More','wi' ) . '</a></p></div>';
                
            }

            $html .= apply_filters( 'pvc_most_viewed_posts_item_after', $args['item_after'], $post );

            $html .= '
        </li>';
        }

        wp_reset_postdata();

        $html .= '
    </ul>';
    } else
        $html = $args['no_posts_message'];

    return $html;

}