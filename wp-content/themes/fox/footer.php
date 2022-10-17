        </div><!-- #wi-main -->

        <footer id="wi-footer" class="site-footer" itemscope itemtype="https://schema.org/WPFooter">

            <?php if ( is_active_sidebar( 'footer-1' ) || is_active_sidebar( 'footer-2' ) || is_active_sidebar( 'footer-3' ) || is_active_sidebar( 'footer-4' ) ) : ?>

            <div id="footer-widgets">
                <div class="container">
                    <div class="footer-widgets-inner">
                        <?php for ($i=1; $i<=4; $i++): ?>

                        <aside class="footer-col" itemscope itemptype="https://schema.org/WPSideBar">

                            <?php if ( is_active_sidebar( 'footer-' . $i ) ) {
                                dynamic_sidebar( 'footer-' . $i );
                            }?>

                        </aside><!-- .footer-col -->

                        <?php endfor; ?>
                        <div class="clearfix"></div>
                        <div class="line line1"></div>
                        <div class="line line2"></div>
                        <div class="line line3"></div>
                    </div><!-- .footer-widgets-inner -->
                </div><!-- .container -->
            </div><!-- #footer-widgets -->

            <?php endif; ?>

            <div id="footer-bottom" role="contentinfo">

                <div class="container">

                    <?php $footer_logo = get_theme_mod('wi_footer_logo');?>
                    <?php if ($footer_logo):?>
                    <div id="footer-logo">
                        <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
                            <img src="<?php echo esc_url($footer_logo);?>"<?php echo get_theme_mod('wi_footer_logo_retina') ? ' data-retina="'.esc_url(get_theme_mod('wi_footer_logo_retina')).'"' : '';?> alt="Footer logo" />
                        </a>
                    </div>
                    <?php endif; // footer logo ?>

                    <?php if (!get_theme_mod('wi_disable_footer_social')): 
$footer_social_skin = get_theme_mod( 'wi_footer_social_skin', 'black' );
if ( 'outline' != $footer_social_skin ) $footer_social_skin = 'black';
                    ?>
                    <div id="footer-social" class="social-list skin-<?php echo esc_attr( $footer_social_skin ); ?>">
                        <ul>
                            <?php wi_social_list(); ?>
                        </ul>
                    </div><!-- #footer-social -->
                    <?php endif; // footer social ?>


                    <?php if (!get_theme_mod('wi_disable_footer_search') ):?>
                    <div class="footer-search-container">

                        <div class="footer-search" id="footer-search">
                            <form action="<?php echo site_url(); ?>" method="get">

                                <input type="text" name="s" class="s" value="<?php echo get_search_query();?>" placeholder="<?php _e('Search...','wi');?>" />
                                <button class="submit" type="submit"><i class="fa fa-search"></i></button>

                            </form><!-- .searchform -->
                        </div><!-- #footer-search -->
                    </div><!-- .footer-search-container -->

                    <?php endif; // footer search ?>

                    <?php if (!get_theme_mod('wi_copyright')):?>
                    <p class="copyright"><?php _e( 'All rights reserved. Designed by <a href="https://themeforest.net/user/withemes/portfolio?ref=withemes" target="_blank">WiThemes</a>', 'wi' );?></p>
                    <?php else: ?>
                    <p class="copyright"><?php echo wp_kses( get_theme_mod('wi_copyright'), wi_allowed_html() );?></p>
                    <?php endif; ?>

                    <?php

                    /** Since 2.4 */
                    if ( has_nav_menu( 'footer' ) ): ?>

                    <nav id="footernav" class="footernav" role="navigation" itemscope itemtype="https://schema.org/SiteNavigationElement">
                        <?php wp_nav_menu(array(
                            'theme_location'	=>	'footer',
                            'depth'				=>	1,
                            'container_class'	=>	'menu',
                        ));?>
                    </nav><!-- #footernav -->

                    <?php endif; // primary ?>

                </div><!-- .container -->

            </div><!-- #footer-bottom --> 

        </footer><!-- #wi-footer -->

    </div><!-- #wi-wrapper -->

    <div class="clearfix"></div>

</div><!-- #wi-all -->

<?php wp_footer(); ?>

</body>
</html>