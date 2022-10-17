<?php
/** 
*  Add the endpoint for the call to get the post html only
**/

function alnp_add_endpoint() {
    add_rewrite_endpoint( 'partial', EP_PERMALINK );
}

add_action( 'init', 'alnp_add_endpoint' );

/**
* When /partial endpoint is used on a post, get just the post html
**/
function alnp_template_redirect() {
    global $wp_query;
 
    // if this is not a request for partial or a singular object then bail
    if ( ! isset( $wp_query->query_vars['partial'] ) || ! is_singular() )
        return;
 
	// include custom template
    include get_parent_theme_file_path( '/loop/content-partial.php' );

    exit;
}

add_action( 'template_redirect', 'alnp_template_redirect' );

function partial_endpoints_activate() {

    // ensure our endpoint is added before flushing rewrite rules
    alnp_add_endpoint();
    
    // flush rewrite rules - only do this on activation as anything more frequent is bad!
    flush_rewrite_rules();
}

register_activation_hook( __FILE__, 'partial_endpoints_activate' );
 

function partial_endpoints_deactivate() {
    // flush rules on deactivate as well so they're not left hanging around uselessly
    flush_rewrite_rules();
}

register_deactivation_hook( __FILE__, 'partial_endpoints_deactivate' );