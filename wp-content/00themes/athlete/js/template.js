(function ($) {
    "use strict";
    var html = '';
    var clickOutSite = false;
    var widthBox = $('#boxOpenTime').width();
    $('.img-box-right-border').css('border-left-width', widthBox + 'px');
    $(document).ready(function () {
        $(window).resize(function () {
            widthBox = $('#boxOpenTime').width();
            $('.img-box-right-border').css('border-left-width', widthBox + 'px');
        });
        $('a[href=#top]').click(function () {
            $('html, body').animate({
                scrollTop: 0
            }, 'slow');
            return false;
        });

        $('#to-bottom').click(function () {
            $('html, body').animate({
                scrollTop: $(this).offset().top
            }, 'slow');
            return false;

        });
        $('#select-demo').click(function () {
            $('html, body').animate({
                scrollTop: $('#to-bottom').offset().top
            }, 'slow');
            return false;

        });

        $('.about-con').each(function () {
            if ($(this).index() == 1) {
                $(this).addClass('block-item-special');
            }
        });

        $('.about-con').hover(function () {
            if (!$(this).hasClass('block-item-special') && !$(this).hasClass('blockItemFirst')) {
                $('.block-item-special').removeClass('block-item-special');
                $(this).addClass('block-item-special');
            }
        });
		
		/* Waypoint functions */
		if(typeof($.fn.waypoint) =='function'){
		
        $('.img-class').each(function (index) {
            $(this).waypoint(function () {
                $(this).animate({
                    width: "auto"
                }, 0, function () {
                    $(this).addClass('move_to_center');
                });
            }, {
                offset: '100%'
            });
        });

        $('.content-main-right .title-men, .content-main-right .desc-content, .content-main-right .join').each(function (index) {
            $(this).waypoint(function () {
                $(this).delay(400 * index + 700).animate({
                    width: "auto"
                }, 0, function () {
                    $(this).addClass('move_to_center');
                });
            }, {
                offset: '100%'
            });
        });
        $('.content-main-left .title-men, .content-main-left .desc-content, .content-main-left .join').each(function (index) {
            $(this).waypoint(function () {
                $(this).delay(400 * index + 700).animate({
                    width: "auto"
                }, 0, function () {
                    $(this).addClass('move_to_center');
                });
            }, {
                offset: '100%'
            });
        });

        $('.title-about').each(function (index) {
            $(this).waypoint(function () {
                $(this).animate({
                    width: "auto"
                }, 0, function () {
                    $(this).addClass('move_from_top');
                });
            }, {
                offset: '100%'
            });
        });

        $('.box-right').each(function (index) {
            $(this).waypoint(function () {
                $(this).delay(400 * index + 650).animate({
                    width: "auto"
                }, 0, function () {
                    $(this).addClass('move_to_center');
                });
            }, {
                offset: '100%'
            });
        });

        $('.box-left').each(function (index) {
            $(this).waypoint(function () {
                $(this).delay(400 * index + 650).animate({
                    width: "auto"
                }, 0, function () {
                    $(this).addClass('move_to_center');
                });
            }, {
                offset: '100%'
            });
        });

        $('.timetable .octember,.timetable .monday').addClass('move_to_fadein_top');
        $('.timetable .active .octember, .timetable .active .monday').removeClass('move_to_fadein_top');
        $('.timetable').waypoint(function () {
            $('.title-time, .active .octember, .active .monday').each(function (index) {
                $(this).delay(500 * index + 650).animate({
                    width: "auto"
                }, 0, function () {
                    $(this).addClass('move_to_fadein_top');
                });
            });
        }, {
            offset: '100%'
        });

        $('.demos-home').waypoint(function () {
            $('.demos-content').each(function (index) {
                $(this).delay(500 * index + 650).animate({
                    width: "auto"
                }, 0, function () {
                    $(this).addClass('move_to_fadein_top');
                });
            });
        }, {
            offset: '100%'
        });

        $('.banner-text').waypoint(function () {
            $('.athlete-html, .athlete-welcome, .athlete-desc, .link-to').each(function (index) {
                $(this).delay(500 * index + 650).animate({
                    width: "auto"
                }, 0, function () {
                    $(this).addClass('move_to_fadein_top');
                });
            });
        }, {
            offset: '100%'
        });

        $('.image-price-right, .image-price-left, .boxing-card-content, .yoga-card-content').each(function (index) {
            $(this).waypoint(function () {
                $(this).animate({
                    width: "auto"
                }, 0, function () {
                    $(this).addClass('move_to_center_img');
                });
            }, {
                offset: '100%'
            });
        });

        $('.ch-info-wrap, .success').each(function (index) {
            $(this).waypoint(function () {
                $(this).animate({
                    width: "auto"
                }, 0, function () {
                    $(this).addClass('move_to_fadein_title');
                });
            }, {
                offset: '100%'
            });
        });

        $('.fit-strong-left').waypoint(function () {
            $('.fit-strong-text, .fit-strong-sub, .fit-strong-bottom').each(function (index) {
                $(this).delay(600 * index).animate({
                    width: "auto"
                }, 0, function () {
                    $(this).addClass('move_to_fadein_title');
                });
            });
        }, {
            offset: '100%'
        });

        $('.fit-strong-right, .img-box-right').each(function (index) {
            $(this).waypoint(function () {
                $(this).delay(600 * index + 1000).animate({
                    width: "auto"
                }, 0, function () {
                    $(this).addClass('move_to_fadein_title');
                });
            }, {
                offset: '100%'
            });
        });

        $('.img-box-right').waypoint(function () {
            $('.img-box, .open-hour, .text-box').each(function (index) {
                $(this).delay(600 * index + 2000).animate({
                    width: "auto"
                }, 0, function () {
                    $(this).addClass('move_to_fadein_title');
                });
            });
        }, {
            offset: '100%'
        });

        $('.facts-page').waypoint(function () {
            $('.title-facts').each(function (index) {
                $(this).animate({
                    width: "auto"
                }, 0, function () {
                    $(this).addClass('move_to_fadein_title');
                });
            });

            var counter = 0;
            $('.facts-content .count span').each(function () {
                var el = this;
                counter++;
                var y = parseInt($(el).html());
                setTimeout(function () {
                    $({someValue: 0}).animate({someValue: y}, {
                        duration: 2000,
                        easing: 'swing', // can be anything
                        step: function () { // called on every step
                            $(el).html(Math.round(this.someValue));
                        },
                        complete: function () {
                            $(el).html(y);
                        }
                    });
                }, 1000 * counter);
            });

        }, {
            offset: '100%'
        });

        $('.facts-page').waypoint(function () {
            $('.facts-content').each(function (index) {
                $(this).delay(600 * index + 2000).animate({
                    width: "auto"
                }, 0, function () {
                    $(this).addClass('move_to_center');
                });
            });
        }, {
            offset: '100%'
        });

        $('.introduction').waypoint(function () {
            $('.intro-content').each(function (index) {
                $(this).delay(1000 * index + 2000).animate({
                    width: "auto"
                }, 0, function () {
                    $(this).addClass('move_to_fadein_title');
                });
            });
        }, {
            offset: '100%'
        });
		
		$('.masonry-small, .masonry-lagar').each(function (index) {
        $(this).waypoint(function () {
            $(this).delay(300 * index + 500).animate({
                width: "auto"
            }, 0, function () {
                $(this).addClass('move_to_center');
            });
        }, {
            offset: '100%'
        });
    });

    $('.product-store').waypoint(function () {
        $('.product-store .product-image-wrapper').each(function (index) {
            $(this).delay(500 * index + 650).animate({
                width: "auto"
            }, 0, function () {
                $(this).addClass('move_to_fadein_top');
            });
        });
    }, {
        offset: '100%'
    });

    $('.sport-box').each(function (index) {
        $(this).waypoint(function () {
            $(this).delay(500 * index + 650).animate({
                width: "auto"
            }, 0, function () {
                $(this).addClass('move_to_center_img');
            });
        }, {
            offset: '100%'
        });
    });

    $('.calendar-note').mouseleave(function () {
        $('.calendar-details').hide();
        $('.calendar-active.active').removeClass('active');
    });
    $('#contents-main .scroll-to').each(function (index) {
        $(this).waypoint(function (direction) {
            if (direction === 'down') {
                $('.header').removeClass('alt');
            } else if (direction === 'up') {
                $('.header').addClass('alt');
            }
        }, {
            offset: '100%'
        });

    });
	}
	/*end waypoint*/
	
	if($('#wpadminbar').length){
		$('#header').css('margin-top', (parseInt($('#header').css('margin-top')) + parseInt($('#wpadminbar').height()))+'px');
	}
    });

    $('.owl-page').click(function () {
        var owl1 = $('#carousel-text').data('owlCarousel');
        var owl2 = $('#carousel-image').data('owlCarousel');
        $('.owl-page').removeClass('active');
        $(this).addClass('active');
        owl1.goTo($(this).attr('data-page'));
        owl2.goTo($(this).attr('data-page'));
    });
    function showproduct() {
        var url = 'product-detail.html';
        window.location.href = url;
    }
    var heightW = $(window).height();
    $('#contents-main').css('margin-top', heightW + 'px');
    $(window).resize(function () {
        var heightW = $(window).height();
        $('#contents-main').css('margin-top', heightW + 'px');
    });

    /** PARALLAX LAYERS EFFECT FOR WELCOME PAGE**/
    if (typeof Parallax !== 'undefined' && $('#scene').length) {
        $('#scene .layer-bg').css({
            height: ($(window).height() + 400) + 'px',
            width: ($(window).width() + 400) + 'px'
        });
        $(window).resize(function () {
            $('#scene .layer-bg').css({
                height: ($(window).height() + 400) + 'px',
                width: ($(window).width() + 400) + 'px'
            });
        })
        new Parallax(document.getElementById('scene'));
    }

    // add active and selected class for parents menu;
    $('.menu-item.selected').parents('li').each(function () {
        $(this).addClass('selected active');
    });


    window.increaseQty = function (el, count) {
        var $el = $(el).parent().find('.qty');
        $el.val(parseInt($el.val()) + count);
    }
    window.decreaseQty = function (el, count) {
        var $el = $(el).parent().find('.qty');
        var qtya = parseInt($el.val()) - count;
        if (qtya < 1) {
            qtya = 1;
        }
        $el.val(qtya);
    }

    /** Quick view product */
    $('.quickview').on('click', function (e) {
        var el = this;
        $(el).parents('.product-image-wrapper').find('.product-image').append('<i class="quickviewloading fa fa-cog fa-spin"></i>');
        var effect = $(el).find('input').val();
        $.fn.custombox({
            url: woocommerce_params.ajax_url + '?action=load_product_quick_view&product_id=' + el.href.split('#')[1],
            effect: effect?effect:'fadein',
            complete: function () {
                $(el).parents('.product-image-wrapper').find('.quickviewloading').remove();
                var owl = $(".quickview-body .owl-carousel");
                owl.owlCarousel({
                    direction:$('body').hasClass('rtl')?'rtl':'ltr',
                    items: 5,
                    pagination: false
                });
                $(".quickview-body .next").click(function () {
                    owl.trigger('owl.next');
                })
                $(".quickview-body .prev").click(function () {
                    owl.trigger('owl.prev');
                });
                $(".quickview-body .woocommerce-main-image").click(function (e) {
                    e.preventDefault();
                })
                $(".quickview-body .owl-carousel .owl-item a").click(function (e) {
                    e.preventDefault();
                    if ($(".quickview-body .woocommerce-main-image img").length == 2) {
                        $(".quickview-body .woocommerce-main-image img:first").remove();
                    }
                    $(".quickview-body .woocommerce-main-image img").fadeOut(function () {
                        $(".quickview-body .woocommerce-main-image img").stop().hide();
                        $(".quickview-body .woocommerce-main-image img:last").fadeIn();
                    });
                    $(".quickview-body .woocommerce-main-image").append('<img class="attachment-shop_single wp-post-image" style="display:none;" src="' + this.href + '" alt="">');

                })
            },
            close: function () {
                $(el).parents('.product-image-wrapper').find('.quickviewloading').remove();
            }
        });
        e.preventDefault();
    });

    $('.my-cart').click(function () {
        if (!$(this).hasClass('active')) {
            $(this).addClass('active');
            $('.icon-cart .carts-store').show().animate({
                'margin-right': 0
            }, 400, 'easeInOutExpo');
        } else {
            $(this).removeClass('active');
            $('.icon-cart .carts-store').animate({
                'margin-right': '-280px'
            }, 400, 'easeInOutExpo', function () {
                $('.icon-cart .carts-store').hide()
            });
        }
        clickOutSite = false;
        setTimeout(function () {
            clickOutSite = true;
        }, 100);
    });
    $('.icon-cart .carts-store').click(function () {
        clickOutSite = false;
        setTimeout(function () {
            clickOutSite = true;
        }, 100);
    });
    $(document).click(function () {
        if (clickOutSite && $('.my-cart').hasClass('active')) {
            $('.my-cart').trigger('click');
        }
    });

    /** Product detail  slider thumb image */
    var owl = $("#owl-demo");
    owl.owlCarousel({
        direction:$('body').hasClass('rtl')?'rtl':'ltr',
        items: 5,
        itemsDesktop: [1000, 5],
        itemsDesktopSmall: [900, 3],
        itemsTablet: [600, 2],
        itemsMobile: false,
        pagination: false
    });
    $("#owl-demo .next").click(function () {
        owl.trigger('owl.next');
    });
    $("#owl-demo .prev").click(function () {
        owl.trigger('owl.prev');
    });
    $('#tabs').tabs();

    $('.blog-item .gallery,.img-sport .gallery').each(function(){
		var galleryOwl = $(this);
        var classNames = this.className.toString().split(' ');
        var column = 1;
        $.each(classNames, function (i, className) {
            if(className.indexOf('gallery-columns-')!=-1){
                column = parseInt(className.replace(/gallery-columns-/,''));
            }
        });
		galleryOwl.owlCarousel({
            direction:$('body').hasClass('rtl')?'rtl':'ltr',
			items:column,
            singleItem:column==1,
			navigation: true,
			pagination: false,
            navigationText: ["<i class=\"fa fa-chevron-left\"></i>", "<i class=\"fa fa-chevron-right\"></i>"],
			autoHeight: true
		});
        //galleryOwl.find('a').click(function(e){e.preventDefault();});

	});

    /*Responsive & fit video*/
    $(".img-blog,.blog-content").fitVids();
    
    /**
     * submitProductsLayout
     */
    window.submitProductsLayout = function (layout) {
        $('.product-category-layout').val(layout);
        $('.woocommerce-ordering').submit();
    }

    /**
     * Woocommerce Checkout Form
     */
    $('.woocommerce-checkout .title .fa').on('click', function () {
        if ($(this).hasClass('fa-minus-square-o')) {
            $(this).removeClass('fa-minus-square-o').addClass('fa-plus-square-o');
        } else {
            $(this).removeClass('fa-plus-square-o').addClass('fa-minus-square-o');
        }
        $(this).parent().next().slideToggle();
    });
    $('.add_to_cart_button').on('click', function (e) {

        if($(this).find('.fa-check').length){
            e.preventDefault();
            return;
        }
        $(this).addClass('cart-adding');
        $(this).find('i').removeClass('fa-shopping-cart').addClass('fa-cog fa-spin');

    })
    $('.add_to_wishlist').on('click', function (e) {
        if($(this).find('.fa-check').length){
            e.preventDefault();
            return;
        }
        $(this).addClass('wishlist-adding');
        $(this).find('i').removeClass('fa-star').addClass('fa-cog fa-spin');
    })
    $('.yith-wcwl-add-to-wishlist').appendTo('.add-to-box');
    $('.yith-wcwl-add-to-wishlist .link-wishlist').appendTo('.add-to-box form.cart');


    //trigger events add cart and wishlist
    $('body').on('added_to_wishlist', function () {
        $('.wishlist-adding').html('<i class="fa fa-check"></i>');
        $('.wishlist-adding').removeClass('wishlist-adding');
    });
    $('body').on('added_to_cart', function (e, f) {
        $('.added_to_cart.wc-forward').remove();
        $('.cart-adding').html('<i class="fa fa-check"></i>');
        $('.cart-adding').removeClass('cart-adding');
    });


    $(window).load(function() {
        $("#preloader").delay(100).fadeOut("slow");
        $("#load").delay(100).fadeOut("slow");
    });


    //jQuery to collapse the navbar on scroll
    if ($(".navbar").length) {
        $(window).scroll(function() {
            if ($(".navbar").offset().top > 50) {
                $(".navbar-fixed-top").addClass("top-nav-collapse");
            } else {
                $(".navbar-fixed-top").removeClass("top-nav-collapse");
            }
        });
    }
    /**
     * jQuery for page scrolling feature - requires jQuery Easing plugin
     * onepage, about us page
     */

    $(function() {
        /* SCROLL TO ANCHOR ELEMENT*/
        $('.mainnav li a,.page-scroll a').bind('click', function(event) {
            var anchor = $(this).attr('href');
            if(anchor.indexOf('#')>=0 && $(anchor).length) {
                $(this).parent().parent().find('li').removeClass('selected active');
                $(this).parent().addClass('selected active');
                var top;
                if (anchor == '#home' || anchor == '#') {
                    top = 0;
                } else {
                    top = $(anchor).offset().top;
                    if($('#header').css('position')=='fixed'){
                        top -= $('#header').height();
                    }
                }
                $('html, body').stop().animate({
                    scrollTop: top
                }, 1500, 'easeInOutExpo');
				window.location.hash = anchor;
                event.preventDefault();
            }
        });
        /** ONE PAGE NAVIGATION ACTIVE */
        $('.one-page .mainnav li:first').addClass('selected active');
        $(document).on('scroll',function(){
			$('.one-page .mainnav li a').each(function(){
				var anchor = $(this).attr('href');
				if(anchor.indexOf('#')>=0 &&  $(anchor).length) {
					var el = this;
					var top = $(anchor).offset().top;
					if (anchor == '#home' || anchor == '#') {
						top = 0;
					} else {
						top = $(anchor).offset().top;
						if($('#header').css('position')=='fixed'){
							top -= $('#header').height();
						}
					}
					if($(document).scrollTop() < top + 150 && $(document).scrollTop() > top - 150 ){
						$('.one-page .nav-menu li').removeClass('selected active');
						$(el).parent().addClass('selected active');
					}
				}
			});
		});
    });



    /** PANEL FUNCTION **/
    var colorSetting = '';
    var defaultSetting = '';
    var timeout = 0;
    $(document).ready(function () {
        if ($('.wrapper').hasClass('welcome') || $('.wrapper').hasClass('coming-soon') || $('.panel-tools').length == 0) {
            $('.panel-tools').hide();
            return;
        }
        $.ajax({
            type: "GET",
            url: athleteCfg.baseUrl + '/wp-content/themes/athlete/css/color.css',
            dataType: "html",
            success: function (result) {
                colorSetting = result;
            }
        });
        panelSetting();
    });
    function panelSetting() {
        $('.color-setting button').each(function () {
            if (this.value[0] == '#') {
                $(this).css('background-color', this.value);
            } else {
                $(this).css('background', 'url(' + this.value + ')');
            }
        });
        $('body').append('<style type="text/css" id="color-setting"></style>');
        panelBindEvents();
        panelLoadSetting();

    }
    function panelBindEvents() {
        var clickOutSite = true;
        $('.panel-button').click(function () {
            if (!$(this).hasClass('active')) {
                $(this).addClass('active');
                $('.panel-content').show().animate({
                    'margin-left': 0
                }, 400, 'easeInOutExpo');
            } else {
                $(this).removeClass('active');
                $('.panel-content').animate({
                    'margin-left': '-240px'
                }, 400, 'easeInOutExpo', function () {
                    $('.panel-content').hide()
                });
            }
            clickOutSite = false;
            setTimeout(function () {
                clickOutSite = true;
            }, 100);
        });
        $('.panel-content').click(function () {
            clickOutSite = false;
            setTimeout(function () {
                clickOutSite = true;
            }, 100);
        });
        $(document).click(function () {
            if (clickOutSite && $('.panel-button').hasClass('active')) {
                $('.panel-button').trigger('click');
            }
        });

        $('.layout-setting button').click(function () {
            if (!$(this).hasClass('active')) {
                $('.layout-setting button').removeClass('active');
                $(this).addClass('active');
                panelAddOverlay();
                panelWriteSetting();
                $(window).resize();
            }
        });
        $('.background-setting button').click(function () {
            if ($('.layout-setting button.active').val() == 'wide') {
                return;
            }
            if (!$(this).hasClass('active')) {
                $('.background-setting button').removeClass('active');
                $(this).addClass('active');
                if (this.value[0] == '#') {
                    $('body').css('background', this.value);
                } else {
                    $('body').css('background', 'url(' + this.value + ')');
                }
                panelWriteSetting();
            }
        });
        $('.sample-setting button').click(function () {
            if (!$(this).hasClass('active')) {
                $('.sample-setting button').removeClass('active');
                $(this).addClass('active');
                var newColorSetting = colorSetting.replace(/#ec3642/g, this.value);
                $('#color-setting').html(newColorSetting);
                panelWriteSetting();
            }
        });
        $('.reset-button button').click(function () {
            panelApplySetting(defaultSetting);
            setCookie('layoutsetting', '');
            var link;
            if(document.location.href.indexOf('=rtl')){
                link = document.location.href.replace(/=rtl/,'=ltr')
            }else{
                if(document.location.href.indexOf('&')>0) {
                    link = document.location.href + '?d=rtl';
                }else{
                    link = document.location.href + '&d=rtl';
                }
            }
            document.location.href = link;
        });
        $('.switch-ltr').click(function(){

        });

    }
    function panelAddOverlay() {
        if ($('.layout-setting .active').hasClass('boxed')) {
            $('.overlay-setting').removeClass('disabled');
            $('body').addClass('body-boxed');
        } else {
            $('.overlay-setting').addClass('disabled');
            $('body').removeClass('body-boxed');
        }
    }
    function panelLoadSetting() {
        // remember default setting
        defaultSetting = getCookie('layoutsetting-default');
        if (defaultSetting) {
            defaultSetting = JSON.parse(defaultSetting);
        } else {
            defaultSetting = {
                layout: $('.layout-setting button.active').val(),
                mainColor: $('.sample-setting button.active').val(),
                bgColor: $('.background-setting button.active').val()
            }
            setCookie('layoutsetting-default', JSON.stringify(defaultSetting), 0);
        }
    }
    function panelApplySetting(setting) {
        $('.layout-setting button').each(function () {
            if (setting.layout == this.value) {
                $(this).trigger('click');
            }
        });
        $('.sample-setting button').each(function () {
            if (setting.mainColor == this.value) {
                $(this).trigger('click');
            }
        });
        $('.background-setting button').each(function () {
            if (setting.bgColor == this.value) {
                $(this).trigger('click');
            }
        });
    }
    function panelWriteSetting() {
        var activeSetting = {
            layout: $('.layout-setting button.active').val(),
            mainColor: $('.sample-setting button.active').val(),
            bgColor: $('.background-setting button.active').val()
        }
        setCookie('layoutsetting', JSON.stringify(activeSetting), 0);
    }

    /** CONTACT FORM **/
    $('.main-contact-form').submit(function (e) {
        $.ajax({
            type: "POST",
            url: athleteCfg.ajaxUrl,
            data: $(this).serialize(),
            dataType: "json",
            beforeSend: function (xhr) {
                $('.contact-submit .contact-ajax-overlay').show();
            },
            success: function (result) {
                if (result.success) {
                    $('.contact-submit .btn-submit').addClass('btn-success');
                    $('#main-contact-form').get(0).reset();
                } else {
                    $('.contact-submit .btn-submit').addClass('btn-error');

                }
                $('.contact-submit .contact-ajax-overlay').hide();
                setTimeout(function () {
                    $('.contact-submit .btn-submit').removeClass('btn-error');
                    $('.contact-submit .btn-submit').removeClass('btn-success');
                }, 3000);
            }
        });
        e.preventDefault();
    });
    $(document).ready(function () {
        var imgs = $('.iw-events .timetable-cont img.event-img');
        imgs.each(function () {
            var imgfocus = $(this);
            var img = new Image();
            $(img).load(function () {
                var img_height = $(img)[0].height;
                var img_width = $(img)[0].width;
                if (img_height > img_width) {
                    var img_class = 'full-width';
                } else {
                    var img_class = 'full-height';
                }
                imgfocus.addClass(img_class);
            }).error(function () {
            }).attr('src', imgfocus.attr('src'));
        });
    });
    $('.main-contact-form input,.main-contact-form textarea').focus(function () {
        $('.btn-submit').removeClass('btn-error');
        $('.btn-submit').removeClass('btn-success');
    });

    /** COOKIE FUNCTION */
    function setCookie(cname, cvalue, exdays) {
        var expires = "";
        if (exdays) {
            var d = new Date();
            d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
            expires = " expires=" + d.toUTCString();
        }
        document.cookie = cname + "=" + cvalue + ";" + expires + '; path=/';
    }
    function getCookie(cname) {
        var name = cname + "=";
        var ca = document.cookie.split(';');
        for (var i = 0; i < ca.length; i++) {
            var c = ca[i];
            while (c.charAt(0) == ' ')
                c = c.substring(1);
            if (c.indexOf(name) == 0)
                return c.substring(name.length, c.length);
        }
        return "";
    }
	
	/**
		open popup function for sharing buttons
	*/
	window.iwOpenWindow = function(url){
		window.open(url,'sharer','toolbar=0,status=0,left='+((screen.width/2)-300)+',top='+((screen.height/2)-200)+',width=650,height=380');	
		return false;
	}
	
	/**
		Equal height for list items
	*/
	window.equalHeight = function(container){
		var maxHeight = 0;
		$(container).each(function() {
			var $el = $(this);
			if($el.height() > maxHeight){
				maxHeight = $el.height();
			}
		})
		$(container).height(maxHeight);	
	}

	$(document).ready(function() {
	  equalHeight('.about .infor-item');
	});

	$(window).resize(function(){
	  equalHeight('.about .infor-item');
	});
	
})(jQuery);
