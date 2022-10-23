(function($){
    /**
     * Resume Block
     * @date    22/10/22
     * @since   1.0.0
     * @param   object $block The block jQuery element.
     * @param   object attributes The block attributes (only available when editing).
     * @return  void
     */
    var initializeBlock = function( $block ) {
        let skill_item = $block.find('.my-resume__skill--item');
        skill_item.each(function (k, v) {
            var t = $(this);
            let count = t.find('.my-resume__skill--precent');
            let precent = count.attr('data-precent');
            count.find('div').addClass('width-' + precent);
            count.find('span').text(precent + '%');
        });

    }


    // Initialize each block on page load (front end).
    $(document).ready(function(){
        $('.my-resume').each(function(){
            initializeBlock( $(this) );
        });
    });

    // Initialize dynamic block preview (editor).
    if( window.acf ) {
        window.acf.addAction( 'render_block_preview/type=resume', initializeBlock );
    }

})(jQuery);