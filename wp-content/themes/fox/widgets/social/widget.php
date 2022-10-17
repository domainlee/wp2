<?php
extract( $args );
extract( wp_parse_args( $instance, array(
    'title' => '',
) ) );
echo $before_widget;

$title = apply_filters( 'widget_title', $title, $instance, $this->id_base );
if ( !empty( $title ) ) {	
    echo $before_title . $title . $after_title;
}

echo '<div class="widget-social"><ul>';
        
    wi_social_list();

echo '</ul><div class="clearfix"></div></div>';

echo $after_widget;