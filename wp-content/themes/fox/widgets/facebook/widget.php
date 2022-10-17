<?php
extract( $args );
extract( wp_parse_args( $instance, array(
    'title' => '',
    'url' => 'https://www.facebook.com/withemes',
    'show_faces' => '',
    'stream' => '',
    'header' => '',
) ) );
echo $before_widget;

$title = apply_filters( 'widget_title', $title, $instance, $this->id_base );
if ( !empty( $title ) ) {	
    echo $before_title . $title . $after_title;
}

wp_enqueue_script('wi-facebook');
		
$like_box_xfbml = "<fb:like-box href=\"$url\" width=\"265\" show_faces=\"$show_faces\" colorscheme=\"light\" border_color=\"#000\" stream=\"$stream\" header=\"$header\"></fb:like-box>";
echo '<div class="fb-container">' . $like_box_xfbml . '</div>';

echo $after_widget;