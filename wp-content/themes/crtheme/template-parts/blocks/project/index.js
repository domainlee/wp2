(function($){
    /**
     * Project Block
     */
    var initializeBlock = function( $block ) {
        $('.lazy').Lazy({
            effect: "fadeIn",
            effectTime: 500,
        });
    }


    // Initialize each block on page load (front end).
    $(document).ready(function(){
        $('.my-project').each(function(){
            initializeBlock( $(this) );
        });
    });

    // Initialize dynamic block preview (editor).
    if( window.acf ) {
        window.acf.addAction( 'render_block_preview/type=project', initializeBlock );
    }

})(jQuery);