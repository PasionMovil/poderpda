(function($) {

    $(document).ready(function() {

        /*-----------------------------------------------------------------------------------*/
        /* FEATURED GRID SLIDER
        /*-----------------------------------------------------------------------------------*/
        if(parseInt(vce_js_settings.rtl_mode) == 1){
            vce_js_settings.rtl_mode = true;
        } else {
            vce_js_settings.rtl_mode = false;
        }

        $("#vce-featured-grid").owlCarousel({
            margin: 1,
            loop: true,
            rtl: vce_js_settings.rtl_mode,
            nav: true,
            center: true,
            fluidSpeed: 100,
            items: 3,
            navText: ['<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>'],
            responsive: {
                0: {
                    items: 1,
                    nav: true,
                    autoWidth: true
                },
                600: {
                    items: 2,
                    autoWidth: true
                },
                768: {
                    items: 3,
                    autoWidth: false
                },
                1024: {
                    items: 3,
                    autoWidth: true
                }
            }
        });

        $(".vce-featured-full-slider").owlCarousel({
            loop: true,
            nav: true,
            rtl: vce_js_settings.rtl_mode,
            center: true,
            items: 1,
            navText: ['<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>']
        });

        $('.vce-post-slider').owlCarousel({
            loop: true,
            nav: true,
            rtl: vce_js_settings.rtl_mode,
            center: true,
            fluidSpeed: 100,
            items: 1,
            navText: ['<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>']
        });

        /*-----------------------------------------------------------------------------------*/
        /* MAGNIFIC POPUP
        /*-----------------------------------------------------------------------------------*/

        if ($('.vce-image-format').length) {
            $('.vce-image-format').magnificPopup({
                type: 'image',
                zoom: {
                    enabled: true,
                    duration: 300, // don't foget to change the duration also in CSS
                    opener: function(element) {
                        return element.find('img');
                    }
                }
            });
        }

        if ($('.vce-gallery-big').length) {
            $('.vce-gallery-big').magnificPopup({
                type: 'image',
                delegate: 'a',
                gallery:{
                    enabled:true
                },
                zoom: {
                    enabled: true,
                    duration: 300, // don't foget to change the duration also in CSS
                    opener: function(element) {
                        return element.find('img');
                    }
                },
                image: {
                    titleSrc: function(item) {
                        var $caption = item.el.closest('.big-gallery-item').find('.gallery-caption');
                        if($caption != 'undefined'){
                            return $caption.text();
                        }
                        return '';
                    }
                }
            });
        }

        $('body').on('click', '.vce-gallery-slider a', function(e) {
            e.preventDefault();
            var item_id = $(this).closest('.gallery-item').attr('data-item');
            var $wrap = $(this).closest('.gallery');
            var $big = $wrap.find('.vce-gallery-big');
            $big.find('.big-gallery-item').fadeOut(400);
            $big.find('.item-'+item_id).fadeIn(400);

        });




        /*-----------------------------------------------------------------------------------*/
        /* GALLERY POST SLIDER
        /*-----------------------------------------------------------------------------------*/
        

        $('.gallery .vce-gallery-slider').each(function() {
            $(this).owlCarousel({
                margin: 1,
                loop: true,
                rtl: vce_js_settings.rtl_mode,
                nav: true,
                mouseDrag: false,
                center: false,
                fluidSpeed: 100,
                navText: ['<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>'],
                items: $(this).attr('data-columns'),
                autoWidth: false
            });
        });

        /*-----------------------------------------------------------------------------------*/
        /* MODULE SLIDERS
        /*-----------------------------------------------------------------------------------*/

        var vce_slider_items_num = {'b': 1, 'cdf' : 2, 'e': 5};
        
        if($("body").hasClass('vce-sid-none')){
            vce_slider_items_num.b = 2;
            vce_slider_items_num.cdf = 3;
            vce_slider_items_num.e = 7;
        } 

        $(".vce-slider-pagination.vce-slider-a, .vce-slider-pagination.vce-slider-g").owlCarousel({
            loop: true,
            autoHeight: false,
            rtl: vce_js_settings.rtl_mode,
            autoWidth: true,
            nav: true,
            fluidSpeed: 100,
            navText: ['<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>'],
            responsive: {
                0: {
                    items: 1,
                    nav: true,
                    autoWidth: false,
                    margin: 10
                },
                600: {
                    items: 1,
                    autoWidth: false
                },
                768: {
                    items: 1,
                    margin: 20,
                    autoWidth: false
                },
                1023: {
                    items: 1,
                    autoWidth: false,
                    margin: 20,
                }
            }
        });

        $(".vce-slider-pagination.vce-slider-b").owlCarousel({
            loop: true,
            autoHeight: false,
            autoWidth: true,
            rtl: vce_js_settings.rtl_mode,
            nav: true,
            fluidSpeed: 100,
            navText: ['<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>'],
            responsive: {
                0: {
                    items: 1,
                    nav: true,
                    autoWidth: false,
                    margin: 10
                },
                600: {
                    items: 1,
                    autoWidth: false
                },
                768: {
                    items: 1,
                    margin: 20,
                    autoWidth: false
                },
                1023: {
                    items:  vce_slider_items_num.b,
                    autoWidth: false,
                    margin: 20,
                }
            }
        });

        $(".vce-slider-pagination.vce-slider-c, .vce-slider-pagination.vce-slider-d, .vce-slider-pagination.vce-slider-f").each(function(){
            var vce_num_items;
            var vce_res_num_items;
            if($(this).parent().parent().hasClass('main-box-half')){
                vce_num_items = 1;
                vce_res_num_items = 1;
            } else {
                vce_num_items = vce_slider_items_num.cdf;
                vce_res_num_items = 2;
            }

            $(this).owlCarousel({
                loop: true,
                autoHeight: false,
                rtl: vce_js_settings.rtl_mode,
                autoWidth: true,
                nav: true,
                fluidSpeed: 100,
                navText: ['<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>'],
                responsive: {
                    0: {
                        items: 1,
                        nav: true,
                        autoWidth: false,
                        margin: 10
                    },
                    600: {
                        items: vce_res_num_items,
                         margin: 18,
                        autoWidth: false
                    },
                    768: {
                        items: vce_res_num_items,
                        margin: 15,
                        autoWidth: false
                    },
                    1023: {
                        items: vce_num_items,
                        autoWidth: false,
                        margin: 19,
                    }
                }
            });
        });

        
        $(".vce-slider-pagination.vce-slider-e").owlCarousel({
            loop: true,
            autoHeight: false,
            autoWidth: true,
            rtl: vce_js_settings.rtl_mode,
            nav: true,
            fluidSpeed: 100,
            navText: ['<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>'],
            responsive: {
                0: {
                    items: 2,
                    nav: true,
                    autoWidth: false,
                    margin: 5
                },
                600: {
                    items: 3,
                     margin: 18,
                    autoWidth: false
                },
                768: {
                    items: 5,
                    margin: 15,
                    autoWidth: false
                },
                1023: {
                    items: vce_slider_items_num.e,
                    autoWidth: false,
                    margin: 19,
                }
            }
        });


        /*-----------------------------------------------------------------------------------*/
        /* STICKY SIDEBAR
        /*-----------------------------------------------------------------------------------*/

        function sticky_sidebar() {
            if ($(window).width() > 1024) {
                if ($('.vce-sticky').length > 0) {
                    if($('.vce-main-content').height()-50 > $('.sidebar').height() ){
                        
                        var t = $('.vce-sticky').offset().top - 30;
                        var b = $('.site-footer').outerHeight() + 30;

                        if($('.vce-content-bottom .vce-custom-content').length){
                            var c = $('.vce-content-bottom .vce-custom-content').outerHeight()+30;
                        }else{
                            var c = 0;
                        }

                        $(".vce-sticky").affix({
                            offset: {
                                top: function() {
                                    return t;
                                },
                                bottom: function() {
                                    return ($(".vce-sticky").hasClass("affix-top")) ? 0 : b+c;
                                }
                            }
                        });
                    }
                }
            }
        }
        $('.vce-main-content').imagesLoaded().always( function( instance ) {
            sticky_sidebar();
        });

        $(window).bind('resize', function(){
            if($(window).width() < 1024){
                $(".vce-sticky").addClass('affix-responsive'); 
                $('.sidebar.left').insertAfter('.vce-main-content');
            }
            else{
               $('.sidebar.left').insertBefore('.vce-main-content'); 
            } 
        });

        if($(window).width() < 1024 && $('.sidebar.left').length){
            $('.sidebar.left').insertAfter('.vce-main-content');
        }
        else{
           $('.sidebar.left').insertBefore('.vce-main-content'); 
        } 

        /*-----------------------------------------------------------------------------------*/
        /* Fit videos
        /*-----------------------------------------------------------------------------------*/

        $(".meta-media").fitVids();


        $(".vce-featured-header .vce-hover-effect").hover(function() {
            $('.vce-featured-header .vce-featured-header-background').animate({
                opacity: 0.7
            }, 100);
        }, function() {
            $('.vce-featured-header .vce-featured-header-background').animate({
                opacity: 0.5
            }, 100);
        });

        /*-----------------------------------------------------------------------------------*/
        /* Responsive navigation
        /*-----------------------------------------------------------------------------------*/
    

        $('#vce-responsive-nav').sidr({
          name: 'sidr-main',
          source: '#site-navigation',
          speed: 100
        });

        $("body").on('touchstart click','.vce-responsive-nav', function(e){
          e.stopPropagation();
          e.preventDefault();
          if(!$(this).hasClass('nav-open')){
            $.sidr('open', 'sidr-main');
            $(this).addClass('nav-open');
          }else{
            $.sidr('close', 'sidr-main');
            $(this).removeClass('nav-open'); 
          }
        });

        $('#vce-main').on('click', function(e){
          if($('body').hasClass('sidr-open')){
            $.sidr('close', 'sidr-main');
            $('.vce-responsive-nav').removeClass('nav-open');
          }
        });

        $('.sidr ul li').each(function() {
          if( $(this).hasClass('sidr-class-menu-item-has-children')){
            $(this).append('<span class="vce-menu-parent fa fa-angle-down"></span>')
          }
        });
        if( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {
          $('.vce-menu-parent').on('touchstart', function(e){
              $(this).prev().slideToggle();
              $(this).parent().toggleClass('sidr-class-current_page_item');
          });

          $('.soc_sharing').on('click', function(){ 
            $(this).toggleClass('soc_active');
          });

        }
        else{
          $('.vce-menu-parent').on('click', function(e){
              $(this).prev().slideToggle();
              $(this).parent().toggleClass('sidr-class-current_page_item');
          });  
        }

        /*-----------------------------------------------------------------------------------*/
        /* MATCH HEIGHT FOR LAYOUTS
        /*-----------------------------------------------------------------------------------*/

        $('.vce-lay-c, .vce-sid-none .vce-lay-b, .vce-lay-d, .vce-lay-e').matchHeight();
        $('.vce-lay-f').matchHeight(false);
        $('.main-box-half .main-box-inside .vce-loop-wrap').matchHeight();
        $('.main-box-half').matchHeight();

        /*-----------------------------------------------------------------------------------*/
        /* SCROLL TO COMMENTS
        /*-----------------------------------------------------------------------------------*/
        $('.vce-single .entry-meta .comments a').click(function(e) {
            e.preventDefault();
            var target = this.hash,
                $target = $(target);
            $('html, body').stop().animate({
                'scrollTop': $target.offset().top
            }, 900, 'swing', function() {
                window.location.hash = target;
            });
        });

        /*-----------------------------------------------------------------------------------*/
        /* Load More Posts
        /*-----------------------------------------------------------------------------------*/
        
        var vce_load_ajax_new_count = 0;

        $("body").on('click', '.vce-load-more a', function(e) {
            e.preventDefault();
            var $link = $(this);
            var page_url = $link.attr("href");
            $link.addClass('vce-loader');
            $("<div>").load(page_url, function() {
                var n = vce_load_ajax_new_count.toString();
                var $wrap = $link.closest('.main-box-inside').find('.vce-loop-wrap');
                var $new = $(this).find('.vce-loop-wrap .vce-post').addClass('vce-new-'+n);

                $new.hide().appendTo($wrap).fadeIn(400);
                if ($new.eq(0).is('.vce-lay-c, .vce-lay-b, .vce-lay-d, .vce-lay-e, .vce-lay-f')) {
                    setTimeout(function() {
                        $.fn.matchHeight._apply('.vce-loop-wrap .vce-new-'+n, true);
                    }, 300);
                }

                if ($(this).find('.vce-load-more').length) {
                    $link.closest('.main-box-inside').find('.vce-load-more').html($(this).find('.vce-load-more').html());
                } else {
                    $link.closest('.main-box-inside').find('.vce-load-more').fadeOut('fast').remove();
                }

                if (page_url != window.location) {
                    window.history.pushState({
                        path: page_url
                    }, '', page_url);
                }

                vce_load_ajax_new_count++;

                return false;

            });

        });

        /*-----------------------------------------------------------------------------------*/
        /* Infinite scroll
        /*-----------------------------------------------------------------------------------*/
        if ($('.vce-infinite-scroll').length) {
            $(window).scroll(function() {
                //alert($(this).scrollTop() + ' '+ $('.vce-infinite-scroll').offset().top);
                if ($(this).scrollTop() > ($('.vce-infinite-scroll').offset().top - 700)) {
                    //if($(window).scrollTop() == $(document).height() - $(window).height()){
                    var $link = $('.vce-infinite-scroll a');
                    var page_url = $link.attr("href");
                    if (page_url != undefined) {
                        //alert($(window).height());
                        $link.parent().animate({
                            opacity: 1,
                            height: 32
                        }, 300).css('padding', '20px');

                        $("<div>").load(page_url, function() {
                            var n = vce_load_ajax_new_count.toString();
                            var $wrap = $link.closest('.main-box-inside').find('.vce-loop-wrap');
                            var $new = $(this).find('.vce-loop-wrap .vce-post').addClass('vce-new-'+n);

                            $new.hide().appendTo($wrap).fadeIn(400);

                            if ($new.eq(0).is('.vce-lay-c, .vce-lay-b, .vce-lay-d, .vce-lay-e, .vce-lay-f')) {
                                setTimeout(function() {
                                    $.fn.matchHeight._apply('.vce-loop-wrap .vce-new-'+n, true);
                                }, 300);
                            }

                            if ($(this).find('.vce-infinite-scroll').length) {
                                $link.closest('.main-box-inside').find('.vce-infinite-scroll').html($(this).find('.vce-infinite-scroll').html()).animate({
                                    opacity: 0,
                                    height: 0
                                }, 300).css('padding', '0');
                            } else {
                                $link.closest('.main-box-inside').find('.vce-infinite-scroll').fadeOut('fast').remove();
                            }


                            if (page_url != window.location) {
                                window.history.pushState({
                                    path: page_url
                                }, '', page_url);
                            }

                            vce_load_ajax_new_count++;

                            return false;

                        });
                    }
                }
            });
        }

        /*-----------------------------------------------------------------------------------*/
        /* ACCORDION MENU WIDGET
        /*-----------------------------------------------------------------------------------*/
        $('.widget_nav_menu .menu-item-has-children, .widget_pages .page_item_has_children').click(function() {
            $(this).find('ul.sub-menu:first, ul.children:first').slideToggle('fast');

        });

        $('body').on("click", ".search_header", function() {
            $(this).find('i').toggleClass('fa-times','fa-search');
            $(this).toggleClass('vce-item-selected');
            $(this).parent().toggleClass('vce-zoomed');
            $(this).next().find('.search-input').focus();
        });

       

        /*-----------------------------------------------------------------------------------*/
        /* BACK TO TOP
        /*-----------------------------------------------------------------------------------*/
        $(window).scroll(function() {
            if ($(this).scrollTop() > 400) {
                $('#back-top').fadeIn();
            } else {
                $('#back-top').fadeOut();
            }
        });

        $('#back-top').click(function() {
            $('body,html').animate({
                scrollTop: 0
            }, 800);
            return false;
        });


        /*-----------------------------------------------------------------------------------*/
        /* Open popup on post share links
        /*-----------------------------------------------------------------------------------*/
        $('body').on('click', 'ul.vce-share-items a', function(e) {
            e.preventDefault();
            var data = $(this).attr('data-url');
            vce_social_share(data);
        });

        function vce_social_share(data) {
            window.open(data, "Share", 'height=500,width=760,top=' + ($(window).height() / 2 - 250) + ', left=' + ($(window).width() / 2 - 380) + 'resizable=0,toolbar=0,menubar=0,status=0,location=0,scrollbars=0');
        }


        /*-----------------------------------------------------------------------------------*/
        /* Mega menu
        /*-----------------------------------------------------------------------------------*/

       $("#vce_main_navigation_menu li.vce-mega-cat").append('<ul class="vce-mega-menu-wrapper"></ul>');       
 
        $('body').on("hover", "#vce_main_navigation_menu li.vce-mega-cat a", function() {

            var $ul_wrap = $(this).parent().find('.vce-mega-menu-wrapper');

            if ($ul_wrap.is(':empty')) {

                $ul_wrap.addClass('vce-loader');

                var data = {
                    action: 'vce_mega_menu',
                    cat: $(this).attr('data-mega_cat_id')
                };

                $.post(vce_js_settings.ajax_url, data, function(response) {
                     if ($ul_wrap.is(':empty')) {
                        //$ul_wrap.append(response);
                       
                        var $response = $($.parseHTML(response));
                        
                        $ul_wrap.removeClass('vce-loader');
                        setTimeout(function() {
                            $.fn.matchHeight._apply('.vce-mega-menu-wrapper .mega-menu-link', true);
                        }, 300);
                        $response.hide().appendTo($ul_wrap).fadeIn(400);
                     }
                });
            }

        });

/*-----------------------------------------------------------------------------------*/
/* STICKY HEADER
/*-----------------------------------------------------------------------------------*/
if( vce_js_settings.sticky_header ){
  var sticky_header_created = false;

  if($('#header').length) {

    var sticky_header_top = $('#header').offset().top + parseInt(vce_js_settings.sticky_header_offset);
    // Hide Header on on scroll down
    var didScroll;
    var lastScrollTop = 0;
    var delta = 5;
    var navbarHeight = $('#header').outerHeight();
    var st = $(this).scrollTop();
      
    $(window).scroll(function(){
        if($(window).width() > 480){
            if( $(window).scrollTop() > sticky_header_top ) {
                if(sticky_header_created == false){
                    cloneHeader();
                    sticky_header_created = true;
                    setTimeout(function() {
                         $('body').addClass('sticky-active');
                         $('#sticky_header').addClass('header-is-sticky');

                    }, 300);
                  
                } else{
                    $('body').addClass('sticky-active');
                   $('#sticky_header').addClass('header-is-sticky');  
                }            
            
            } else {
                $('body').removeClass('sticky-active');
                $('#sticky_header').removeClass('header-is-sticky');
            }
        } else{
            if(sticky_header_created == false){
                cloneHeader();
                sticky_header_created = true;               
            } else{
                $('body').addClass('sticky-active');
               // $('#sticky_header').addClass('header-is-sticky');  
            } 
            //call for hasScrolled() function
            setInterval();
        }        

    });
    
  }

    $(window).scroll(function(){
        didScroll = true;
    });

    function setInterval() {
        if (didScroll) {
            hasScrolled();
            didScroll = false;
        }
    }


    function cloneHeader(){
        var site_logo = $('.site-title').clone(true);
        var site_nav = $('.main-navigation').clone(true, true);
        var site_nav_res = $('.vce-res-nav').clone(true);
        $('body').prepend('<div id="sticky_header" class="header-sticky"><div class="container">'+site_nav_res.html()+'<div class="site-title">'+site_logo.html()+'</div><div class="main-navigation">'+site_nav.html()+'</div></div></div>');
        if( vce_js_settings.sticky_header_logo != "" && $("#sticky_header .site-title a img").length > 0 ){
            $("#sticky_header .site-title a img").attr("src",vce_js_settings.sticky_header_logo);
        }
            $("#sticky_header .site-title a img").css('height','auto').css('width','auto');

    }

    function hasScrolled() {
        var st = $(this).scrollTop();
        
        if(Math.abs(lastScrollTop - st) <= delta)
            return;

        if (st > lastScrollTop){
            // Scroll Down
            $('#sticky_header').removeClass('header-is-sticky');

        } else {
            // Scroll Up
            if(st  < navbarHeight) {
                $('#sticky_header').removeClass('header-is-sticky');
            }else{
                $('#sticky_header').addClass('header-is-sticky');
            }
        }

        lastScrollTop = st;
    }   

}
    //Our center function
    $.fn.vceCenter = function() {
        this.css("position","absolute");
        this.css("top",($(this).parent().height() - this.height() )/ 2 + "px");
        return this;
    }

    /* Display nicely some areas when images are finished with loading */
    
    $('.vce-featured').imagesLoaded().always( function( instance ) {
        $('.vce-featured .vce-featured-info').each(function(){
            $(this).vceCenter().animate({
                opacity: 1
            }, 400);
        });

        $('.vce-featured').animate({
                opacity: 1
        }, 400);
    });

    $('#vce-featured-grid').imagesLoaded().always( function( instance ) {
        
        if( vce_js_settings.lay_fa_grid_center ) {
            $('#vce-featured-grid .vce-featured-info').each(function(){
                $(this).vceCenter();
            });
        }

        $('#vce-featured-grid .vce-grid-item').animate({
                opacity: 1
        }, 400);
    });
    

    $('.vce-post-slider, .vce-post-big').imagesLoaded().always( function( instance ) {
        $('.vce-post-slider .vce-posts-wrap, .vce-post-big .vce-posts-wrap').each(function(){
            $(this).vceCenter().animate({
                opacity: 1
            }, 400);
        });
    });    

    }); //end document ready


/*-----------------------------------------------------------------------------------*/
/* RETINA LOGO
/*-----------------------------------------------------------------------------------*/

if( vce_js_settings.logo_retina != "" && $("#header .site-title img").length > 0 ){
  var retina = window.devicePixelRatio > 1;
  if (retina){
     $('#header .site-title').imagesLoaded().always( function( instance ) {
        var img_width = $('#header .site-title img').width();
        var img_height = $('#header .site-title img').height();
        
        $('#header .site-title img').css("width", img_width);
        $('#header .site-title img').css("height", img_height);

        $("#header .site-title img").attr("src",vce_js_settings.logo_retina);
    });

  }
}



})(jQuery);