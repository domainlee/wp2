<?php

$numbers = array( '1' => esc_html__( '1 Photo', 'wi' ) );
for ( $i = 2; $i <= 12; $i++ ) {
    $numbers[ (string) $i ] = sprintf( esc_html__( '%d Photos', 'wi' ), $i );
}

$columns = array( '1' => esc_html__( '1 Column', 'wi' ) );
for ( $i = 2; $i <= 9; $i++ ) {
    $columns[ (string) $i ] = sprintf( esc_html__( '%d Columns', 'wi' ), $i );
}

$fields = array(
    
    array(
        'id' => 'title',
        'type' => 'text',
        'name' => esc_html__( 'Title', 'wi' ),
        'std' => '',
    ),
    
    array (
        'id' => 'username',
        'type' => 'text',
        'placeholder' => 'yourusername',
        'name' => esc_html__( 'Instagram Username', 'wi' ),
    ),
    
    array(
        'id' => 'number',
        'type' => 'select',
        'options'=> $numbers,
        'std'   => '9',
        'name' => esc_html__( 'Number of photos', 'wi' ),
    ),
    
    array(
        'id' => 'column',
        'type' => 'select',
        'options'=> $columns,
        'std'   => '3',
        'name' => esc_html__( 'Columns?', 'wi' ),
    ),
    
    array(
        'id' => 'size',
        'type' => 'select',
        'options'=> array(
            'thumbnail' => esc_html__( 'Thumbnail', 'wi' ),
            'medium' => esc_html__( 'Medium', 'wi' ),
            'large' => esc_html__( 'Large', 'wi' ),
        ),
        'std'   => 'thumbnail',
        'name' => esc_html__( 'Image Size', 'wi' ),
    ),
    
    array(
        'id' => 'space',
        'type' => 'text',
        'name' => esc_html__( 'Space Between Photos?', 'wi' ),
        'std' => '4',
        'placeholder' => esc_html__( 'Eg. 4px', 'wi' ),
    ),
    
    array(
        'id' => 'cache_time',
        'type' => 'select',
        'options' => array(
            (string) ( HOUR_IN_SECONDS/ 2 ) => esc_html__( 'Half Hours', 'wi' ),
            (string) ( HOUR_IN_SECONDS ) => esc_html__( 'An Hour', 'wi' ),
            (string) ( HOUR_IN_SECONDS * 2 ) => esc_html__( 'Two Hours', 'wi' ),
            (string) ( HOUR_IN_SECONDS * 4 ) => esc_html__( 'Four Hours', 'wi' ),
            (string) ( DAY_IN_SECONDS ) => esc_html__( 'A Day', 'wi' ),
            (string) ( WEEK_IN_SECONDS ) => esc_html__( 'A Week', 'wi' ),
        ),
        'std'   => (string) ( HOUR_IN_SECONDS * 2 ),
        'name'  => esc_html__( 'Cache Time', 'wi' ),
        'desc'  => esc_html__( 'If you do not often upload new photos, you can set longer caching time to speed up loading time.', 'wi' ),
    ),
    
    array(
        'id' => 'follow_text',
        'type' => 'text',
        'std'   => esc_html__( 'Follow Us', 'wi' ),
        'name'  => esc_html__( 'Follow Text', 'wi' ),
    ),
    
);