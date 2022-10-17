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
        'std' => 'Best Rated',
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
    
    // since 2.8
    array(
        'id' => 'orderby',
        'name' => esc_html__( 'Orderby', 'wi' ),
        'type' => 'select',
        'options' => array(
            'score' => 'Highest Score',
            'date' => 'Recent Review',
        ),
    ),
    
);