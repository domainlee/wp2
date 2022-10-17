<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="profile" href="http://gmpg.org/xfn/11">
    
	<!--[if lt IE 9]>
	<script src="<?php echo esc_url( get_template_directory_uri() ); ?>/js/html5.js"></script>
	<![endif]-->
    
    <?php wp_head(); ?>
    
</head>

<body <?php body_class(); ?> itemscope itemtype="https://schema.org/WebPage">
<div id="wi-all">
    
    <?php do_action( 'wi_before_single' ); ?>

    <div id="wi-wrapper">
        
        <?php 
        $header_layout = get_theme_mod( 'wi_header_layout', 'stack1' );
        if ( $header_layout != 'stack2' && $header_layout != 'inline' ) $header_layout = 'stack1';

        $header_class = array( 'site-header' );
        if ( 'inline' == $header_layout ) {
            $header_class[] = 'header-inline';
        } else {
            $header_class[] = 'header-stack';
            if ( 'stack1' == $header_layout ) {
                $header_class[] = 'header-logo-below';
            } else {
                $header_class[] = 'header-logo-above';
            }
        }
        $header_class = join( ' ', $header_class );
        ?>
        
        <header id="masthead" class="<?php echo esc_attr( $header_class ); ?>" itemscope itemtype="https://schema.org/WPHeader">
            
            <?php if ( $header_layout == 'stack1' || $header_layout == 'stack2' ) { ?>
            
            <?php if ( $header_layout == 'stack2' ) { wi_main_header(); } ?>
            
            <div id="topbar-wrapper" class="header-sticky-wrapper">
                
                <div class="wi-topbar header-sticky-element" id="wi-topbar">
                    
                    <div class="container">

                        <div class="topbar-inner">
                            
                            <?php wi_navigation(); ?>

                        </div><!-- .topbar-inner -->

                    </div><!-- .container -->

                </div><!-- #wi-topbar -->
                
            </div><!-- #topbar-wrapper -->
            
            <?php if ( $header_layout == 'stack1' ) { wi_header_searchbox(); wi_main_header(); } ?>
            
            <?php } else { ?>
            
            <div class="header-inline-wrapper header-sticky-wrapper">
                
                <div class="header-inline-inner header-sticky-element">

                    <div class="container main-container">

                        <?php wi_site_branding(); ?>
                        <?php wi_navigation(); ?>

                    </div><!-- .container -->

                </div>
                
            </div>
            
            <?php wi_header_searchbox(); ?>
            
            <?php } // header layout ?>
            
            <?php if ( $header_layout == 'stack2' ) { wi_header_searchbox(); } ?>
            
        </header><!-- #masthead -->
        
        <?php do_action( 'wi_after_header' ); ?>
    
        <div id="wi-main">