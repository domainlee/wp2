<?php
if ( ! function_exists( 'wi_review' ) ) :
/**
 * Single Post Review
 *
 * @since 2.4
 */
function wi_review() {
    
    $review = get_post_meta( get_the_ID(), '_wi_review', true ); if ( ! $review || ! is_array( $review ) ) return;
    $items = '';
    ob_start();
    
    foreach ( $review as $item ) : if ( ! isset( $item[ 'criterion' ] ) || ! isset( $item[ 'score' ] ) || ! $item[ 'criterion' ] || ! $item[ 'score' ] ) continue; ?>

<div class="review-item">

    <div class="review-criterion"><?php echo $item[ 'criterion' ]; ?></div>
    <div class="review-score"><?php echo $item[ 'score' ]; ?><span class="unit">/10</span></div>

</div>

<?php endforeach; ?>

<?php $average = get_post_meta( get_the_ID(), '_wi_review_average', true ); ?>

<?php if ( $average && is_numeric( $average ) ) : ?>

<div class="review-item overrall">

    <div class="review-criterion"><?php echo esc_html__( 'Overrall', 'wi' ); ?></div>
    <div class="review-score"><?php echo number_format((float)$average, 1, '.', ''); ?><span class="unit">/10</span></div>

</div>

<?php endif; ?>

<?php
    
    $items = trim ( ob_get_clean() );
    if ( ! $items ) return;
    
?>

<div id="review-wrapper">
    
    <h2 id="review-heading"><?php echo esc_html__( 'Review', 'wi' ); ?></h2>
    
    <div id="review">
        
        <?php echo $items ; ?>
        
    </div>
    
    <?php if ( $review_text = get_post_meta( get_the_ID(), '_wi_review_text', true ) ) { ?>
    
    <div class="review-text">
        
        <div class="review-text-inner">
    
            <?php echo do_shortcode( $review_text ); ?>
            
        </div>
    
    </div><!-- .review-text -->
    
    <?php } ?>
    
    <?php 
    $btn1 = get_post_meta( get_the_ID(), '_wi_review_btn1_url', true );
    $btn1_text = trim( get_post_meta( get_the_ID(), '_wi_review_btn1_text', true ) ); if ( ! $btn1_text ) $btn1_text = 'Click Me';
    $btn2 = get_post_meta( get_the_ID(), '_wi_review_btn2_url', true );
    $btn2_text = trim( get_post_meta( get_the_ID(), '_wi_review_btn2_text', true ) ); if ( ! $btn2_text ) $btn2_text = 'Click Me';
    
    if ( $btn1 || $btn2 ) {
    ?>
    <div class="review-buttons">
        
        <?php if ( $btn1 ) { ?>
        <a href="<?php echo esc_url( $btn1 ); ?>" target="_blank" class="wi-btn btn-1"><?php echo $btn1_text; ?></a>
        <?php } ?>
        
        <?php if ( $btn2 ) { ?>
        <a href="<?php echo esc_url( $btn2 ); ?>" target="_blank" class="wi-btn btn-2"><?php echo $btn2_text; ?></a>
        <?php } ?>
    
    </div><!-- .review-buttons -->
    
    <?php } // if btn ?>
    
</div>

<?php
}
endif;