<?php
extract( $args );
extract( wp_parse_args( $instance, array(
    'title' => '',
    'username' => '',
    'number' => '',
    'column' => '',
    'size' => '',
    'space' => '4',
    'cache_time' => '',
    'follow_text' => '',
) ) );
echo $before_widget;

$title = apply_filters( 'widget_title', $title, $instance, $this->id_base );
if ( !empty( $title ) ) {	
    echo $before_title . $title . $after_title;
}

$photos = '';
if ( function_exists( 'wi_get_instagram_photos' ) ) {
    $photos = wi_get_instagram_photos( $username, $number, $cache_time );
}

if ( $photos && is_array( $photos ) ) {
    
    // column
    $column = absint( $column );
    if ( $column < 2 || $column > 9 ) {
        $column = 3;
    }

    // space
    $space = absint( $space ) / 2;
    
    ?>

    <div class="wi-instagram-widget column-<?php echo absint( $column ); ?>">

        <ul style="<?php echo 'margin:' . (-$space ) . 'px'; ?>;">

            <?php foreach ( $photos as $photo ) {
        
                $src = '';
                if ( 'large' == $size ) {
                    $src = isset( $photo[ 'large' ] ) ? $photo[ 'large' ] : '';
                }
                if ( 'medium' == $size || ( 'large' == $size && ! $src ) ) {
                    $src = isset( $photo[ 'small' ] ) ? $photo[ 'small' ] : '';
                }
                if ( 'thumbnail' == $size || ( 'medium' == $size && ! $src ) || ( 'large' == $size && ! $src ) ) {
                    $src = isset( $photo[ 'thumbnail' ] ) ? $photo[ 'thumbnail' ] : '';
                }
                if ( ! $src ) $src = $photo[ 'thumbnail' ];
                if ( ! $src ) continue;
        
            ?>
            
            <li style="<?php echo 'padding:' . $space . 'px'; ?>;">
            
                <?php if ( isset( $photo[ 'link' ] ) ) {
                    echo '<a href="' . esc_url( $photo[ 'link' ] ) . '" target="_blank" title="' . esc_attr( $photo[ 'description' ] ). '">';
                    } ?>
                
                <img src="<?php echo esc_url( $src ); ?>" alt="<?php echo esc_attr( $photo[ 'description' ] ); ?>" width="150" height="150" />
                
                <span class="photo-text">
                    <span class="like-count">
                        <i class="fa fa-heart"></i>
                        <?php echo absint( $photo[ 'likes' ] ); ?>
                    </span>

                    <span class="comment-count">
                        <?php echo absint( $photo[ 'comments' ] ); ?>
                    </span>
                </span>
                
                <?php if ( isset( $photo[ 'link' ] ) ) {
                echo '</a>';
                    } ?>
            
            </li>
            
            <?php } ?>

        </ul>
        
        <?php $follow_text = trim( $follow_text ); if ( '' != $follow_text ) : ?>
        
        <div class="instagram-button">
            
            <a href="<?php echo esc_url( 'https://www.instagram.com/' . $username ); ?>" target="_blank" class="follow-us"><?php echo esc_attr( $follow_text ); ?></a>
            
        </div>
        
        <?php endif; ?>

    </div><!-- .wi-instagram -->

    <?php
    
}

echo $after_widget;