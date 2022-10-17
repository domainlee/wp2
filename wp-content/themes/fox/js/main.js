(function($, WITHEMES) {
"use strict";
var WITHEMES = WITHEMES || {};

/* Functions
--------------------------------------------------------------------------------------------- */
var isMobile = {
    Android: function() {
        return navigator.userAgent.match(/Android/i);
    },
    BlackBerry: function() {
        return navigator.userAgent.match(/BlackBerry/i);
    },
    iOS: function() {
        return navigator.userAgent.match(/iPhone|iPad|iPod/i);
    },
    Opera: function() {
        return navigator.userAgent.match(/Opera Mini/i);
    },
    Windows: function() {
        return navigator.userAgent.match(/IEMobile/i);
    },
    any: function() {
        return (isMobile.Android() || isMobile.BlackBerry() || isMobile.iOS() || isMobile.Opera() || isMobile.Windows());
    }
};
    
/**
 * Debouce function
 *
 * @since 1.0
 */
window.debounce = function(func, wait, immediate) {
    var timeout;
    return function() {
        var context = this, args = arguments;
        var later = function() {
            timeout = null;
            if (!immediate) func.apply(context, args);
        };
        var callNow = immediate && !timeout;
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
        if (callNow) func.apply(context, args);
    };
};
    
/* Fitvids
--------------------------------------------------------------------------------------------- */
WITHEMES.fitvids = function(){
	if ( $().fitVids ) {
		$(document,'.media-container').fitVids();
	}
}; // fitvids
    
/* Tab
--------------------------------------------------------------------------------------------- */
WITHEMES.tab = function(){
    
	$('.authorbox').each(function(){
		var tab = $(this);		
		$(this).find('.authorbox-nav').find('a').click(function(){
			tab.find('.authorbox-nav').find('li').removeClass('active');
			$(this).parent().addClass('active');
			var currentTab = $(this).data('href');
			tab.find('.authorbox-tab').removeClass('active');
			tab.find(currentTab).addClass('active');
			return false;
		});	// click
						 });	// each
    
};	// tab    

/* Flexslider
--------------------------------------------------------------------------------------------- */
WITHEMES.flexslider = function(){
	if ( $().flexslider ) {
       
		$('.wi-flexslider').each(function(){
			var $this = $(this),
                defaultOptions = {
                    animation: 'slide',
                    smoothHeight : false,
                    animationSpeed : 500,
                    slideshowSpeed	:	5000,
                    directionNav	:	true,
				    slideshow		:	true,
                    controlNav : false,
                    pauseOnHover: true,
                    easing: ( $this.data('effect') == 'slide' ) ? 'easeInOutExpo' : 'swing',
                    prevText        :   WITHEMES.l10n.prev, // @since Fox 2.2
                    nextText        :   WITHEMES.l10n.next,  // @since Fox 2.2
                    start            :   function(slider){
                        $this.addClass('loaded');
                        WITHEMES.masonry();
                    }
                },
                args = $( this ).data( 'options' ),
                options = $.extend( defaultOptions, args );
            
            $this.imagesLoaded(function(){
                
                $this
                .find( '.flexslider' )
                .flexslider( options );
                
            }); // imagesLoaded
            
        }); // each
				
	}	// if flexslider
    
}; // flexslider

/* Mobile menu
 * deprecated since 2.9
--------------------------------------------------------------------------------------------- */
WITHEMES.mobile_menu = function(){
    
    // add indicator
    $('#wi-mainnav .menu > ul li.menu-item-has-children > a').append('<u class="indicator"><i class="fa fa-chevron-down"></i></u>');
	
    // toggle menu click
	$('.toggle-menu').on('click',function(){
		$('#wi-mainnav').slideToggle('fast','easeOutExpo');
										  });
    
    // document click
    $(document).on('click',function(e){
        if (matchMedia('(max-width: 979px)').matches) { // desktop size
            var target = e.target;
            if (!$(target).is('.toggle-menu') && ($(target).closest('.toggle-menu').length == 0) && ($(target).closest('#wi-mainnav').length == 0) ) {
                $('#wi-mainnav').slideUp('fast','easeOutExpo');
            }
        }
    }); // click
	
    // indicator click
	$('#wi-mainnav .menu > ul > li a .indicator').on('click',function(e){
		var $this = $(this);
		e.preventDefault();
		$this.parent().next().slideToggle('normal','easeOutExpo');
		return false;
																   });
    
    // resize, menu close, open
    $(window).resize(function(){
        if (matchMedia('(min-width: 981px)').matches) { // desktop size
            $('#wi-mainnav').css('display','');
            $('#wi-mainnav ul.menu ul').css('display','');
        } else {
            //$('#wi-mainnav').css('display','');
            //$('#wi-mainnav ul.menu ul').css('display','');
        }
    });
	
}

/* Masonry
--------------------------------------------------------------------------------------------- */
WITHEMES.masonry = function(){
    
    if ( ! $().masonry) return;
    
    var run = debounce( function() {
        
        // blog masonry
        $('.blog-masonry, .blog-newspaper').each(function(){
            var $this = $(this);
            var args = {
                "itemSelector": ".post-masonry, .post-newspaper, .main-stream-ad",
                "percentPosition": true,
                "columnWidth": ".grid-sizer",
            }

            $this.imagesLoaded(function(){
                $this.masonry(args);
                $this.addClass('loaded');

                $this.find('.post-masonry, .post-newspaper').each(function(){
                    var this_post = $(this);
                    this_post.bind('inview', function(event, isInView, visiblePartX, visiblePartY) {
                    if (isInView) {
                        this_post.addClass('inview');
                    } // inview						  
                                          });// bind
                }); // each

            }); // imagesLoaded

            setTimeout(function(){$this.addClass('loaded');},6000); // show after 6s anyway

        }); // each

        // sidebar
        var widget_area = $('#secondary .widget-area');

        if (matchMedia('(max-width: 979px) and (min-width: 768px)').matches) {

            widget_area.imagesLoaded(function(){
            widget_area.masonry({
                    'gutter'        :   '.gutter-sidebar',
                    'itemSelector'  :   '.widget',
                });
            }); // imagesloaded

        } else {

            

        }
        
    }, 100 );
    
    $( window ).load(function() {

        run();

    });

    $( window ).resize( run );
	
}

/* Pinterest
 * since 2.8
--------------------------------------------------------------------------------------------- */
WITHEMES.pinterest = function() {

    if ( ! $().masonry ) return;

    var run = debounce( function() {

        $( '.wi-pin-list' ).each(function() {

            var $this = $( this );

            $this.imagesLoaded( function() {

                $this
                .addClass( 'loaded' )
                .masonry({

                    itemSelector: '.pin-item',
                    columnWidth: '.grid-sizer',

                });

            });

        });


    }, 100 );

    $( window ).load(function() {

        run();

    });

    $( window ).resize( run );

}

/* back to top
--------------------------------------------------------------------------------------------- */
WITHEMES.backtotop = function(){
    
    $(window).scroll(function(){
        if ($(this).scrollTop() > 200) {
            $('.backtotop').addClass('shown');
        } else {
            $('.backtotop').removeClass('shown');
        }
    }); 
	
	$('.backtotop').click(function(){
		$("html, body").animate({ scrollTop: 0 }, 600 , 'easeOutExpo');
		return false;
	});
    
    $(document).click(function(e){
        
        var target = $(e.target);
        if (
            (target.is('#wi-topbar') || (target.closest('#wi-topbar').length > 0)) && 
            !target.is('#wi-mainnav') &&
            (target.closest('#wi-mainnav').length == 0) && 
            !target.is('.toggle-menu') &&
            (target.closest('.toggle-menu').length == 0) && 
            !target.is('#header-social') && 
            (target.closest('#header-social').length == 0)
           ) {
        
            $("html, body").animate({ scrollTop: 0 }, 600 , 'easeOutExpo');
            return false;
        }
	});
	
}

/* social share
--------------------------------------------------------------------------------------------- */
WITHEMES.social_share = function(){
	
    var Config = {
        Link: "a.share",
        Width: 500,
        Height: 500
    };
 
    $( document ).on( 'click', 'a.share', function( e ) {
 
        e = (e ? e : window.event);
        var t = $(this);
 
        // popup position
        var
            px = Math.floor(((screen.availWidth || 1024) - Config.Width) / 2),
            py = Math.floor(((screen.availHeight || 700) - Config.Height) / 2);
 
        // open popup
		if(t.data('href')) {
			var popup = window.open(t.attr('data-href'), "social", 
				"width="+Config.Width+",height="+Config.Height+
				",left="+px+",top="+py+
				",location=0,menubar=0,toolbar=0,status=0,scrollbars=1,resizable=1");
			if (popup) {
				popup.focus();
				if (e.preventDefault) e.preventDefault();
				e.returnValue = false;
			}
	 
			return !!popup;
		}
    }); // click

}

/* Header Sticky
--------------------------------------------------------------------------------------------- */
WITHEMES.header_sticky = function() {
    
    if ( ! WITHEMES.enable_sticky_header ) return;
    
    function run_sticky() {
        
        var ele = $('.header-sticky-element');
        var header_height = ele.outerHeight();
        var from_top = $(window).scrollTop();
        var adminbar_height = $('#wpadminbar').outerHeight();

        if ( from_top >= (adminbar_height + header_height + 100)) {
            ele.addClass('is-sticky');
        } else {
            ele.removeClass('is-sticky');	
        }
    }
    
    function sticky() {
        
        if ( ! window.matchMedia( '(min-width: 1024px)' ).matches ) {
            return;
        }
        
        var ele = $('.header-sticky-element');
        
        var header_height = ele.outerHeight();
        ele.parent().css({height:header_height + 'px'});
        
        run_sticky();

        $(window).on('scroll',function(){									   
            run_sticky();
        }); // on scroll

    }
    
    $(window).load(sticky);
    $(window).resize(sticky);
        
} 

/* Minimal Header Sticky
 * @since 3.0
--------------------------------------------------------------------------------------------- */
WITHEMES.minimal_header_sticky = function() {
    
    var sticky = function() {
        
        var $vh = $( window ).outerHeight();
        
        $( window ).on( 'scroll',function() {
            
            if ( $(window).scrollTop() > $vh ) {
                $( '.minimal-header' ).removeClass( 'top-mode' );
            } else {
                $( '.minimal-header' ).addClass( 'top-mode' );
            }
            
        }); // on scroll
        
    }
    
    $( window ).load( sticky );
    $( window ).resize( sticky );
    
}

/* Slick
--------------------------------------------------------------------------------------------- */
WITHEMES.slick = function(){
    
	if ( $().slick ) {
       
		$('.wi-slick').each(function(){
			var $this = $(this);
			$this.slick({
                slidesToShow: 1,
                variableWidth: true,
                slide   : '.slick-item',
				infinite: true,
                initialSlide :  0,
                speed       :   400,
                useTransform : false,
                easing      : 'easeOutQuint',
                dots        :   false,
                arrows      :   true,
                nextArrow   :   '<button type="button" class="slick-next slick-nav"><i class="fa fa-chevron-right"></i></button>',
                prevArrow   :   '<button type="button" class="slick-prev slick-nav"><i class="fa fa-chevron-left"></i></button>',
                swipeToSlide : true,
                touchMove : false
								 });	// slick
            
            $this.on('setPosition', function(event, slick, direction){
                $this.addClass('loaded');
            });
            
										});	// each
        
				
	}	// if slick
    
}; // slick
  
/* Colorbox
--------------------------------------------------------------------------------------------- */    
WITHEMES.colorbox = function(){    
    if ( $().colorbox ) {
        $( '.wi-colorbox, .lightbox, .wp-block-image a[href$=".gif"], .wp-block-image a[href$=".jpg"], .wp-block-image a[href$=".jpeg"], .wp-block-image a[href$=".png"], .wp-block-image a[href$=".bmp"]' ).colorbox({
            transition	:	'none',
            speed		:	350,
            maxWidth	:	'95%',
            maxHeight	:	'95%',
            scalePhotos :   true,
            returnFocus :   false,
            current     :   "Image {current} of {total}",
            title       :   function(){ var caption = $(this).closest('.wp-caption').find( '.wp-caption-text' ); if ( caption ) return caption.text(); }
                                  });
        
        $('.gallery, .wp-block-gallery').each(function(index){
            var id = (	$(this).attr('id')	) ? $(this).attr('id') : 'gallery-' + index;
            
            var delegate = $( this ).is( '.gallery' ) ? '.gallery-item' : '.blocks-gallery-item';
            
            $(this).
            find( delegate ).
            find('a[href$=".gif"], a[href$=".jpg"], a[href$=".jpeg"], a[href$=".png"], a[href$=".bmp"]').
            has('img').
            colorbox({
                transition	:	'none',
                speed		:	100,
                maxWidth	:	'90%',
                maxHeight	:	'90%',
                rel			:	id,
                title       :   function(){ var caption = $(this).closest( delegate ).find( 'figcaption' ); if ( caption ) return caption.text(); }
            });
                                    });	// each
	}	// colorbox
}

/* Animation
--------------------------------------------------------------------------------------------- */    
WITHEMES.animation = function(){    
    
    // related posts
    $('.blog-related, .related-list, #posts-small, .newspaper-related').each(function(){
        var $this = $(this);
        $this.bind('inview', function(event, isInView, visiblePartX, visiblePartY) {
        if (isInView) {
            $this.addClass('inview');
        } // inview
                              });// bind
    }); // each

}

/* Retina
--------------------------------------------------------------------------------------------- */    
WITHEMES.retina = function(){
    if ($().retina) {
        $('img').retina({
            // Check for data-retina attribute. If exists, swap out image
             dataRetina: true,
             // Suffix to append to image file name
             suffix: "",
             // Check if image exists before swapping out
             checkIfImageExists: false,
             // Callback function if custom logic needs to be applied to image file name
             customFileNameCallback: "",
             // override window.devicePixelRatio
             overridePixelRation: false
        });
    }
}

/* Header search
--------------------------------------------------------------------------------------------- */    
WITHEMES.header_search = function(){
    
    $('.li-search').click(function(){
        $('#header-search').slideToggle('fast','easeOutExpo').find('.s').focus();
    });
    
    $(document).on('click',function(e){
		var currentTarget = $(e.target);
		if( !currentTarget.is('#header-search') && 
           !currentTarget.is('.li-search') && 
            currentTarget.closest("#header-search").length == 0 && 
            currentTarget.closest(".li-search").length == 0 
          ) {
			$('#header-search').hide('fast','easeOutExpo');
		}
    }); // on click
    
}

/* MegaMenu
--------------------------------------------------------------------------------------------- */
WITHEMES.megaMenu = function() {
    
    $( '#wi-mainnav .menu > li.mega' ).each(function() {
        
        var col = $( this ).find( '> ul' ).find( ' > li' ).length;

        if ( col > 0 ) {
            $( this ).addClass( 'column-' + col );
        }
        if ( col >= 4 ) {
            $( this ).addClass( 'mega-full' );
        }

    });
    
    // @since 2.8
    // find all mega menus of the type product cat but has no children
    $( '#wi-mainnav .menu-item-object-category.mega' ).each(function() {
        var li = $( this );
        li.addClass( 'menu-item-has-children mega-full column-3' );

        // this means it belongs to type ajax product loading
        if ( ! li.find( '>ul' ).length ) {
            li.addClass( 'ajaxload' );

            var item = '<li class="post-nav-item post-nav-item-loading">';
            item += '<figure class="post-nav-item-thumbnail"></figure>';
            item += '<div class="post-nav-item-text"><h3 class="post-nav-item-title"></h3>';
            item += '<div class="post-nav-item-excerpt"></div>';
            item += '</div></li>';

            li.append( '<ul class="submenu submenu-display-items">' + item + item + item + '</ul>' );
        }

    });

    $( document ).on( 'mouseenter', '.mega.ajaxload', function() {

        var $this = $( this ),
            itemID = $this.attr( 'id' );
            itemID = parseInt( itemID.replace( 'menu-item-', '' ) );

        if ( $this.find( '> ul > li.post-nav-item-loading' ).length ) {

            $.post(
                // the url
                WITHEMES.ajaxurl,

                // the data
                {
                    action: 'nav_mega',
                    itemID: itemID,
                    nonce: WITHEMES.nonce,
                },
                function( response ) {

                    if ( response ) {

                        var json = $.parseJSON( response );
                        if ( ! json ) {

                            $this.find( '> ul > li' ).each(function( i ) {

                                var li = $( this );
                                li.removeClass( 'post-nav-item-loading' );

                            });

                        } else {

                            $this.find( '> ul > li' ).each(function( i ) {

                                var li = $( this ),
                                    item = ( undefined !== json[ i ] ) ? json[ i ] : [],
                                    title = item[ 'title' ],
                                    excerpt = item[ 'excerpt' ],
                                    thumbnail = item[ 'thumbnail' ];

                                li.removeClass( 'post-nav-item-loading' )
                                .find( '.post-nav-item-thumbnail' ).html( thumbnail )
                                .end()
                                .find( '.post-nav-item-title' ).html( title )
                                .end()
                                .find( '.post-nav-item-excerpt' ).html( excerpt )

                            });

                        }

                    }

                }
            );

        }

    });

}

/**
 * Sticky Sidebar
 *
 * @since 2.2
 */
WITHEMES.stickySidebar = function() {
    
    if ( ! $().theiaStickySidebar || ! WITHEMES.enable_sticky_sidebar ) return;
        
    if ( ! window.matchMedia( '(min-width: 1024px)' ).matches ) {
        return;
    }
    
    if ( ! $( '#wi-main' ).find( '.secondary' ).length ) return;
    
    $( '.primary, .secondary' ).theiaStickySidebar({
        // Settings
        additionalMarginTop: 80,
        additionalMarginBottom: 20,
        minWidth : 797,
    });

}

/**
 * WooCommerce Quantity Buttons
 *
 * @since 2.4
 */
WITHEMES.woocommerce_quantity = function() {

    // Quantity buttons
    $( 'div.quantity:not(.buttons-added), td.quantity:not(.buttons-added)' )
    .addClass( 'buttons-added' )
    .append( '<input type="button" value="+" class="plus" />' )
    .prepend( '<input type="button" value="-" class="minus" />' );

    // Set min value
    $( 'input.qty:not(.product-quantity input.qty)' ).each ( function() {
        var qty = $( this ),
            min = parseFloat( qty.attr( 'min' ) );
        if ( min && min > 0 && parseFloat( qty.val() ) < min ) {
            qty.val( min );
        }
    });

    // Handle click event
    $(document).on( 'click', '.plus, .minus', function() {

            // Get values
        var qty = $( this ).closest( '.quantity' ).find( '.qty' ),
            currentQty = parseFloat( qty.val() ),
            max = parseFloat( qty.attr( 'max' ) ),
            min = parseFloat( qty.attr( 'min' ) ),
            step = qty.attr( 'step' );

        // Format values
        if ( !currentQty || currentQty === '' || currentQty === 'NaN' ) currentQty = 0;
        if ( max === '' || max === 'NaN' ) max = '';
        if ( min === '' || min === 'NaN' ) min = 0;
        if ( step === 'any' || step === '' || step === undefined || parseFloat( step ) === 'NaN' ) step = 1;

        // Change the value
        if ( $( this ).is( '.plus' ) ) {

            if ( max && ( max == currentQty || currentQty > max ) ) {
                qty.val( max );
            } else {
                qty.val( currentQty + parseFloat( step ) );
            }

        } else {

            if ( min && ( min == currentQty || currentQty < min ) ) {
                qty.val( min );
            } else if ( currentQty > 0 ) {
                qty.val( currentQty - parseFloat( step ) );
            }

        }

        // Trigger change event
        qty.trigger( 'change' );

    });

}

/**
 * Content Dock
 *
 * @since 2.5
 */
WITHEMES.contentDock = function() {

    var doc = $( '#content-dock' ),
        close = doc.find( '.close' );
    
    // added since 2.9
    if ( WITHEMES.enable_autoload ) return;

    // Setup Animation
    doc.find( '.post-dock' ).each(function( i ) {
        $( this ).css({
            '-webkit-transition-delay': ( 400 + 80 * i + 'ms' ),
            'transition-delay': ( 400 + 80 * i + 'ms' ),
        });
    });

    $(window).load(function() {
        
        $( '#wi-footer' ).bind('inview', function(event, isInView, visiblePartX, visiblePartY) {
            if (isInView) {

                if ( doc.data( 'never-show' ) ) return;

                doc.addClass( 'shown' );

                close.click(function( e ) {
                    e.preventDefault();
                    doc
                    .removeClass( 'shown' )
                    .addClass( 'dont-show-me-again' )
                    .data( 'never-show', true )
                });

            } // inview

        });

        close.click(function( e ) {
            e.preventDefault();
            doc
            .removeClass( 'shown' )
            .addClass( 'dont-show-me-again' )
            .data( 'never-show', true )
        });

    });
    
}

/* Fullsize image in coll post
 * @since 2.9
--------------------------------------------------------------------------------------------- */
WITHEMES.fullsize_image = function() {

    var run = debounce( function() {
        
        $( '.cool-post.coolpost-image-stretch-full img.fullsize, .cool-post.coolpost-image-stretch-full img.full-size, .cool-post.coolpost-image-stretch-full .wp-block-image img' ).each(function() {
        
            var img = $( this ),
                parentW = img.parent().outerWidth(),
                vW = $( '#wi-wrapper' ).outerWidth(),
                margin = ( vW - parentW ) / 2;
            img
            .css({
                width: vW + 'px',
                'margin-left' : -margin + 'px',
            })
            .addClass( 'loaded' );
        
        });
    
    }, 100 );
    
    run();
    $( window ).resize( run );
    
}

/* Off Canvas Mobile Menu
 * @since 2.9
--------------------------------------------------------------------------------------------- */
WITHEMES.offcanvas = function() {
    
    var hamburger = $( '.toggle-menu' ),
        offcanvas = $( '#offcanvas' );
    
    $( '.offcanvas-nav .menu > li > a' ).each(function( i ) {
        
        $( this ).css({
            'transition-delay': Math.sqrt( i ) * 300 + 'ms',
        })
    
    });

    var offcanvas_dismiss = debounce(function( e ) {

        e.preventDefault();
        $( 'html' ).removeClass( 'offcanvas-open' );

    }, 100 );

    $(document).on( 'click', '.toggle-menu', function( e ) {

        e.preventDefault();
        $( 'html' ).toggleClass( 'offcanvas-open' );

    });

    $( '#offcanvas-overlay' ).on( 'click', offcanvas_dismiss );

    $(window).resize( offcanvas_dismiss );

    // Submenu Click
    $( '.offcanvas-nav li' ).click(function( e ) {

        var li = $( this ),
            a = li.find( '> a ' ),
            href = a.attr( 'href' ),
            target = $( e.target ),
            ul = li.find( '> ul' ),

            condition1 = ( ! target.is( ul ) && ! target.closest( ul ).length ),
            condition2 = ( ( ! target.is( a ) && ! target.closest( a ).length ) || ( ! href || '#' == href ) );

        if (  condition1 && condition2 ) {

            e.preventDefault();
            ul.slideToggle( 300, 'easeOutCubic' );

        }

    });

}

/* Init functions
--------------------------------------------------------------------------------------------- */
$(document).ready(function() {
    WITHEMES.header_sticky();
    WITHEMES.minimal_header_sticky();
    WITHEMES.fitvids();
	WITHEMES.flexslider();
    WITHEMES.slick();
    WITHEMES.colorbox();
    WITHEMES.masonry();
    WITHEMES.pinterest();
//	WITHEMES.mobile_menu(); // removed since 2.9
    WITHEMES.backtotop();
    WITHEMES.offcanvas();
    WITHEMES.social_share();
    WITHEMES.tab();
    WITHEMES.retina();
    WITHEMES.header_search();
    WITHEMES.megaMenu();
    WITHEMES.animation();
    WITHEMES.stickySidebar();
    WITHEMES.woocommerce_quantity();
    WITHEMES.contentDock();
    
    WITHEMES.fullsize_image();
    
    /* autoload event handler */
    $( document ).on( 'autoload', function( e, posthtml ) {

        // trigger some more js
        WITHEMES.fitvids();
        WITHEMES.flexslider();
        WITHEMES.slick();
        $('.wi-slick').addClass( 'loaded' );
        WITHEMES.colorbox();
        WITHEMES.tab();
        WITHEMES.animation();
        WITHEMES.fullsize_image();

        // sticky sidebar
        if (  posthtml.find( '.secondary' ).length ) {

            if ( ! $().theiaStickySidebar || ! WITHEMES.enable_sticky_sidebar ) return;

            if ( ! window.matchMedia( '(min-width: 1024px)' ).matches ) {
                return;
            }

            posthtml.find( '.container' ).find( '.primary, .secondary' ).theiaStickySidebar({
                // Settings
                additionalMarginTop: 80,
                additionalMarginBottom: 20,
                minWidth : 1024,
                containerSelector : posthtml.find( '.container' ),
            });

        }

    })
    
						   });
})(jQuery, WITHEMES);	// EOF