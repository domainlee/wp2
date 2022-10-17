<?php
extract( $args );
extract( wp_parse_args( $instance, array(
    'title' => '',
    'image' => '',
    'desc' => '',
) ) );
echo $before_widget;

if ( $image ) {
    if ( is_numeric( $image ) ) $image = wp_get_attachment_url( $image );
    echo '<figure class="about-image"><img src="'.esc_url($image).'" alt="'.$name.'" /></figure>';		
}

$title = apply_filters( 'widget_title', $title, $instance, $this->id_base );
if ( !empty( $title ) ) {	
    echo $before_title . $title . $after_title;
}

echo '<div class="widget-about">';

if ( $desc ) {
    echo '<div class="desc">' . do_shortcode($desc) . '</div>';
}

echo '</div><!-- .about-widget -->';

echo $after_widget;