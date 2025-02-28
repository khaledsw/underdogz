/**
 * Script process actions for admin page
 *
 * @author gmswebdesign
 * @package AP Background
 * @version 1.0.0
 */


jQuery(document).ready(function () {
    var frame, target;

    //Xu ly khi nut bam create parallax dc click
    jQuery('.control-buttons .create-button span').click(function () {
        jQuery('.bt-parallax-select-slide-type.hidden').appendTo('body').fadeIn(500, function () {
            jQuery(this).removeClass('hidden');
        });
    });

    //
    jQuery('.video-background .select-image .control-button .control-buttom').click(function () {
        jQuery('.bt-parallax-select-bg-type.hidden').appendTo('body').fadeIn(500, function () {
            jQuery(this).removeClass('hidden');
        });
    });

    //code xu ly khi click vao element de thuc hien get content (image, video) twf cacs nguon tuong ung
    jQuery('.image .from-flickr, .image .from-facebook, .image .from-google, #videos .from-youtube, #videos .from-vimeo, #videos .from-embed-code').click(function () {
        jQuery('.bt-parallax-get-media-item.hidden').appendTo('body').fadeIn(500, function () {
            jQuery(this).removeClass('hidden');
        });
        var list = jQuery('.bt-parallax-get-media-item .get-from-wrap');
        var itemclick = this;
        list.each(function () {
            if (jQuery(itemclick).hasClass('from-flickr') && jQuery(this).hasClass('flickr')) {
                jQuery(this).show(0).addClass('active');
            } else if (jQuery(itemclick).hasClass('from-youtube') && jQuery(this).hasClass('youtube')) {
                jQuery(this).show(0).addClass('active');
            } else if (jQuery(itemclick).hasClass('from-facebook') && jQuery(this).hasClass('facebook')) {
                jQuery(this).show(0).addClass('active');
            } else if (jQuery(itemclick).hasClass('from-google') && jQuery(this).hasClass('picasa')) {
                jQuery(this).show(0).addClass('active');
            } else if (jQuery(itemclick).hasClass('from-vimeo') && jQuery(this).hasClass('vimeo')) {
                jQuery(this).show(0).addClass('active');
            } else if (jQuery(itemclick).hasClass('from-embed-code') && jQuery(this).hasClass('embedcode')) {
                jQuery(this).show(0).addClass('active');
            } else {
                return;
            }
        });
    });

    //Select content slideshow type
    jQuery('.bg-content-type-list .content-type-item').click(function () {
        if (jQuery(this).hasClass('selected')) {
            return;
        }
        var list = jQuery('.bg-content-type-list .content-type-item');
        jQuery(this).addClass('selected');
        var url = btAdvParallaxBackgroundCfg.siteUrl + 'admin.php?page=bt-advance-parallax-background/create-new';
        if (jQuery(this).hasClass('video-background')) {
            url = url += '&content_type=video-background';
        } else if (jQuery(this).hasClass('image-gallery')) {
            url = url += '&content_type=image-gallery';
        } else if (jQuery(this).hasClass('woo-commerce')) {
            url = url += '&content_type=woo-commerce';
        } else if (jQuery(this).hasClass('wordpress-posts')) {
            url = url += '&content_type=wordpress-posts';
        } else {
            url = url += '&content_type=video-background';
        }

        jQuery('.create-slideshow a').attr('href', url);
        var itemclick = this;
        list.each(function () {
            if (list.index(this) !== list.index(itemclick) && jQuery(this).hasClass('selected')) {
                jQuery(this).removeClass('selected');
            }
        });
    });

    //An khoi chon kieu content type khi tao moi parallax
    jQuery('.bt-parallax-select-slide-type').click(function (event) {
        if (jQuery(event.target).hasClass('bt-parallax-select-slide-type')) {
            jQuery(this).fadeOut(500, function () {
                jQuery(this).addClass('hidden');
            });
        }
    });

    //Dong chon color, textured, opacity kho click chuot ra ngoai phap vi control
    jQuery('body').click(function (event) {
        if (jQuery(event.target).closest('.control-button, .input-slider').length === 0) {
            var opacity = jQuery('.opacity .control-button');
            var color = jQuery('.colorbox .control-buttom');
            var textured = jQuery('.colorbox .control-top');
            if (opacity.hasClass('active')) {
                opacity.removeClass('active');
                opacity.parent().parent().find('.input-slider').slideUp();
            }
            if (color.hasClass('active')) {
                color.removeClass('active');
                var par = color.parents('.control');
                jQuery(par).find('.input-color-box').slideUp();
                jQuery('.input-color-bgcontent-box .wp-picker-holder').slideUp();
            }
            if (textured.hasClass('active')) {
                textured.removeClass('active');
                var par = textured.parents('.control');
                jQuery(par).find('.list-textured').slideUp();
            }
        }
    });

    //Dong popop chon background type khi click chuot ra ngoai pham vi popup
    jQuery('.bt-parallax-select-bg-type').click(function (event) {
        if (jQuery(event.target).hasClass('bt-parallax-select-bg-type')) {
            jQuery(this).fadeOut(500, function () {
                jQuery(this).addClass('hidden');
            });
        }
    });
    jQuery('.bt-parallax-get-media-item').click(function (event) {
        if (jQuery(event.target).hasClass('bt-parallax-get-media-item')) {
            jQuery(this).fadeOut(500, function () {
                jQuery(this).addClass('hidden');
                jQuery('.bt-parallax-get-media-item .get-from-wrap').hide().removeClass('active');
            });
        }
    });
    jQuery('.bt-parallax-edit-media-gallery-item').click(function (event) {
        if (jQuery(event.target).hasClass('bt-parallax-edit-media-gallery-item')) {
            jQuery(this).fadeOut(500, function () {
                jQuery(this).addClass('hidden');
                jQuery('.bt-parallax-edit-media-gallery-item .get-from-wrap').hide().removeClass('active');
            });
        }
    });

//    Tabs control
    jQuery('.tabs .tab-links a').on('click', function (e) {
        var currentAttrValue = jQuery(this).attr('href');

        // Show/Hide Tabs
        jQuery('.tabs ' + currentAttrValue).show().siblings().hide();

        // Change/remove current tab to active
        jQuery(this).parent('li').addClass('active').siblings().removeClass('active');

        e.preventDefault();
    });

    //Select layout
    jQuery('.layout-list .item-layout').click(function () {
        if (jQuery(this).hasClass('selected')) {
            return;
        }
        var list = jQuery('.layout-list .item-layout');
        jQuery(this).addClass('selected');
        jQuery(this).parent().find('input').val(jQuery(this).data('layout'));
        var itemclick = this;
        list.each(function () {
            if (list.index(this) !== list.index(itemclick) && jQuery(this).hasClass('selected')) {
                jQuery(this).removeClass('selected');
            }
        });
    });


//Su kien khi click vao nut selec item tron sanh sach media item (image, video) khi them moi hoac edit paralalx slider
    jQuery('.inner-control span.select').live('click', function () {
        if (jQuery(this).hasClass('selected')) {
            jQuery(this).removeClass('selected').parent().parent().removeAttr('style').find('span.delete').show();
            jQuery(this).removeClass('selected').parent().parent().removeAttr('style').find('span.edit').show();
        } else {
            jQuery(this).addClass('selected').parent().parent().css({'background': 'transparent', 'opacity': '1'}).find('span.delete').hide();
            jQuery(this).addClass('selected').parent().parent().css({'background': 'transparent', 'opacity': '1'}).find('span.edit').hide();
        }
    });

    //Su khi click vao nut delete item trong danh sach media item (image,video) khi them moi hoac edit parallax slider
    jQuery('.inner-control span.delete').live('click', function () {
        jQuery(this).parents('.media-item').fadeOut(200, function () {
            jQuery(this).remove();
        });
    });

    //Su khi click vao nut edit item trong danh sach media item (image,video) khi them moi hoac edit parallax slider
    jQuery('.inner-control span.edit').live('click', function () {
        jQuery('.bt-parallax-edit-media-gallery-item').appendTo('body').fadeIn(500, function () {
            jQuery(this).removeClass('hidden');
        });

        //Lay ve danh sach cac khoi noi dung tuong ung voi tung loai item
        var list = jQuery('.bt-parallax-edit-media-gallery-item .get-from-wrap');
        target = jQuery(this);

        //lay ve gia tri cua item duoc click
        var itemdata = jQuery.parseJSON(target.parents('.media-item').find('input').val());

        //Duyet qua tung phan tu cua mamh va kem tra xem item duoc clock la item nao, tu do hien thi va fill gia tri tuong ung vao
        list.each(function () {
            if (itemdata.media_source === 'youtube' && jQuery(this).hasClass('youtube')) {
                jQuery('#youtube_url_edit').val('https://www.youtube.com/watch?v=' + itemdata.video_url);
                jQuery(this).show(0).addClass('active');
            } else if (itemdata.media_source === 'upload' && jQuery(this).hasClass('upload')) {
                jQuery('#video_upload_edit').val(itemdata.video_url);
                jQuery(this).show(0).addClass('active');
            } else if (itemdata.media_source === 'vimeo' && jQuery(this).hasClass('vimeo')) {
                jQuery('#vimeo_url_edit').val('https://vimeo.com/' + itemdata.video_url);
                jQuery(this).show(0).addClass('active');
            } else if (itemdata.media_source === 'embedcode' && jQuery(this).hasClass('embedcode')) {
                jQuery('#video_embedcode_edit').val(unescape(itemdata.video_url));
                jQuery(this).show(0).addClass('active');
            } else if ((itemdata.media_source === 'image_upload' || itemdata.media_source === 'flickr' ||
                    itemdata.media_source === 'facebook' || itemdata.media_source === 'picasa') && jQuery(this).hasClass('image-edit')) {
                jQuery('#image_new_url').val(itemdata.large);
                jQuery(this).show(0).addClass('active');
            } else {
                return;
            }
        });
    });

    //Su kien xu ly khi nut bam save edit item duoc click
    jQuery('.create-slideshow .edit-update-item').click(function () {
        jQuery('.bt-parallax-edit-media-gallery-item').fadeOut(500, function () {
            jQuery(this).addClass('hidden');
            jQuery('.bt-parallax-edit-media-gallery-item .get-from-wrap').hide().removeClass('active');
        });
        var e = jQuery(this).parents('.bg-type-list-wrap').find('.active');
        if (e.hasClass('image-edit')) {
            var newImage = e.find('input').val();
            var img = new Image();
            jQuery(img).load(function () {
                var img_height = jQuery(img)[0].height;
                var img_width = jQuery(img)[0].width;
                if (img_height > img_width) {
                    var attr = {'src': newImage, height: 130};
                } else {
                    var attr = {'src': newImage, width: 130};
                }
                var data = '{"large":"' + newImage + '","thumbnail":"' + newImage + '","media_source":"image_upload"}';
                target.parents('.media-item').find('img').removeAttr('width height').attr(attr);
                target.parents('.media-item').find('input').val(data);
            }).error(function () {
                alert('Can\'t load image!');
            }).attr('src', newImage);
        }
        //Edit video upload
        if (e.hasClass('upload')) {
            var newVideo = e.find('input').val();
            var data = '{"large":"","thumbnail":"", "video_url":"' + newVideo + '", "media_source":"upload"}';
            target.parents('.media-item').find('input').val(data);
        }
        //Edit video embed
        if (e.hasClass('embedcode')) {
            var newVideoCode = e.find('textarea').val();
            var data = '{"large":"","thumbnail":"", "video_url":"' + escape(newVideoCode) + '", "media_source":"embedcode"}';
            target.parents('.media-item').find('input').val(data);
        }
        //Edit video youtube
        if (e.hasClass('youtube') || e.hasClass('vimeo')) {
            var newVideoUrl = e.find('input').val();
            jQuery.ajax({
                url: btAdvParallaxBackgroundCfg.ajaxUrl,
                data: {action: 'getVideobackground', url: newVideoUrl},
                type: "post",
                beforeSend: function () {
                },
                success: function (data) {
                    var a = jQuery.parseJSON(data);
                    if (a.success) {
                        var b = jQuery.parseJSON(a.data);
                        var img = new Image();
                        jQuery(img).load(function () {
                            var img_height = jQuery(img)[0].height;
                            var img_width = jQuery(img)[0].width;
                            if (img_height > img_width) {
                                var attr = {'src': b.large, height: 130};
                            } else {
                                var attr = {'src': b.large, width: 130};
                            }
                            target.parents('.media-item').find('img').removeAttr('width height').attr(attr);
                            target.parents('.media-item').find('input').val(a.data);
                        }).error(function () {
                            alert('Can\'t load image!');
                        }).attr('src', b.large);
                    } else {
                        alert(a.message);
                    }
                }
            });
        }
    });

    //Su kien khi opacity thay doi
    jQuery('.change-opacity').on('input', function () {
        var ranVal = jQuery(this).val();
        jQuery(this).parent().parent().find('.inner-image .pattern').css('opacity', ranVal);
        jQuery(this).parent().find('.change-opacity-text').val(parseInt(ranVal * 100));
    });

    //Su kien dong mo control opacity change
    jQuery('.opacity .control-button').click(function () {
        jQuery(this).toggleClass('active');
        jQuery(this).parent().parent().find('.input-slider').slideToggle();
    });

    //Su kien dong mo color control
    jQuery('.colorbox .control-buttom').click(function () {
        jQuery(this).toggleClass('active');
        var par = jQuery(this).parent().parent().parent();
        jQuery(par).find('.input-color-box').slideToggle();
        if (jQuery(this).parent().find('.control-top').hasClass('active')) {
            jQuery(this).parent().find('.control-top').removeClass('active');
            jQuery(par).find('.list-textured').slideUp();
        }
    });

    //Su kien dong mo textured control
    jQuery('.colorbox .control-top').click(function () {
        jQuery(this).toggleClass('active');
        var par = jQuery(this).parent().parent().parent();
        jQuery(par).find('.list-textured').slideToggle();
        if (jQuery(this).parent().find('.control-buttom').hasClass('active')) {
            jQuery(this).parent().find('.control-buttom').removeClass('active');
            jQuery(par).find('.input-color-box').slideUp();
        }
    });

    //Su kien khi texttured duoc chon
    jQuery('.list-textured .textured-item').click(function () {
        jQuery(this).parent().find('input').val(jQuery('div', this).attr('class'));
        jQuery(this).parent().parent().find('.inner-image').css('backgroundImage', jQuery('div', this).css('backgroundImage'));
        jQuery(this).parents('.control-group').find('.opacity .inner-image .pattern').css('backgroundImage', jQuery('div', this).css('backgroundImage'));
        jQuery(this).parents('.control').find('.control-top').removeClass('active');
        jQuery(this).parent().slideUp();
    });

    //Su kien open popup de chon video tu wp madia de lam background
    jQuery('.video-background .select-image .control-button .control-top').on('click', function (e) {
        e.preventDefault();
        var element = this;

        // Set options
        var options = {
            state: 'insert',
            frame: 'post',
            multiple: false,
            library: {
                type: 'video'
            }
        };
        frame = wp.media(options).open();
        // Tweak views
        frame.menu.get('view').unset('gallery');
        frame.menu.get('view').unset('featured-image');

        frame.toolbar.get('view').set({
            insert: {
                style: 'primary',
                text: 'Insert',
                click: function () {
                    var models = frame.state().get('selection'),
                            url = models.first().attributes.url;

                    var data = '{"large":"", "video_url":"' + url + '", "media_source":"direct"}';
                    jQuery(element).parents('.background-act').find('.background_video').val(data);
                    jQuery(element).parents('.background-act').find('.inner-image').html('<div class="video-file"><span><i  class="fa fa-file-video-o fa-3x"></i></span></div>');
                    jQuery(element).parents('.video-background').find('.opacity .inner-image .image').html('<div class="video-file"><span><i  class="fa fa-file-video-o fa-3x"></i></span></div>');
                    frame.close();
                }
            } // end insert
        });
    });

    //Su kien open popup de chon anh tu wp madia de lam background
    jQuery('.img-background .select-image .control-button, .content-type-item.upload').on('click', function (e) {
        e.preventDefault();
        var element = this;

        // Set options
        var options = {
            state: 'insert',
            frame: 'post',
            multiple: false,
            library: {
                type: 'image'
            }
        };
        frame = wp.media(options).open();
        // Tweak views
        frame.menu.get('view').unset('gallery');
        frame.menu.get('view').unset('featured-image');

        frame.toolbar.get('view').set({
            insert: {
                style: 'primary',
                text: 'Insert',
                click: function () {
                    var models = frame.state().get('selection'),
                            url = models.first().attributes.url;

                    jQuery(element).parent().find('.background_image').val(url);
                    jQuery(element).parent().find('.inner-image').html('<img src="' + url + '" alt=""/>');
                    jQuery(element).parents('.img-background').find('.opacity .inner-image .image').html('<img src="' + url + '" alt=""/>');
                    fixImagebackgroundView();
                    frame.close();
                }
            } // end insert
        });
    });

    var colorPickerOptions = {
        // you can declare a default color here,
        // or in the data-default-color attribute on the input
        defaultColor: false,
        // a callback to fire whenever the color changes to a valid color
        change: function (event, ui) {
//            jQuery(this).parents('.control').find('.inner-image').html('');
            jQuery(this).parents('.control').find('.inner-image').css('backgroundColor', ui.color.toString());
            jQuery(this).parents('.control-group').find('.opacity .inner-image .pattern').css('backgroundColor', ui.color.toString());
        },
        // a callback to fire when the input is emptied or an invalid color
        clear: function () {
            jQuery(this).parent().parent().parent().parent().find('.inner-image').css('backgroundColor', 'transparent');
            jQuery(this).parent().find('.input-color').val('');
            jQuery(this).parents('.control-group').find('.opacity .inner-image .pattern').css('backgroundColor', 'transparent');
        },
        // hide the color picker controls on load
        hide: true,
        // show a group of common colors beneath the square
        // or, supply an array of colors to customize further
        palettes: true
    };

    //Tao color picker cho phep chon mau cho background
    jQuery('.input-color').wpColorPicker(colorPickerOptions);
    //Open color picker box
    jQuery('.input-color-bgcontent').click(function () {
        jQuery('.input-color-bgcontent-box .wp-picker-holder').slideDown();
    });

    var colorPickerContentOptions = {
        // you can declare a default color here,
        // or in the data-default-color attribute on the input
        defaultColor: false,
        // a callback to fire whenever the color changes to a valid color
        change: function (event, ui) {
            jQuery(this).css({'backgroundColor': ui.color.toString(), 'color': '#fff'});
        },
        // a callback to fire when the input is emptied or an invalid color
        clear: function () {
            jQuery(this).parent().find('.input-color-bgcontent').css({'backgroundColor': 'transparent', 'color': '#7e7e7e'});
        },
        // hide the color picker controls on load
        hide: true,
        // show a group of common colors beneath the square
        // or, supply an array of colors to customize further
        palettes: true
    };
    //Tao colopickr cho phep chon mau cho background content
    jQuery('.input-color-bgcontent').wpColorPicker(colorPickerContentOptions);

    //Su kien khi thay doi kieu gackground
    jQuery('.bt-type').change(function () {
        var s = jQuery(this).val();
        if (s === 'img') {
            jQuery('.video-background').slideUp(500, function () {
                jQuery('.img-background').slideDown(500);
            });
        }
        if (s === 'video') {
            jQuery('.img-background').slideUp(500, function () {
                jQuery('.video-background').slideDown(500);
            });
        }
    }).trigger('change');

    //Su kin khi thay doi kieu parallax
    jQuery('#parallax_bg_type').change(function () {
        var value = jQuery(this).val();
        if (value === 'static') {
            jQuery('.tabs .dynamic-tab').addClass('hidden');
        }
        if (value === 'dynamic') {
            jQuery('.tabs .dynamic-tab').removeClass('hidden');
        }
    }).trigger('change');

    //Su kien khi thay doi kieu kich thuoc width cua parallax: auto | fixed width | full width
    jQuery('#slider_size_width-type').change(function () {
        var value = jQuery(this).val();
        if (value === 'fixed') {
            jQuery('.slider-size-width-size').show();
        } else {
            jQuery('.slider-size-width-size').hide();
        }
    }).trigger('change');

    //parrallax effect content change
    jQuery('#content_settings_effect_in, #content_settings_effect_out, #item_source_effect_settings_effect_in, #item_source_effect_settings_effect_out').change(function () {
        var itemtarget = jQuery(this);
        var effect_in, effect_out, type;
        //CHuan bi du lieu khi effect ap dung cho noi dung
        if (itemtarget.attr('id') === 'content_settings_effect_in' || itemtarget.attr('id') === 'content_settings_effect_out') {
            effect_in = jQuery('#content_settings_effect_in').val();
            effect_out = jQuery('#content_settings_effect_out').val();
            type = 'content';
        }
        //CHuan bi du lieu khi effect ap dung cho content
        if (itemtarget.attr('id') === 'item_source_effect_settings_effect_in' || itemtarget.attr('id') === 'item_source_effect_settings_effect_out') {
            effect_in = jQuery('#item_source_effect_settings_effect_in').val();
            effect_out = jQuery('#item_source_effect_settings_effect_out').val();
            type = 'item';
        }
        //Xu ly ajax load css effect tuong ung voi tung kieu
        jQuery.ajax({
            url: btAdvParallaxBackgroundCfg.ajaxUrl,
            data: {action: 'loadContentEffectCssAjax', effect_in: effect_in, effect_out: effect_out, type: type},
            type: "post",
            beforeSend: function () {
            },
            success: function (data) {
                var a = jQuery.parseJSON(data);
                if (a.success) {
                    if (type === 'content') {
                        jQuery('#content_settings_custom_effect_code').val('').fadeOut(100, function () {
                            jQuery(this).val(a.data).fadeIn(100);
                        });
                    }
                    if (type === 'item') {
                        jQuery('#content_settings_effect_settings_custom_effect_code').val('').fadeOut(100, function () {
                            jQuery(this).val(a.data).fadeIn(100);
                        });
                    }
                } else {
                }
            }
        });
    });

    //Su kien khi thay doi noi dung text cua input opacity
    jQuery('.change-opacity-text').on('input', function () {
        var val = parseInt(jQuery(this).val());
        if (val) {
            if (val > 100) {
                val = 100;
            }
            if (val < 0) {
                val = 0;
            }
            jQuery(this).val(val);
            jQuery(this).parent().find('.change-opacity').val(val / 100);
            jQuery(this).parent().parent().find('.inner-image .pattern').css('opacity', val / 100);
        } else {
            jQuery(this).parent().find('.change-opacity').val(0);
            jQuery(this).parent().parent().find('.inner-image .pattern').css('opacity', 0);
            jQuery(this).val(0);
        }
    }).trigger('input');

//set background for patten
//Chuan bi du lieu cho danh sach patten (textured)
    for (var i = 0; i <= 13; i++) {
        if (i === 0) {
            jQuery('.list-textured .pattern-' + i).css('backgroundImage', 'none');
        } else {
            jQuery('.list-textured .pattern-' + i).css('backgroundImage', 'url(' + btAdvParallaxBackgroundCfg.baseUrl + '/wp-content/plugins/ap_background/assets/images/pattern-' + i + '.png)');
        }
    }

    //get video background cho parallax
    jQuery('.create-slideshow .get-video-bg').click(function () {
        var target = jQuery(this);
        var videoUrl = target.parents('.bg-type-list-wrap').find('input[name="video_url"]').val();
        jQuery.ajax({
            url: btAdvParallaxBackgroundCfg.ajaxUrl,
            data: {action: 'getVideobackground', url: videoUrl},
            type: "post",
            beforeSend: function () {
                jQuery('.bt-ajax-loading.load-bgimage-ajax').show();
                target.parents('.bt-parallax-select-bg-type').fadeOut(500, function () {
                    jQuery(this).addClass('hidden');
                });
            },
            success: function (data) {
                var a = jQuery.parseJSON(data);
                if (a.success) {
                    jQuery('.video-background .select-image .background_video').val(a.data);
                    var b = jQuery.parseJSON(a.data);
                    if (b.large !== '') {
                        jQuery('.video-background .select-image .inner-image').html('<img src="' + b.large + '" alt=""/>');
                        jQuery('.video-background .opacity .inner-image .image').html('<img src="' + b.large + '" alt=""/>');
                    } else {
                        jQuery('.video-background .select-image .inner-image').html('<div class="video-file"><span><i  class="fa fa-file-video-o fa-3x"></i></span></div>');
                        jQuery('.video-background .opacity .inner-image .image').html('<div class="video-file"><span><i  class="fa fa-file-video-o fa-3x"></i></span></div>');
                    }
                } else {
                    alert(a.message);
                }
                jQuery('.bt-ajax-loading.load-bgimage-ajax').hide();
            }
        });
    });

//Select all/ unselect all item in list parallax slider
    jQuery('#cb-select-all-1').click(function () {
        if (jQuery(this).is(':checked')) {
            jQuery('input[name="fields[]"]').prop("checked", true);
        } else {
            jQuery('input[name="fields[]"]').prop("checked", false);
        }
    });

    //Get image from wp library
    jQuery('.image .from-media').click(function () {
        // Set options
        var options = {
            state: 'insert',
            frame: 'post',
            multiple: true,
            library: {
                type: 'image'
            }
        };

        frame = wp.media(options).open();

        // Tweak views
        frame.menu.get('view').unset('gallery');
        frame.menu.get('view').unset('featured-image');

        frame.toolbar.get('view').set({
            insert: {
                style: 'primary',
                text: 'Insert',
                click: function () {
                    var models = frame.state().get('selection');
                    models.each(function (e) {
                        var url = e.attributes.url;
                        var data = '{"large":"' + url + '","thumbnail":"' + url + '","media_source":"image_upload"}';
                        var item_control = '<div class="media-item">';
                        item_control += '<div class="item-control">';
                        item_control += '<div class="inner-control">';
                        item_control += '<span class="delete"><i  class="fa fa-times"></i></span>';
                        item_control += '<span class="edit"><i  class="fa fa-pencil"></i></span>';
                        item_control += '<span class="select"><i  class="fa fa-check"></i></span>';
                        item_control += '</div>';
                        item_control += '</div>';
                        item_control += '<img src="' + url + '" width="130" alt=""/>';
                        item_control += '<input type="hidden" value=\'' + data + '\' name="settings[media_source][items][]"/>';
                        item_control += '</div>';
                        jQuery('.image .list-items').append(item_control);
                    });

                    frame.close();
                }
            } // end insert
        });
    });

    //Get video tu wp library
    jQuery('#videos .from-media').click(function () {
        // Set options
        var options = {
            state: 'insert',
            frame: 'post',
            multiple: true,
            library: {
                type: 'video'
            }
        };

        frame = wp.media(options).open();

        // Tweak views
        frame.menu.get('view').unset('gallery');
        frame.menu.get('view').unset('featured-image');

        frame.toolbar.get('view').set({
            insert: {
                style: 'primary',
                text: 'Insert',
                click: function () {
                    var models = frame.state().get('selection');
                    models.each(function (e) {
                        var url = e.attributes.url;
                        var data = '{"large":"","thumbnail":"", "video_url":"' + url + '", "media_source":"upload"}';
                        var item_control = '<div class="media-item">';
                        item_control += '<div class="item-control">';
                        item_control += '<div class="inner-control">';
                        item_control += '<span class="delete"><i  class="fa fa-times"></i></span>';
                        item_control += '<span class="edit"><i  class="fa fa-pencil"></i></span>';
                        item_control += '<span class="select"><i  class="fa fa-check"></i></span>';
                        item_control += '</div>';
                        item_control += '</div>';
                        item_control += '<div class="thumb-img"><span><i class="fa fa-file-video-o fa-3x"></i></span></div>';
                        item_control += '<input type="hidden" value=\'' + data + '\' name="settings[media_source][items][]"/>';
                        item_control += '</div>';
                        jQuery('#videos .list-items').append(item_control);
                    });

                    frame.close();
                }
            } // end insert
        });
    });


    //Delete select item in list
    jQuery('.control-buttons span.delete-selected').click(function () {
        jQuery('.list-items .select.selected').parents('.media-item').fadeOut(200, function () {
            jQuery(this).remove();
        });
    });
    //Delete all item in list
    jQuery('.control-buttons span.delete-all').click(function () {
        jQuery('.list-items .media-item').fadeOut(200, function () {
            jQuery(this).remove();
        });
    });

    //Code xu ly khi flickr api field dc nhap
    jQuery('#media_source_flickr_api').on('input', function () {
        jQuery('#ap_background_flickr_api').val(jQuery(this).val());
    });
    jQuery('#media_source_google_api').on('input', function () {
        jQuery('#ap_background_google_api').val(jQuery(this).val());
    });


    //Lay ve media item
    jQuery('.bg-type-list-wrap .get-video').click(function () {
        //Get thong tin cua element dang duoc active de kiem tra xem dang dc lay item tu nguon du lieu nao
        var e = jQuery(this).parents('.bg-type-list-wrap').find('.active');
        //Lay du lieu tu flickr
        if (jQuery(e).hasClass('flickr')) {
            var api = jQuery('#media_source_flickr_api').val();
            var username = jQuery(e).find('input[name="flickr_uname"]').val();
            var albumid = jQuery(e).find('select[name="flickr_album"]').val();
            if (username === '') {
                alert('Please input Flickr username');
            } else if (api === '') {
                alert('Please input Flickr API');
            } else if (api === '') {
                alert('Please select Flickr Album');
            } else {
                getImages('flickr', username, albumid, api);
            }
        }
        //Facebook
        if (jQuery(e).hasClass('facebook')) {
            var username = jQuery(e).find('input[name="facebook_uname"]').val();
            var albumid = jQuery(e).find('select[name="facebook_album"]').val();
            if (username === '') {
                alert('Please input facebook page');
            } else if (albumid === '') {
                alert('Please select album to get image');
            } else {
                getImages('facebook', username, albumid, '');
            }
        }
        //Picasa
        if (jQuery(e).hasClass('picasa')) {
            var albumid = jQuery(e).find('select[name="picasa_album"]').val();
            var username = jQuery(e).find('input[name="picasa_uname"]').val();
            if (username === '') {
                alert('Please input google username');
            } else if (albumid === '') {
                alert('Please select album to get image');
            } else {
                getImages('picasa', username, albumid, '');
            }
        }
        //Youtube
        if (jQuery(e).hasClass('youtube')) {
            var api = jQuery('#media_source_google_api').val();
            var url = jQuery(e).find('input[name="youtube_url"]').val();
            if (url === '') {
                alert('Please input youtube url');
            } else {
                getVideoFromUrl('youtube', url, api);
            }
        }
        //Vimeo
        if (jQuery(e).hasClass('vimeo')) {
            var url = jQuery(e).find('input[name="vimeo_url"]').val();
            if (url === '') {
                alert('Please input vimeo url');
            } else {
                getVideoFromUrl('vimeo', url, '');
            }
        }
        //Embed code
        if (jQuery(e).hasClass('embedcode')) {
            var embcode = jQuery(e).find('textarea[name="video_embedcode"]').val();
            if (embcode === '') {
                alert('Please input embed code');
            } else {
                var data = '{"large":"","thumbnail":"", "video_url":"' + escape(embcode) + '", "media_source":"embedcode"}';
                var item_control = '<div class="media-item">';
                item_control += '<div class="item-control">';
                item_control += '<div class="inner-control">';
                item_control += '<span class="delete"><i  class="fa fa-times"></i></span>';
                item_control += '<span class="edit"><i  class="fa fa-pencil"></i></span>';
                item_control += '<span class="select"><i  class="fa fa-check"></i></span>';
                item_control += '</div>';
                item_control += '</div>';
                item_control += '<div class="thumb-img"><span><i class="fa fa-file-video-o fa-3x"></i></span></div>';
                item_control += '<input type="hidden" value=\'' + data + '\' name="settings[media_source][items][]"/>';
                item_control += '</div>';
                jQuery('#videos .list-items').append(item_control);
                jQuery('.bt-parallax-get-media-item').fadeOut(500, function () {
                    jQuery(this).addClass('hidden');
                    jQuery(this).find('.get-from-wrap').hide().removeClass('active');
                });
            }
        }
    });

    //Lay ve danh sach album anh tu flickr
    jQuery("#flickr_uname").change(function () {
        var uname = jQuery(this).val();
        var flickr_api = jQuery('#media_source_flickr_api').val();
        if (flickr_api === '') {
            //alert('Please input flickr api');
        } else {
            getImageAlbums('flickr', uname, flickr_api);
        }
    }).trigger('change');

    //Lay ve danh sach album anh tu picasa
    jQuery("#picasa_uname").change(function () {
        var uname = jQuery(this).val();
        getImageAlbums('picasa', uname, '');
    }).trigger('change');

    //Lay ve danh sach album anh tu facebook
    jQuery("#facebook_uname").change(function () {
        var fname = jQuery(this).val();
        if (fname === '') {
            //alert('Please input facebook username');
        } else {
            getImageAlbums('facebook', fname, '');
        }
    }).trigger('change');

    //Xoa 1 item tu danh sach
    jQuery('.row-action .delete').live('click', function () {
        //Xac nhan hanh dong xoa cua nguoi dung
        var confirm = window.confirm('You are sure delete it?');
        if (confirm) {//Neu xac nhan laf xoa thi thuc hien xoa item khoi danh sach va xoa khoi database
            var target = jQuery(this);
            var e = target.parents('.item');
            var id = e.find('.row-id').text();
            jQuery.ajax({
                url: btAdvParallaxBackgroundCfg.ajaxUrl,
                data: {action: 'listDeleteSingleItem', id: id},
                type: "post",
                beforeSend: function () {
                    target.parent().find('.bt-ajax-loading.list-item-ajax').show();
                },
                success: function (data) {
                    var a = jQuery.parseJSON(data);
                    if (a.success) {
                        e.remove();
                    } else {
                        alert(a.message);
                    }
                    target.parent().find('.bt-ajax-loading.list-item-ajax').hide();
                }
            });
        }
    });


    //Preview item tu danh sach
    jQuery('.row-action .preview').live('click', function () {
//        Xu ly khi nut bam preview parallax dc click
        var previewWrap = jQuery('#btp-item-preview');
        if (previewWrap.hasClass('hidden')) {
            previewWrap.appendTo('body').fadeIn(500, function () {
                jQuery(this).removeClass('hidden');
            });
        }
        jQuery('body').addClass('no-scroll-adm');
        jQuery('html').addClass('no-scroll-adm');
        var target = jQuery(this);
        var e = target.parents('.item');
        var id = e.find('.row-id').text();
        jQuery.ajax({
            url: btAdvParallaxBackgroundCfg.ajaxUrl,
            data: {action: 'parallaxItemPreview', id: id},
            type: "post",
            beforeSend: function () {
                previewWrap.find('.overlay-loading').fadeIn(100);
            },
            success: function (data) {
                var a = jQuery.parseJSON(data);
                if (a.success) {
                    previewWrap.find('.overlay-loading').fadeOut(100);
                    previewWrap.find('.preview-content .preview-content-in').html(a.data);
                    previewWrap.find('.preview-content .parallax-block-wrap-module').css('marginTop', ((jQuery(window).height() - previewWrap.find('.preview-content .parallax-block-wrap-module').height()) / 3) + 'px');
                    previewWrap.find('.preview-content').css({'opacity': 1});
                } else {
                    alert(a.message);
                }
            }
        });
    });

    //Dong preview
    jQuery('.preview-close .button').click(function () {
        var previewWrap = jQuery('#btp-item-preview');
        previewWrap.fadeOut(500, function () {
            previewWrap.addClass('hidden');
            previewWrap.find('.preview-content').css({'opacity': 0});
            previewWrap.find('.preview-content .preview-content-in').html('');
            jQuery('body').removeClass('no-scroll-adm');
            jQuery('html').removeClass('no-scroll-adm');
            jQuery('body').removeClass('no-scroll');
            jQuery('html').removeClass('no-scroll');
        });
    });

    //Copy 1 item tu danh sach
    jQuery('.row-action .copy').live('click', function () {
        var target = jQuery(this);
        var e = target.parents('.item');
        var id = e.find('.row-id').text();
        jQuery.ajax({
            url: btAdvParallaxBackgroundCfg.ajaxUrl,
            data: {action: 'listCopyItem', id: id},
            type: "post",
            beforeSend: function () {
                target.parent().find('.bt-ajax-loading.list-item-ajax').show();
            },
            success: function (data) {
                var a = jQuery.parseJSON(data);
                if (a.success) {
                    jQuery(a.data).insertAfter(e);
                } else {
                    alert(a.message);
                }
                target.parent().find('.bt-ajax-loading.list-item-ajax').hide();
            }
        });
    });

    //Xoa cac parallax slider item duoc chon tu dnah sach
    jQuery('.delete-button span.delete-items-list').click(function () {
        //Lay ve danh sach cac item duoc chon
        var idcheck = jQuery(this).parents('.bt-parallax-wrap').find('input[name="fields[]"]:checked');
        //Kiem tra neu danh sach duoc chon <= 0 thi thong bao
        if (idcheck.length <= 0) {
            alert('Please select item(s) to delete');
            return;
        } else {//Neu danh sach duoc chonj > 0 thi thuc hien xoa cac item da dc chon
            var ajaxLoading = jQuery(this).parents('.control-buttons').find('.bt-ajax-loading');
            var ids = [];
            for (var i = 0; i < idcheck.length; i++) {
                ids[i] = jQuery(idcheck[i]).val();
            }

            jQuery.ajax({
                url: btAdvParallaxBackgroundCfg.ajaxUrl,
                data: {action: 'listDeleteSelectedItem', ids: ids},
                type: "post",
                beforeSend: function () {
                    ajaxLoading.show();
                },
                success: function (data) {
                    var a = jQuery.parseJSON(data);
                    if (a.success) {
                        idcheck.parents('.item').remove();
                    } else {
                        idcheck.parents('.item').remove();
                    }
                    ajaxLoading.hide();
                }
            });
        }
    });

    //Ham lay ve danh sach album
    function getImageAlbums(source, username, api) {
        jQuery.ajax({
            url: btAdvParallaxBackgroundCfg.ajaxUrl,
            data: {action: 'getImageAlbums', source: source, username: username, api: api},
            type: "post",
            beforeSend: function () {
                jQuery('.' + source + ' .bt-ajax-loading.load-album-item-ajax').show();
            },
            success: function (data) {
                var a = jQuery.parseJSON(data);
                if (a.success) {
                    jQuery("#" + source + "_album").html(a.data);
                } else {
                    alert(a.message);
                }
                jQuery('.' + source + ' .bt-ajax-loading.load-album-item-ajax').hide();
            }
        });
    }

    //Ham lay ve danh sach image
    function getImages(source, username, albumid, api) {
        jQuery.ajax({
            url: btAdvParallaxBackgroundCfg.ajaxUrl,
            data: {action: 'getImages', source: source, username: username, albumid: albumid, api: api},
            type: "post",
            beforeSend: function () {
                jQuery('.image .bt-ajax-loading.add-item-ajax').show();
                jQuery('.bt-parallax-get-media-item').fadeOut(500, function () {
                    jQuery(this).addClass('hidden');
                    jQuery(this).find('.get-from-wrap').hide().removeClass('active');
                });
            },
            success: function (data) {
                var a = jQuery.parseJSON(data);
                if (a.success) {
                    parallaxGetItem(source, a.data, 0, a.data.length - 1, false);
                } else {
                    alert(a.message);
                }
                jQuery('.image .bt-ajax-loading.add-item-ajax').hide();
            }
        });
    }

    //Ham lay video tu url
    function getVideoFromUrl(source, url, api) {
        jQuery.ajax({
            url: btAdvParallaxBackgroundCfg.ajaxUrl,
            data: {action: 'getVideoFromUrl', source: source, url: url, api:api},
            type: "post",
            beforeSend: function () {
                jQuery('.video .bt-ajax-loading.add-item-ajax').show();
                jQuery('.bt-parallax-get-media-item').fadeOut(500, function () {
                    jQuery(this).addClass('hidden');
                    jQuery(this).find('.get-from-wrap').hide().removeClass('active');
                });
            },
            success: function (data) {
                var a = jQuery.parseJSON(data);
                if (a.success) {
                    parallaxGetItem(source, a.data, 0, a.data.length - 1, false);
                } else {
                    alert(a.message);
                }
                jQuery('.video .bt-ajax-loading.add-item-ajax').hide();
            }
        });
    }

    //Ham lay ve item cho dnah sach,
    function parallaxGetItem(source, data, from, to, complete) {
        var dataPost = '';
        if (source === 'picasa' || source === 'flickr' || source === 'facebook') {
            dataPost = {action: 'getImage', source: source, imageid: data[from]};
        }
        if (source === 'youtube' || source === 'vimeo') {
            dataPost = {action: 'getVideo', source: source, videoid: data[from]};
            if(source == 'youtube'){
                var api = jQuery('#media_source_google_api').val();
                dataPost.api = api;
            }
        }
        if (complete) {
            if (source === 'picasa' || source === 'flickr' || source === 'facebook') {
                jQuery('.image .bt-ajax-loading.add-item-ajax').hide();
            }
            if (source === 'youtube' || source === 'vimeo') {
                jQuery('.video .bt-ajax-loading.add-item-ajax').hide();
            }
        } else {
            jQuery.ajax({
                url: btAdvParallaxBackgroundCfg.ajaxUrl,
                data: dataPost,
                type: "post",
                beforeSend: function () {
                    if (source === 'picasa' || source === 'flickr' || source === 'facebook') {
                        jQuery('.image .bt-ajax-loading.add-item-ajax').show();
                    }
                    if (source === 'youtube' || source === 'vimeo') {
                        jQuery('.video .bt-ajax-loading.add-item-ajax').show();
                    }
                },
                success: function (response) {
                    var a = jQuery.parseJSON(response);
                    if (a.success) {
                        if (source === 'picasa' || source === 'flickr' || source === 'facebook') {
                            jQuery('.image .list-items').append(a.data);
                        }
                        if (source === 'youtube' || source === 'vimeo') {
                            jQuery('#videos .list-items').append(a.data);
                        }
                    }
                    from++;
                    if (from <= to) {
                        parallaxGetItem(source, data, from, to, false);
                    } else {
                        parallaxGetItem(source, data, from, to, true);
                    }
                }
            });
        }
    }

    //Ham set lai kich thuoc cua anh background view
    function fixImagebackgroundView() {
        var bgviewimg = jQuery('.image-preview .inner-image');
        if (bgviewimg.width() / bgviewimg.height() > bgviewimg.find('img').width() / bgviewimg.find('img').height()) {
            bgviewimg.find('img').css({'width': '100%'});
        } else {
            bgviewimg.find('img').css({'height': '100%'});
        }
    }
});


