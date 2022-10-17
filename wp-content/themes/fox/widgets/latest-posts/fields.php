<?php
$cat_arr = array( '' => 'All' );
$tag_arr = array( '' => 'All' );
$categories = get_categories();
foreach ( $categories as $cat ) {
    $cat_arr[ strval( $cat->term_id ) ] = $cat->name;
}

$args = array('taxonomy'=>'post_tag', 'number' => 1000 );
$categories = get_categories( $args );
foreach ( $categories as $cat ) {
    $tag_arr[ strval( $cat->term_id ) ] = $cat->name;
}

$fields = array(
    
    array(
        'id' => 'title',
        'type' => 'text',
        'name' => esc_html__( 'Title', 'wi' ),
        'std' => 'Latest Posts',
    ),
    
    array(
        'id' => 'number',
        'name' => esc_html__( 'Number of posts to show', 'wi' ),
        'std'   => 4,
        'type' => 'text',
    ),
    
    array(
        'id' => 'category',
        'name' => esc_html__( 'Category', 'wi' ),
        'type' => 'select',
        'options' => $cat_arr,
    ),
    
    array(
        'id' => 'tag',
        'name' => esc_html__( 'Tag', 'wi' ),
        'type' => 'select',
        'options' => $tag_arr,
    ),
    
    array(
        'id' => 'show_excerpt',
        'name' => esc_html__( 'Show excerpt?', 'wi' ),
        'type' => 'checkbox',
    ),
    
    array(
        'id' => 'layout',
        'name' => esc_html__( 'Layout', 'wi' ),
        'type' => 'select',
        'options' => array(
            'small' => 'Small Image',
            'big' => 'Big Image',
        ),
        'std' => 'small',
    ),
    
);