<?php
$fields = array(
    
    array(
        'id' => 'title',
        'type' => 'text',
        'name' => esc_html__( 'Title', 'wi' ),
        'std' => 'About Me',
    ),
    
    array(
        'id' => 'image',
        'name' => esc_html__( 'Image', 'wi' ),
        'type' => 'image',
    ),
    
    array(
        'id' => 'desc',
        'name' => esc_html__( 'Description (Use &lt;br /&gt; to insert new line)', 'wi' ),
        'type' => 'textarea',
    ),
    
);