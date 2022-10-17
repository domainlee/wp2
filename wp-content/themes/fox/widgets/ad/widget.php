<?php
extract( $args );
extract( wp_parse_args( $instance, array(
    'title' => '',
    'image' => '',
    'url' => '',
    'code' => '',
) ) );
echo $before_widget;

$title = apply_filters( 'widget_title', $title, $instance, $this->id_base );
if ( !empty( $title ) ) {	
    echo $before_title . $title . $after_title;
}

echo '<div class="ad-container">';
			
if (trim($code)) : 
    echo trim($code);
else:

    if (trim($url)) echo '<a href="'.esc_url(trim($url)).'" target="_blank">';

    if ( is_numeric( $image ) ) $image = wp_get_attachment_url( $image );

    if ( $image ) echo '<img src="'.esc_url($image).'" alt="'.basename($image).'" />';

    if (trim($url)) echo '</a>';

endif; // ad code

echo '<div class="clearfix"></div></div>';	// ad-container

echo $after_widget;