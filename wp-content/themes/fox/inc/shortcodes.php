<?php
add_shortcode( 'dropcap', 'wi_dropcap' );
if ( ! function_exists( 'wi_dropcap' ) ) :
/**
 * Dropcap Shortcode
 * @since 2.9
 */
function wi_dropcap( $atts, $content = null ) {
    
    extract( shortcode_atts( array(
        'style' => '',
    ), $atts ) );
    
    if ( $style != 'dark' && $style != 'color' ) $style = 'default';
    
    return '<span class="wi-dropcap dropcap-' . esc_attr( $style ) . '">' . trim( $content ) . '</span>';
    
    
}
endif;

add_shortcode( 'blockquote', 'wi_blockquote_sc' );
if ( ! function_exists( 'wi_blockquote_sc' ) ) :
/**
 * Blockquote Shortcode
 * @since 2.9
 */
function wi_blockquote_sc( $atts, $content = null ) {
    
    extract( shortcode_atts( array(
        'align' => 'center',
        'author' => '',
    ), $atts ) );
    
    if ( $align != 'left' && $align != 'right' ) $align = 'center';
    
    if ( $author ) $author = '<cite>' . $author . '</cite>';
    
    return '<blockquote class="wi-blockquote align-' . esc_attr( $align ) . '">' . trim( $content ) .  $author . '</blockquote>';
    
    
}
endif;