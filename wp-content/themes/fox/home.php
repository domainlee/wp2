<?php get_header(); ?>
<?php get_template_part( 'inc/headline' ); ?>

<?php

/* ------------------       SOME PHP STUFFS         ------------------ */
global $wp_query;
$layout = wi_layout();

// loop
$loop = $layout;
if (strpos($loop,'grid')!==false) $loop = 'grid';
if (strpos($loop,'masonry')!==false) $loop = 'masonry';

// column
$column = 2;
if (strpos($layout,'2')!==false) $column = '2';
if (strpos($layout,'3')!==false) $column = '3';
if (strpos($layout,'4')!==false) $column = '4';

$blog_container_class = array('blog-container');
$blog_container_class = join(' ',$blog_container_class);

$blog_class = array('wi-blog','blog-'.$loop,'column-'.$column);
$blog_class = join(' ',$blog_class);

// main stream order
// since 3.0
$main_stream_order = get_theme_mod( 'wi_main_stream_order' );

$max_sections = absint( get_theme_mod( 'wi_max_sections', 10 ) );
if ( $max_sections < 2 || $max_sections > 40 ) $max_sections = 10;
?>

<div class="container">
    
    <div class="content">
        
        <div id="wi-bf" class="all-sections">
            
        <?php if ( ! get_theme_mod( 'wi_disable_builder_paged' ) || ( ( is_front_page() && ! get_query_var( 'paged' ) ) || ( !is_front_page() && get_query_var( 'page' ) ) ) ) : ?>
            
<?php for ( $i=1 ; $i<= $max_sections; $i++ ):

/**
 * main stream order, since 3.0
 */
if ( is_numeric( $main_stream_order ) && ( $main_stream_order + 1 ) === $i ) { 
    include_once 'part/main-stream.php';
}

/**
 * There're 2 types of options for each section
 * query option: display what, how many, order..
 * displaying option: slider/grid/column..
 */

/* ------------------       QUERY          ------------------ */
/**
 * there's problem here. $cat is not actual category. it's a mix with old system
 * $cat is a way of saying which to display. it can be a category, post type..
 */

$prefix = "bf_{$i}_";

$cat = get_theme_mod( "{$prefix}cat" );
if ( ! $cat || 'none' == $cat ) continue;

/**
 * old cat value before v3.0
 */
if ( is_numeric( $cat ) ) {
    $cat_term = get_term( $cat, 'category' );
    if ( ! $cat_term ) continue;
    $cat = 'cat_' . $cat_term->slug;
}

// query args
$args = [
    'ignore_sticky_posts'   =>  true,
    'no_found_rows' => true,
    'cache_results' => false,
];

/**
 * Category
 */
if ( $cat == 'featured' ) {
    
    $args[ 'featured' ] = true;
    
} elseif ( $cat == 'sticky' ) {
    
    $sticky = get_option( 'sticky_posts' );
    if ( !empty($sticky) ) $args['post__in'] = $sticky;
    else $args['p'] = '-1';
    
    $args[ 'post_type' ] = 'any';
    
} elseif ( $cat == 'video' || $cat == 'gallery' || $cat == 'audio' ) {
    
    $args[ 'tax_query' ] = array(
        array(
			'taxonomy' => 'post_format',
			'field'    => 'slug',
			'terms'    => array( 'post-format-' . $cat ),
		),
    );
    
} elseif ( 'post_type_' === substr( $cat, 0, 10 ) ) {
    
    $args[ 'post_type' ] = substr( $cat, 10 );

} elseif ( $cat != 'all' ) {
    
    $cat = str_replace( 'cat_', '', $cat );
    $args[ 'category_name' ] = $cat;
    
}

/**
 * Number
 */
$number = get_theme_mod( "{$prefix}number" );
if ( '' == $number ) $number = 4;
$args[ 'posts_per_page' ] = $number;

/**
 * Offset
 */
$offset = absint( get_theme_mod( "{$prefix}offset" ) );
if ( $offset > 0 ) {
    $args[ 'offset' ] = $offset;
}

/**
 * Order
 */
$orderby = get_theme_mod( "{$prefix}orderby" );
$args[ 'order' ] = 'DESC';

if ( 'date' == $orderby ) {
    $args['orderby'] = 'date';
} elseif ( 'comment' == $orderby ) {
    $args['orderby'] = 'comment_count';
} elseif ( 'random' == $orderby ) {
    $args[ 'orderby' ] = 'rand';
} elseif ( 'view' == $orderby ) {
    
    /**
     * this has been modified since v 3.0
     * due to replacement of new view count plugin
     */
    $args[ 'orderby' ] = 'post_views';
}

$this_query = new WP_Query( $args );

/* ------------------       LAYOUT          ------------------ */
$section_class = array( 'wi-section', 'section-'.$i );

$this_layout = get_theme_mod( "{$prefix}layout" );
if (! $this_layout ) $this_layout = 'slider'; // default layout

$section_class[] = 'section-layout-' . $this_layout;

$this_loop = '';

if ( 'slider' == $this_layout ) {
    $this_loop = 'slider';
} elseif ( 'grid-2' == $this_layout || 'grid-3' == $this_layout || 'grid-4' == $this_layout ) {
    
    $this_loop = 'grid';
    $this_column = absint( str_replace( 'grid-', '', $this_layout ) );
    
} elseif ( 'big-post' == $this_layout ) {
    $this_loop = 'big';
} elseif ( 'list' == $this_layout ) {
    $this_loop = 'list';
} elseif ( 'vertical' == $this_layout ) {
    $this_loop = 'vertical';
} elseif ( 'group-1' == $this_layout ) {
    $this_loop = 'group-1';
} elseif ( 'group-2' == $this_layout ) {
    $this_loop = 'group-2';
}

$section_class[] = 'section-loop-' . $this_loop;

/* ------------------       HEADING          ------------------ */
$heading = trim( get_theme_mod( "{$prefix}heading" ) );
if ( '' != $heading ) {
    $section_class[] = 'section-has-heading';
}

/* ------------------       AD          ------------------ */
$ad_code = trim( get_theme_mod( "{$prefix}ad_code" ) );
if ( $ad_code ) {
    $section_class[] = 'section-has-ad section-ad-code';   
} else {
    $banner = trim( get_theme_mod( "{$prefix}banner" ) );
    $url = trim( get_theme_mod( "{$prefix}banner_url" ) );
    
    if ( $banner ) {
        $section_class[] = 'section-has-ad section-ad-banner';   
    }
}

$section_class = join( ' ', $section_class );
?>
        
        <div class="<?php echo esc_attr( $section_class );?>">

            <?php if ( $ad_code ) { ?>
            <div class="section-ad ad-code">

                <?php echo do_shortcode( $ad_code ); ?>

            </div><!-- .section-ad -->
            <?php } elseif ( $banner ) {
            if ( $url ) {
                $open = '<a href="' . esc_url( $url ) . '" target="_blank">';
                $close = '</a>';
            } else {
                $open = $close = '';
            }
            ?>
            <div class="section-ad ad-banner">
                <?php echo $open; ?>
                <img src="<?php echo esc_url( $banner ); ?>" alt="<?php echo esc_html__( 'Banner', 'wi' ); ?>" />
                <?php echo $close; ?>
            </div><!-- .section-ad -->
            <?php } // has ad ?>

            <?php if ( $heading ) { ?>
            <h2 class="section-heading">

                <span>
                    <?php echo $heading;?>
                </span>

                <?php if ( $link = trim( get_theme_mod( "{$prefix}viewall_link" ) ) ): $viewall_text = get_theme_mod( "{$prefix}viewall_text" ); ?>
                <a href="<?php echo esc_url( $link );?>" class="viewall"><?php echo $viewall_text; ?></a>
                <?php endif; ?>

            </h2>
            <?php } // if heading ?>

            <div class="section-main">

                <?php switch( $this_loop ):

                    case 'big':

                        wi_blog_big( $this_query );

                    break;
                    case 'slider' :

                        wi_blog_slider( $this_query );

                    break;
                    case 'grid':

                        wi_blog_grid( $this_query, [ 'column' => $this_column ] );

                    break;
                    case 'list':

                        wi_blog_list( $this_query );

                    break;
                    case 'vertical':

                        wi_blog_vertical( $this_query );

                    break;
                    case 'group-1':

                        wi_blog_group1( $this_query );

                    break;
                    case 'group-2':

                        wi_blog_group2( $this_query );

                    break;
                    default :

                    endswitch; 

                ?>

            </div><!-- .section-main -->

            <div class="clearfix"></div>

        </div><!-- .wi-section -->

        <?php wp_reset_query();?>
        <?php
        endfor; // for $i
        ?>

            <?php endif; // disabled paged ?>

            <?php include_once 'part/main-stream.php'; ?>

            <div class="clearfix"></div>

        </div><!-- #wi-bf -->
    
    </div><!-- .content -->
        
</div><!-- .container -->

<?php get_footer(); ?>
