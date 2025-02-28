/**
 * jQuery parallax process action for parallax block
 *
 * @author Inwavethemes
 * @package AP Background
 * @version 1.0.0
 */
(function ($) {
    "use strict";
    $.fn.btParallax = function (options) {
        $(this).each(function () {
            var adv = $(this);
            this.winHeight = $(window).height();
            this.winWidth = $(window).width();
            this.paraWrap = adv.parent();
            this.paraWrapHeight = this.paraWrap.height();
            this.paraWrapWidth = this.paraWrap.width();
            this.paraHeight = adv.height();
            this.paraWidth = adv.width();
            this.ePos;
            this.eSize;
            this.cposWidth;
            this.isThumClick = false;
            this.isNavClick = true;
            this.isFullContent = false;
            this.isParallaxOpen = false;
            this.enableControlButton = false;
            this.hasScroll = false;
            this.eTopCurrent = adv.offset().top - $(window).scrollTop();
            this.eTopCenter = ((this.winHeight - this.paraHeight) / 2);
            this.eLeftCurrent = adv.offset().left;
            this.backPosX;
            this.s;
            this.colwidth = options.item_width + options.spacing;
            this.timer = null;
            this.nextTimer = null;
            this.background = adv.find('.parallax-background');
            this.backgroundImg = adv.find('.parallax-background img');
            this.backgroundVideo = adv.find('.parallax-background video');
            this.bPosition = {top: '', left: ''};
            this.cPos = adv.find('.parallax-content-in');
            this.count = 0;
            this.aplist = new Array();
            this.colItemShow = Math.ceil(this.winWidth / (this.colwidth));
            this.colLeft;
            this.rowList;
            this.imageList;
            this.listAnimate = false;
            this.backCssCurent;
            this.backCssCenter;
            this.backCssTop;
            this.blockCssCurent;
            this.blockCssCenter;
            this.blockCssTop;
            this.post_wrap_width;
            var btParallax = this;
            //initical js for module.
            //Ham thiet lap va khoi tao cac trang thai ban dau cho khoi parallax
            this.renderParallax = function () {
//                Thiet lap kich thuoc cho noi dung phia ngoai cua khoi parallax khi slide size la full width
                if (options.slideSize.type === 'full') {
                    //adv.find('.parallax-block-content').css({'width': btParallax.paraWrap.parent().width(), 'padding': '0 '+btParallax.paraWrap.parent().offset().left});
                }
                //An nut bam open parallax khi kieu parallax la static
                if (options.parallaxType === 'static') {
                    adv.find('.open-btn').removeClass('open-btn').addClass('hidden');
                }

                //Thiet lap trang thai ban dau cho khoi parallax va background
                btParallax.showHideParallax();
                btParallax.backgroundUpdate(btParallax.isFullContent);

                //Xu ly khi nut bam open parallax duoc click
                adv.find('.open-btn').click(function () {
                    btParallax.isParallaxOpen = true;
                    btParallax.openParallaxContent(this);
                    return false;
                });

                //Xu ly khi nut bam close parallax duoc click
                adv.find('.close-btn').click(function () {
                    btParallax.isParallaxOpen = false;
                    btParallax.closeButtonClick(this);
                });

                //Xu ly khi nut bam next parallax duoc click
                adv.find('.nav-next').click(function () {
                    btParallax.navNextClick(this);
                });

                //Xu ly khi nut bam prev parallax duoc click
                adv.find('.nav-prev').click(function () {
                    btParallax.navPrevClick(this);
                });

                //Xu ly khi anh thumbnail cua list image duoc click
                adv.find('.thumb').live('click', function (e) {
                    btParallax.imgThumbClick(e, this);
                });

                //Xu ly khi window resize
                var resizeTimeout = '';
                $(window).resize(function () {
                    clearTimeout(resizeTimeout);
                    resizeTimeout = setTimeout(function () {
                        btParallax.apResponsive();
                    }, 200);
                });
            };
            //Ham xu ly khi nut bam open tren parallax duoc click de full noi dung
            this.openParallaxContent = function (e) {
                adv.css('z-index', '999999');
                //Hieu ung de an noi dung phia truoc cua khoi pqrallax
                adv.find('.parallax-block-content h1').addClass('out-pos').removeClass('default-pos');
                adv.find('.parallax-block-content img').addClass('out-pos').removeClass('default-pos');
                adv.find('.parallax-block-content p').addClass('out-pos').removeClass('default-pos');
                adv.find('.parallax-block-content').addClass('out-pos').removeClass('default-pos');

                //Dua noi dung cua khoi parallax ve vi tri chuan bi cho viec hien thi
                setTimeout(function () {
                    adv.find('.parallax-block-content h1').removeClass('out-pos').addClass('in-pos');
                    adv.find('.parallax-block-content img').removeClass('out-pos').addClass('in-pos');
                    adv.find('.parallax-block-content p').removeClass('out-pos').addClass('in-pos');
                    adv.find('.parallax-block-content').removeClass('out-pos').addClass('in-pos');
                }, 5000);

                //Remove window scroll
                $('body').addClass('no-scroll');
                $('html').addClass('no-scroll');

                //Thiet lap gia tri cho cac bien.
                btParallax.bPosition.top = this.background.position().top;
                btParallax.bPosition.left = this.background.position().left;
                btParallax.backCssCurent = {'top': btParallax.bPosition.top, 'left': btParallax.bPosition.left};
                btParallax.backCssCenter = {top: '50%', transform: 'translateY(-50%)'};
                btParallax.backCssTop = {top: '0px'};
                btParallax.blockCssTop = {'top': 0, 'height': '100%'};
                btParallax.apUpdate();

                //Tinh thoi gian chay hieu ung di chuyen cua khoi parallax
                var espeed = btParallax.s * options.speed;
                if (espeed < 500) {
                    espeed = 500;
                }

                //Animate cho background, cung time voi khoi parallax de tranh giat
                btParallax.background.animate({'top': '0px'}, espeed);

                //Dat css ban dau cho khoi parallax vaf effect cho khoi di chuyen ve vi tri giua man hinh
                adv.css(btParallax.blockCssCurent).animate(btParallax.blockCssCenter, espeed, function () {
                    setTimeout(function () {
                        //Animate khoi parallax full height
                        adv.animate(btParallax.blockCssTop, 1000, 'easeInOutQuint', function () {
                            //Kiem tra xem trang thai cua khoi parallax co phai full width khong
                            if (options.slideSize.type === 'full') {//Neu la full width thi bo qua buoc full width va thuc hien load content cua parallax
                                //Function load content for parallax
                                btParallax.openParallaxContentLoad();
                            } else {//Neu khong phai full width thi thuc hien full width khoi parallax
                                setTimeout(function () {
                                    //Animate full width cho khoi parallax
                                    adv.animate({'left': 0, 'width': '100%'}, 1000, 'easeInOutQuint', function () {
                                        //Function load content for parallax
                                        btParallax.openParallaxContentLoad();
                                    });
                                }, 200);
                            }
                        });
                    }, 200);
                });
            };

            //Ham load noi dung cho parallax sau khi full man hinh
            this.openParallaxContentLoad = function () {
                //chuan bij du lieu cho viec get content (alias cua parallax)
                var itemdata = adv.find('input[name="item-alias"]').val();

                //Ajax to get content of parallax
                jQuery.ajax({
                    url: btAdvParallaxBackgroundCfg.ajaxUrl,
                    data: {action: 'loadParallaxFrameContent', item: itemdata},
                    type: "post",
                    beforeSend: function () {
                        //Show ajax loading image
                        adv.find('.overlay-loading').show();
                    },
                    success: function (data) {
                        //CHange content background
                        if (options.backgroundColor !== '') {
                            adv.find('.parallax-content-wrap').css('background', options.backgroundColor);
                        }
                        var a = jQuery.parseJSON(data);
                        //Kiem tra xem noi dung cua parallax load duoc hay khong
                        if (a.success) {//Xu ly du lieu khi load thanh cong.
                            //Thuc hienj append data vao node chua noi dung
                            btParallax.cPos.append(a.data);
                            //Thuc hien xu ly du lieu doi voi tung kieu noi dung tuong ung
                            //Truong hop chung cho image va post content
                            if (options.contentType === 'image' || options.contentType === 'postContent') {
                                //gan lai gia tri cho bien aplist
                                btParallax.aplist = adv.find('.parallax-col');
                                //Xu ly du lieu voi kieu noi dung la anh va layout la flexible
                                //thuc hien clone so item len neu so luong item cua noi dung khong du de hien thi
                                if (options.contentType === 'image' && options.layout === 'flexible' && btParallax.aplist.length <= 3) {
                                    if (btParallax.aplist.length === 1) {//Neu noi dung chi co 1 cot thi thuc hien clone lien tiep 2 lan
                                        $(btParallax.aplist[0]).clone().appendTo(btParallax.cPos.find('.flexible')).clone().appendTo(btParallax.cPos.find('.flexible'));
                                    } else {//Neu noi dung co so cot lon hon 1 va <=3 thi se clole gap doi so phan tu len
                                        btParallax.aplist.each(function () {
                                            $(this).clone().appendTo(btParallax.cPos.find('.flexible'));
                                        });
                                    }
                                    //Gan lai gia tri cho bien aplist sau khi da clone
                                    btParallax.aplist = adv.find('.parallax-col');
                                }

                                //Gan gia tri cho bien kich thuoc cua khoi parallax
                                btParallax.cposWidth = (btParallax.colwidth) * btParallax.aplist.length;

                                //Xu ly du lieu voi kieu noi dung la image va layout laf default
                                if (options.contentType === 'image' && options.layout === 'default' && (btParallax.winWidth < btParallax.cposWidth <= btParallax.winWidth + btParallax.colwidth)) {
                                    //Thuc hien clone so item len khi so luong item khong du de hien thi tren man hinh
                                    btParallax.aplist.each(function () {
                                        $(this).clone().addClass('clone-col').appendTo(btParallax.cPos.find('.default'));
                                    });
                                    //Gan lai bien aplist sau khi da clone
                                    btParallax.aplist = adv.find('.parallax-col');
                                }

                                //Gan gia tri cho bien danh sach cac rowitem
                                btParallax.rowList = adv.find('.parallax-row');

                                //Gan lai gia tri cho bien kich thuoc cua khoi parallax sau khi da clone
                                btParallax.cposWidth = (btParallax.colwidth) * btParallax.aplist.length;
                                //Gan gia tri cho bien image list (danh dach hinh anh)
                                btParallax.imageList = btParallax.cPos.find('.show_box');

                                //Set kich thuoc cho tung item doi voi kieu noi dung hinh anh
                                btParallax.aplist.each(function (index) {
                                    if (options.contentType === 'image' && options.layout === 'default') {
                                        $(this).find('.parallax-row').css({'height': options.item_height});
                                    }
                                    $(this).css({'width': options.item_width + 'px', 'margin-right': options.spacing});
                                });

                                //Dat kich thuoc cho khoi parallax
                                if (btParallax.aplist.length > 0) {
                                    btParallax.cPos.width(btParallax.cposWidth);
                                } else {
                                    btParallax.cPos.css('width', '100%');
                                }
                            }

                            //Xu ly du lieu voi kieu image
                            if (options.contentType === 'image') {
                                //Set kich thuoc chieu cao cho th chua khoi noi dung parallax
                                if (options.autoResizeGallery === '1') {
                                    btParallax.galleryAutoResize();
                                } else {
                                    btParallax.cPos.css('height', ((options.item_height + options.spacing) * options.rows - options.spacing + 40) + 'px');
                                }
                                //Kiem tra va can giua man hinh neu so luong hinh anh it du de hien thi tren man hinh window
                                if (btParallax.cposWidth < btParallax.winWidth) {
                                    btParallax.cPos.parent().css('left', (btParallax.winWidth - btParallax.cposWidth) / 2 + 'px');
                                }

                                //Set lai mau nen cho anh large preview
                                if (options.backgroundColor !== '') {
                                    adv.find('.content-show-large').css('background', options.backgroundColor);
                                }

                                //Kiem tra neu scroll direction la ltr thi set left cua cpos la max
                                if (options.scroll_direction === 'ltr') {
                                    btParallax.cPos.css({'left': '-' + (btParallax.cposWidth - btParallax.winWidth) + 'px'});
                                }
                                //Cap nhat lai style cho khoi image list
                                btParallax.apImageUpdateStyle();
                            }

                            //Xu ly du lieu voi kieu noi dung la video
                            if (options.contentType === 'video') {
                                //Gan laij gia tri cho bien aplist
                                btParallax.aplist = adv.find('.video-contain');

//                                Thiet dat css cho video content
                                adv.find('.parallax-content-wrap').css({'overflow': 'hidden'});
                                adv.find('.content-show-large').css({'backgroundColor': '#000000'});
                            }

                            //Thuc hien effect hien thi noi dung cua khoi parallax
                            adv.find('.parallax-content-wrap').fadeIn(500, function () {
                                adv.find('.overlay-loading').hide();
                                //gan giatri cho bien co trang thai cua khoi parallax.
                                btParallax.isFullContent = true;
                                //Khai bao kien index cua item de thuc hien effect load item
                                var index = 0;
                                if (options.scroll_direction === 'ltr') {
                                    //Dat lai gia tri cho bien itemIndex = item cuoi cung
                                    index = btParallax.rowList.length;
                                }
                                //Xu ly du lieu voi tung kieu  noi dung
                                //Voi kieu noi dung la image
                                if (options.contentType === 'image') {
                                    adv.find('.parallax-content').removeClass('hidden').addClass('image-gallery');
                                    //Thuc hien load danh sach image kem effect hien thi
                                    btParallax.loadImageItems(true, index, function () {
                                        btParallax.isThumClick = true;
                                        adv.find('.control-button .button-wrap').fadeIn(1000);
                                        if (btParallax.cposWidth > btParallax.winWidth) {
                                            btParallax.aplistAnimate = true;
                                            //Bat cho phep hien thi control button (nav)
                                            btParallax.enableControlButton = true;
                                            btParallax.showNav(true);
                                            //Thuc hien chay animate cho danh sach image
                                            btParallax.animateStart();
                                        }
                                    });
                                }

                                //Voi kieu noi dung la video
                                //Xu ly hien thi va cac thiet dat cho video
                                if (options.contentType === 'video') {
                                    adv.find('.parallax-content').removeClass('hidden').addClass('video-list');
                                    var videoshow = adv.find('.video-contain.show');
                                    adv.find('.content-show-large .item-contain').html($(videoshow.val()));
                                    adv.find('.content-show-large .item-contain .video-inner').show();
                                    adv.find('.content-show-large').removeClass('hidden').fadeIn(300);
                                    adv.find('.content-show-large .loading').css({'position': 'absolute', 'top': '50%', 'left': '50%', 'transform': 'translate(-50%, -50%)'}).fadeIn(300);
                                    adv.find('.control-button .button-wrap').fadeIn(1000);
                                    if (btParallax.aplist.length > 1) {
                                        //Bat cho phep hien thi control button (nav)
                                        btParallax.enableControlButton = true;
                                        btParallax.showNav(true);
                                        adv.find('.nav-prev').addClass('prev-video');
                                        adv.find('.nav-next').addClass('next-video');
                                    }
                                }

                                //Voi kieu noi dung la content
                                if (options.contentType === 'postContent') {
                                    adv.find('.parallax-content').removeClass('hidden').addClass('post-content');
                                    //Cap nhat style cho kieu noi dung content
                                    btParallax.apContentUpdateStyle();
                                    btParallax.loadImageItems(true, index, function () {
                                        adv.find('.control-button .button-wrap').fadeIn(1000);
                                        if (btParallax.cposWidth > btParallax.winWidth) {
                                            //Bat cho phep hien thi control button (nav)
                                            btParallax.enableControlButton = true;
                                            btParallax.showNav(true);
                                            adv.find('.nav-prev').addClass('prev-post');
                                            adv.find('.nav-next').addClass('next-post');
                                        }
                                    });
                                }
                            });
                        } else {//neu khong load duoc loi dung thi bat thong bao loi
                            alert(a.message);
                        }
                    }
                });
            };
            //Ham xu ly khi nut close duoc click de dong full noi dung
            this.closeButtonClick = function (e) {
                //Xu ly nut bam close thuc hien nhiem vu dong image preview (xem anh o kich thuoc lon)
                if ($(e).hasClass('close-image-info')) {
                    adv.find('.parallax-content-wrap').css('overflow-y', 'auto');
                    adv.find('.nav-prev').removeClass('prev-large');
                    adv.find('.nav-next').removeClass('next-large');
                    //Kiem tra neu hien tai trinh duyen dang co scroll thi khi dong preview se them class has-scroll de dich chuyen nut bam close vaf next vao trong 1 khoang
                    if (btParallax.hasScroll) {
                        adv.find('.button-wrap .close-btn').addClass('has-scroll');
                        adv.find('.nav-wrap-in.next').addClass('has-scroll');
                    }
                    //Thuc hien animate thu nho the chua image large ve dung vi tri anh thumbnail duoc click, sau do thi hidden
                    adv.find('.content-show-large.show').animate({'top': btParallax.ePos.top, 'left': btParallax.ePos.left, 'width': 0, 'height': 0}, 500, function () {
                        $(this).addClass('hidden').removeClass('show');
                        adv.find('.close-btn').removeClass('close-image-info');
                        adv.find('.content-show-large .item-contain').html('');
                        //Sau khi the duoc han di, thuc hien start animate lai doi voi danh sach image
                        setTimeout(function () {
                            if (btParallax.aplistAnimate) {
                                btParallax.animateStart();
                                btParallax.showNav(true);
                            } else {
                                btParallax.showNav(false);
                            }
                            btParallax.isThumClick = true;
                        }, 100);
                    });
                    return;
                }

                btParallax.enableControlButton = false;
                btParallax.showNav(false);
                //Hide nut bam close
                adv.find('.button-wrap').fadeOut();
                //Cap nhat lai trang thai cua khoi parallax
                btParallax.apUpdate();

                //Thiet lap lai gia tri cua cac bien flag dieu khien
                btParallax.isFullContent = false;
                btParallax.aplistAnimate = false;
                //Stop animate doi voi kieu noi dung la image
                btParallax.animateStop();

                //Xac dinh vi tri hien tai cua khoi noi dung
                btParallax.colLeft = Math.abs(Math.ceil(btParallax.cPos.position().left / btParallax.colwidth));

                //Kiem tra kieu noi dung de thuc hien cac xu ly phu hop
                //Xu ly voi truong hop la anh hoac postcontent thi effect an danh sach item
                if (options.contentType === 'image' || options.contentType === 'postContent') {
                    var index = btParallax.colLeft * options.rows;
                    btParallax.loadImageItems(false, index, function () {//effect an dnah sach item sau do thuc hien effect close khoi parallax
                        btParallax.rowList.addClass('in-pos').removeClass('out-pos');
                        btParallax.closeParallaxContent();
                    });
                } else {
                    //Dong khoi parallax
                    btParallax.closeParallaxContent();
                }
            };

            //Ham dong khoi parallax
            this.closeParallaxContent = function () {
                adv.find('.parallax-content-wrap').fadeOut(500, function () {
                    //Kiem tr kieu parallax full hay khong full
                    if (options.slideSize.type === 'full') {//Neu la full thif chi viec zoom height
                        btParallax.parallaxContentZoomOutHeight();
                    } else {//Neu khong full thi thic hien zoom width
                        btParallax.parallaxContentZoomOutWidth();
                    }
                });
            };
            //Ham thu parallax theo chieu width
            this.parallaxContentZoomOutWidth = function () {
                adv.animate({'left': (btParallax.winWidth - btParallax.paraWrapWidth) / 2, 'width': btParallax.paraWrapWidth},
                500,
                        'easeInOutQuint',
                        btParallax.parallaxContentZoomOutHeight());
            };
            //Ham thu parallax theo chieu height
            this.parallaxContentZoomOutHeight = function () {
                //Dat lai css vi tri cua background (Tranh bi giat trong qua trinh effect)
                adv.find('.parallax-background').css({left: btParallax.backPosX + 'px', top: '0px'});

                //Animate room out khoi parallax ve kich thuoc ban dau
                adv.animate({'top': btParallax.eTopCenter, 'height': btParallax.paraWrapHeight}, 1000, 'easeInOutQuint', function () {
                    setTimeout(function () {
                        var espeed = btParallax.s * options.speed;
                        if (espeed < 500) {
                            espeed = 500;
                        }
                        var eleftC = btParallax.eLeftCurrent;
                        if (options.slideSize.type === 'full') {
                            eleftC = 0;
                        }

                        //Animate background ve vi tri ban dau
                        btParallax.background.animate({'top': btParallax.bPosition.top, 'left': btParallax.bPosition.left}, espeed);
                        //Animate khoi parallax ve vi tri ban dau
                        adv.animate({'top': btParallax.eTopCurrent, 'left': eleftC}, espeed, function () {
                            $('body').removeClass('no-scroll');
                            $('html').removeClass('no-scroll');

                            //Xu ly doi voi trong hop parallax full width
                            if (btParallax.paraWrap.hasClass('full-width')) {
                                //Tinh lai kich thuoc cua window va updat lai css cho khoi parallax
                                btParallax.winWidth = $(window).width();
                                btParallax.paraWidth = adv.width();
                                btParallax.updateParallaxPosition();
                            }

                            //Effect hien thi noi dung text cua khoi parallax
                            adv.find('.parallax-block-content').addClass('default-pos').removeClass('in-pos');
                            adv.find('.parallax-block-content h1').addClass('default-pos').removeClass('in-pos');
                            adv.find('.parallax-block-content img').addClass('default-pos').removeClass('in-pos');
                            adv.find('.parallax-block-content p').addClass('default-pos').removeClass('in-pos');

                            //Xoa bo class cho tung kieu noi dung tuong ung
                            if (options.contentType === 'image') {
                                adv.find('.parallax-content').addClass('hidden').removeClass('image-gallery');
                            }
                            if (options.contentType === 'video') {
                                adv.find('.parallax-content').addClass('hidden').removeClass('video-list');
                            }
                            if (options.contentType === 'postContent') {
                                adv.find('.parallax-content').addClass('hidden').removeClass('post-content');
                            }

                            //reset lai style cua khoi parallax va xoa bo html cua noi dung an
                            adv.attr('style', '');
                            btParallax.cPos.html('').attr('style', '');
                            adv.find('.item-contain').html('');
                        });
                    }, 600);
                });
            };

            //Ham xu ly khi nut next duoc click
            this.navNextClick = function (e) {
                //Kiem tra xem item next thuoc loai nao
                //Truong hop next la image large
                if ($(e).hasClass('next-large')) {
                    //Show ajax loading icon
                    var timeout = setTimeout(function () {
                        adv.find('.content-show-large .loading').fadeIn(100);
                    }, 100);

                    //Lay ve item dang duoc hien thi
                    var ce = adv.find('.show_box.show');
                    var ne;

                    //Kiem tra item hien tai co phai la item cuoi cung hay khong
                    //Neu la item cuoi cung thi khi nhan next item ke tiep se la item dau tien
                    if (btParallax.imageList.index(ce) + 1 >= btParallax.imageList.length) {
                        ne = btParallax.imageList[0];
                    } else {//Neu khong phai la item cuoi cung thi item ke tiep se la item phia ben phai cua item hien tai
                        ne = btParallax.imageList[btParallax.imageList.index(ce) + 1];
                    }

                    //Get html cua item ke tiep va append vao the chua item dang duoc hien thi
                    var n_e = $(ne).html();
                    adv.find('.content-show-large .item-contain').append($(n_e).css('display', 'none'));
                    //Xoa item dau tien trong danh sach (chinh la item dnag duoc hien thi)
                    if (adv.find('.content-show-large .item-contain img').length > 2) {
                        adv.find('.content-show-large .item-contain img:first').remove();
                    }

                    //Load image va kiem tra xem co load dc image hay khong
                    var img = new Image();
                    $(img).load(function () {//Neu load dc image thanh cong thi thuc hien tiep
                        //Effect an item dau tien (curent item) va hien thi item ke tiep
                        adv.find('.content-show-large .item-contain img:first').fadeOut(2000);
                        adv.find('.content-show-large .item-contain img:last').fadeIn(2000, function () {
                            if (adv.find('.content-show-large .item-contain img').length > 2) {
                                adv.find('.content-show-large .item-contain img:first').remove();
                            }
                        });
                        clearTimeout(timeout);
                        adv.find('.content-show-large .loading').fadeOut(100);
                        $(ne).addClass('show');
                        ce.removeClass('show');
                    }).error(function () {//Khong load dc image thi thong bao loi
                        alert('Can\'t load image!');
                    }).attr('src', $(n_e).attr('src'));
                    return;
                } else if ($(e).hasClass('next-video')) {//Truong hop next item kieu video
                    //Hien thi loading image
                    adv.find('.content-show-large .loading').fadeIn(100);
                    //Tim item hien tai dang duoc hien thi
                    var ce = adv.find('.video-contain.show');
                    var ne;
                    //Tim item ke tiep khi nhan nut next
                    if (btParallax.aplist.index(ce) + 1 >= btParallax.aplist.length) {
                        ne = btParallax.aplist[0];
                    } else {
                        ne = btParallax.aplist[btParallax.aplist.index(ce) + 1];
                    }

                    //Lay ve html cua item ke tiep va append vao the chua item dang dc hien thi
                    var n_e = $(ne).val();
                    adv.find('.content-show-large .item-contain').append(n_e);
                    if (adv.find('.content-show-large .item-contain .video-inner').length > 2) {
                        //Xoa item dang duoc hien thi
                        adv.find('.content-show-large .item-contain .video-inner:first').remove();
                    }

                    //Effect an item dau tien (curent item) va hien thi item ke tiep sau do xoa item hien tai di
                    adv.find('.content-show-large .item-contain .video-inner:first').fadeOut(2000);
                    adv.find('.content-show-large .item-contain .video-inner:last').fadeIn(2000, function () {
                        if (adv.find('.content-show-large .item-contain .video-inner').length > 1) {
                            adv.find('.content-show-large .item-contain .video-inner:first').remove();
                        }
                    });
                    $(ne).addClass('show');
                    ce.removeClass('show');
                    return;
                } else if ($(e).hasClass('next-post')) {//Truong hop next item kieu post
                    //Kiem tra xem nut bam next dc phep click hay khong
                    if (btParallax.isNavClick === false) {//Neu laf khong thi return
                        return;
                    }
                    //Neu la co thi gan lai gia tri cua bien kiem tra = false va thuc hien xu ly su kien click
                    btParallax.isNavClick = false;

                    //Get vij tri hien tai cua khoi noi dung parallax
                    var left = Math.abs(btParallax.cPos.position().left);
                    //Kiem tra xem sau khi nhan next thi vitri cua khoi parallax da la diem cuoi cua chua
                    //Neu chua thi thuc hien dich chuyn khoi parallax 1 khoang options.next_prev_s
                    if (left + options.next_prev_s <= btParallax.cPos.width() - adv.find('.parallax-content.post-content').width()) {
                        btParallax.cPos.animate({'left': '-' + (left + options.next_prev_s) + 'px'}, 400, function () {
                            //animate xong gan lai gia tri cua bien dieu khien  true de cho phep dc nhan next tiep
                            btParallax.isNavClick = true;
                        });
                    } else {//Neu da la diem cuoi thi dua khoi parallax ve vi tri ban dau
                        btParallax.cPos.animate({'left': '0px'}, 400, function () {
                            //animate xong gan lai gia tri cua bien dieu khien  true de cho phep dc nhan next tiep
                            btParallax.isNavClick = true;
                        });
                    }
                    return;
                } else {//Truong hop con lai la next danh sach image item
                    //Stop animate (scroll danh sach image)
                    btParallax.animateStop();

                    //Kiem tra xem nut bam next dc phep click hay khong
                    if (btParallax.isNavClick === false) {//Neu laf khong thi return
                        return;
                    }
                    //Neu la co thi gan lai gia tri cua bien kiem tra = false va thuc hien xu ly su kien click
                    btParallax.isNavClick = false;
                    //Tinh vij tri hien tai cua khoi noi dung parallax
                    var left = Math.abs(btParallax.cPos.position().left);

                    //Kiem tra xem sau khi next da la item cuoi cung chua
                    //Neu da la item cuoi cung hoac gan cuoi thi thuc hien dau item dau tien ve item cuoi cung.
                    if (left + options.next_prev_s > btParallax.cPos.width() - $(window).width()) {
                        btParallax.cPos.css('left', (btParallax.cPos.position().left + (btParallax.colwidth)) + 'px');
                        adv.find('.parallax-col:first').appendTo(btParallax.cPos.find('.layout'));
                    }
                    btParallax.cPos.animate({left: (btParallax.cPos.position().left - options.next_prev_s) + 'px'}, 400, function () {
                        btParallax.isNavClick = true;
                        btParallax.animateStart();
                    });
                }
            };

            //Ham xu ly khi nut bam prev duoc click
            this.navPrevClick = function (e) {
                //Kiem tra xem item next thuoc loai nao
                //Truong hop next la image large
                if ($(e).hasClass('prev-large')) {
                    //Hien thi loading image
                    var timeout = setTimeout(function () {
                        adv.find('.content-show-large .loading').fadeIn(100);
                    }, 100);
                    //Lay ve item dang hien thi
                    var ce = adv.find('.show_box.show');
                    var ne;
                    //Lay ve item ke tiep
                    if (btParallax.imageList.index(ce) - 1 <= 0) {
                        ne = btParallax.imageList[btParallax.imageList.length - 1];
                    } else {
                        ne = btParallax.imageList[btParallax.imageList.index(ce) - 1];
                    }
                    //lay ve html cua item ke tiep
                    var n_e = $(ne).html();
                    //append item ke tiep vao danh sach item hien thi va xoa item hien tai di
                    adv.find('.content-show-large .item-contain').append($(n_e).css('display', 'none'));
                    if (adv.find('.content-show-large .item-contain img').length > 2) {
                        adv.find('.content-show-large .item-contain img:first').remove();
                    }

                    //Load va kiem tra hinh anh
                    var img = new Image();
                    $(img).load(function () {//Neu load hinh anh thanh cong
                        adv.find('.content-show-large .item-contain img:first').fadeOut(3000);
                        adv.find('.content-show-large .item-contain img:last').fadeIn(3000, function () {
                            if (adv.find('.content-show-large .item-contain img').length > 2) {
                                adv.find('.content-show-large .item-contain img:first').remove();
                            }
                        });
                        clearTimeout(timeout);
                        adv.find('.content-show-large .loading').fadeOut(100);
                        $(ne).addClass('show');
                        ce.removeClass('show');
                    }).error(function () {//Loa hinh anh that ba thi thong bao loi
                        alert('Can\'t load image!');
                    }).attr('src', $(n_e).attr('src'));
                    return;
                } else if ($(e).hasClass('prev-video')) {//Truong hop video
                    //Hien thi loading image
                    var timeout = setTimeout(function () {
                        adv.find('.content-show-large .loading').fadeIn(100);
                    }, 100);
                    //Lay item hien tai dang hien thi
                    var ce = adv.find('.video-contain.show');
                    //Lay ve item ke tiep
                    var ne;
                    if (btParallax.aplist.index(ce) - 1 < 0) {
                        ne = btParallax.aplist[btParallax.aplist.length - 1];
                    } else {
                        ne = btParallax.aplist[btParallax.aplist.index(ce) - 1];
                    }
                    //Lay gia tri cua item ke tiep va append vao danh sach dc hien thi sau do xoa item dnag hien thi hin tai
                    var n_e = $(ne).val();
                    adv.find('.content-show-large .item-contain').append($(n_e).css({'display': 'none'}));
                    if (adv.find('.content-show-large .item-contain .video-inner').length > 2) {
                        adv.find('.content-show-large .item-contain .video-inner:first').remove();
                    }

                    //Hien thi item ke tiep va an item hien tai
                    adv.find('.content-show-large .item-contain .video-inner:first').fadeOut(2000);
                    adv.find('.content-show-large .item-contain .video-inner:last').fadeIn(2000, function () {
                        if (adv.find('.content-show-large .item-contain .video-inner').length > 1) {
                            adv.find('.content-show-large .item-contain .video-inner:first').remove();
                        }
                    });
                    clearTimeout(timeout);
                    $(ne).addClass('show');
                    ce.removeClass('show');
                    return;
                } else if ($(e).hasClass('prev-post')) {//Truong hop post
                    //Kiem tra xem nut bam next dc phep click hay khong
                    if (btParallax.isNavClick === false) {//Neu laf khong thi return
                        return;
                    }
                    //Neu la co thi gan lai gia tri cua bien kiem tra = false va thuc hien xu ly su kien click
                    btParallax.isNavClick = false;
                    //Tinh vij tri hien tai cua khoi noi dung parallax
                    var left = Math.abs(btParallax.cPos.position().left);
                    //Kiem tra vi tri hien tai cua khoi parallax content
                    //Neu nos = 0 thi dua khoi parallax ve vi tri cuoi cung
                    if (left === 0) {
                        btParallax.cPos.animate({'left': '-' + (btParallax.cPos.width() - (btParallax.post_wrap_width + options.spacing)) + 'px'}, 400, function () {
                            btParallax.isNavClick = true;
                        });
                    } else {//Neu khac 0 thi thuc hien dich truyen ve phia ben trai 1 khoang = options.next_prev_s
                        btParallax.cPos.animate({'left': '-' + (left - options.next_prev_s) + 'px'}, 400, function () {
                            btParallax.isNavClick = true;
                        });
                    }
                    return;
                } else {
                    btParallax.animateStop();
                    //Kiem tra xem nut bam next dc phep click hay khong
                    if (btParallax.isNavClick === false) {//Neu laf khong thi return
                        return;
                    }
                    //Neu la co thi gan lai gia tri cua bien kiem tra = false va thuc hien xu ly su kien click
                    btParallax.isNavClick = false;
                    //Tinh vij tri hien tai cua khoi noi dung parallax
                    var left = Math.abs(btParallax.cPos.position().left);

                    //Kiem tra vi tri cua khoi parallax sau khi dich chuyen
                    //Neu khong du de dich chuyen thi thuc hien lay phan tu o cuoi cung append vao dau cua khoi content
                    if (left - options.next_prev_s <= 0) {
                        btParallax.cPos.css('left', (btParallax.cPos.position().left - (btParallax.colwidth)) + 'px');
                        btParallax.cPos.find('.layout').prepend(adv.find('.parallax-col:last'));
                    }

                    btParallax.cPos.animate({left: (btParallax.cPos.position().left + options.next_prev_s) + 'px'}, 400, function () {
                        btParallax.isNavClick = true;
                        btParallax.animateStart();
                    });
                }
            };
            //Ham xu ly khi anh thumbnail cua image gallery duoc click
            this.imgThumbClick = function (e, el) {
                //Kiem tra xem trang thai hien tai co duoc phep click vao anh thumbnail ko
                if (btParallax.isThumClick === false) {//Neu khong thi return
                    return;
                } else {//Neu dung thi thuc hien open large image
                    //Kiem tra xem list image cos dang scroll ko
                    if (btParallax.aplistAnimate === true) {//Neu dang scroll thi stop effect
                        btParallax.animateStop();
                    } else {//neu khong thi hien thi nut bam next vaf prev
                        btParallax.showNav(true);
                    }
                    //Thiet lap css cho khoi chua anh large va dieu khien control
                    adv.find('.parallax-content-wrap').css('overflow-y', 'hidden');
                    adv.find('.button-wrap .close-btn').removeClass('has-scroll');
                    adv.find('.nav-wrap-in.next').removeClass('has-scroll');

                    //Xacs dinh va thiet lap vi tri ban dau de zoom in image large
                    btParallax.ePos = {'top': e.clientY, 'left': e.clientX};
                    btParallax.eSize = {'width': $(el).width(), 'height': $(el).height()};

                    //Them class cho nav de dieu khien nut bam next va prev
                    adv.find('.nav-prev').addClass('prev-large');
                    adv.find('.nav-next').addClass('next-large');

                    //Thuc hien load image va show large image
                    var show_box = $(el).parent().find('.show_box');
                    show_box.addClass('show');
                    var img = new Image();
                    $(img).load(function () {
                        adv.find('.content-show-large .item-contain').html(show_box.html());
                        adv.find('.content-show-large').removeClass('hidden').fadeIn(300);
                        adv.find('.content-show-large').css({'top': btParallax.ePos.top, 'left': btParallax.ePos.left, 'width': 0, 'height': 0}).removeClass('hidden').addClass('show').animate({'top': 0, 'left': 0, 'width': '100%', 'height': '100%'}, 500, function () {
                            adv.find('.content-show-large .loading').fadeIn(100);
                            adv.find('.content-show-large .loading').fadeOut(100);
                            adv.find('.button.close-btn').addClass('close-image-info');
                            btParallax.isThumClick = false;
                        });
                    }).error(function () {
                        alert('Can\'t load image!');
                    }).attr('src', $(show_box.html()).attr('src'));
                }
            };
            // Ham xu ly de load noi dung sau khi parallax full man hinh
            this.loadImageItems = function (in_out, index, callback) {
                if (in_out === true) {
                    btParallax.itemAnimateIn(btParallax.rowList, index, callback, false);
                } else {
                    btParallax.itemAnimateOut(btParallax.rowList, index, callback, false);
                }
            };
            //Ham load danh sach item khi hien thi
            this.itemAnimateIn = function (list, index, callback, isCallback) {
                if (options.scroll_direction === 'ltr') {
                    if (index >= 0) {
                        setTimeout(function () {
                            if (((index / options.rows) - 2 >= btParallax.colItemShow || index === list.length) && isCallback === false) {
                                isCallback = true;
                                callback();
                            }
                            $(list[index]).addClass('default-pos').removeClass('in-pos');
                            index--;
                            btParallax.itemAnimateIn(btParallax.rowList, index, callback, isCallback);
                        }, 100);
                    } else {
                        if (isCallback === false) {
                            callback();
                        }
                        isCallback = false;
                    }
                } else {
                    if (index < list.length) {
                        setTimeout(function () {
                            if (((index / options.rows) - 2 >= btParallax.colItemShow || index === list.length) && isCallback === false) {
                                isCallback = true;
                                callback();
                            }
                            $(list[index]).addClass('default-pos').removeClass('in-pos');
                            index++;
                            btParallax.itemAnimateIn(btParallax.rowList, index, callback, isCallback);
                        }, 100);
                    } else {
                        if (isCallback === false) {
                            callback();
                        }
                        isCallback = false;
                    }
                }
            };

            //ham an danh sach item
            this.itemAnimateOut = function (list, index, callback) {
                if (index / options.rows < btParallax.colLeft + btParallax.colItemShow) {
                    setTimeout(function () {
                        $(list[index]).addClass('out-pos').removeClass('default-pos');
                        index++;
                        btParallax.itemAnimateOut(btParallax.rowList, index, callback);
                    }, 100);
                } else {
                    callback();
                }
            };

            //ham scroll danh sach image 
            this.aplistItemAnimate = function () {
                //Kiem tra huong di chuyen scroll image
                if (options.scroll_direction === 'rtl') {//Huong chya tu phai sang trai
                    btParallax.isNavClick = true;
                    var space = btParallax.winWidth - btParallax.cposWidth;
                    if (space >= 0) {
                        btParallax.cPos.css('left', '0px');
                        btParallax.isNavClick = false;
                    } else {
                        if (btParallax.colwidth + space >= 0 || Math.abs(btParallax.cPos.position().left) > btParallax.cposWidth) {
                            btParallax.isNavClick = false;
                            btParallax.cPos.css('left', '0px');
                        } else if (Math.abs(btParallax.cPos.position().left) > (btParallax.cposWidth - btParallax.winWidth)) {
                            btParallax.cPos.css('left', (btParallax.cPos.position().left + (btParallax.colwidth) - 1) + 'px');
                            adv.find('.parallax-col:first').appendTo(btParallax.cPos.find('.' + options.layout));
                        } else {
                            btParallax.cPos.css('left', (btParallax.cPos.position().left - 1) + 'px');
                        }

                    }
                } else {//Huong chay tu trai sang phai
                    if (Math.abs(btParallax.cPos.position().left) === 0) {
                        btParallax.cPos.css('left', (btParallax.cPos.position().left - (btParallax.colwidth) + 1) + 'px');
                        btParallax.cPos.find('.' + options.layout).prepend(adv.find('.parallax-col:last'));
                    } else {
                        btParallax.cPos.css('left', (btParallax.cPos.position().left + 1) + 'px');
                    }
                }
            };

            //Ham start animate cho dnah sach hinh anh
            this.animateStart = function () {
                btParallax.timer = setInterval(btParallax.aplistItemAnimate, 15);
            };

            //Ham stop animate cho danh sach hinh anh
            this.animateStop = function () {
                clearInterval(btParallax.timer);
            };

            //Ham cap nhat trang thai cho background
            this.backgroundUpdate = function (isFull) {
                //neu noi dung cua khoi parallax la full thi vi tri top cua background luon = 0
                if (isFull) {
                    btParallax.background.css('top', 0);
                }

                //set kich thuoc chieu cao cua background = kich thuoc cua man hinh window
                btParallax.background.css('height', btParallax.winHeight);

                //xu ly de background luon fill kin man hinh window
                //so sanh ti le width/height giua background va window, tu do thiet dat css phu hop cho background de background luon fill kin man hinh window
                var blockRatio = btParallax.winWidth / btParallax.winHeight;
                var backgroundRatio = btParallax.backgroundImg.width() / btParallax.backgroundImg.height() || btParallax.backgroundVideo.width() / btParallax.backgroundVideo.height();
                if (backgroundRatio > blockRatio) {
                    btParallax.backgroundImg.css({'height': '100%', 'width': 'auto'});
                    btParallax.backgroundVideo.css({'height': '100%', 'width': 'auto'});
                    adv.find('.video-wrap.video-upload').css({'height': '100%', 'width': 'auto'});
                } else {
                    btParallax.backgroundImg.css({'width': '100%', 'height': 'auto'});
                    adv.find('.video-wrap.video-upload').css({'height': 'auto', 'width': '100%'});
                    btParallax.backgroundVideo.css({'width': '100%', 'height': 'auto'});
                }
            };

            //Ham cap nhan vi tri cua khoi parallax ham nay chi duong dung khi kieu parallax la full width
            this.updateParallaxPosition = function () {
                if (btParallax.paraWrap.hasClass('full-width') && !btParallax.isFullContent) {
                    btParallax.paraWrap.css({'width': btParallax.winWidth, 'marginLeft': '-' + btParallax.paraWrap.parent()[0].getBoundingClientRect().left + 'px'});
                    //adv.find('.parallax-block-content').css({'width': btParallax.paraWrap.parent().width(), 'padding': '0 '+btParallax.paraWrap.parent().offset().left});
                }
            };

            //Ham xu ly khi resize kich thuoc trinh duyet (responsive)
            this.apResponsive = function () {
                //thiet lap lai gia tri cho cac bien can thiet
                btParallax.winHeight = $(window).height();
                btParallax.winWidth = $(window).width();
                btParallax.paraHeight = adv.height();
                btParallax.paraWidth = adv.width();
                btParallax.colItemShow = Math.ceil(btParallax.winWidth / (btParallax.colwidth));
                btParallax.paraWrapHeight = btParallax.paraWrap.height();
                btParallax.paraWrapWidth = btParallax.paraWrap.width();
                if (options.autoResizeGallery === '1') {
                    btParallax.galleryAutoResize();
                }
                //Goi lai cac ham cap nhat noi dung cua khoi parallax
                btParallax.backgroundUpdate(btParallax.isFullContent);
                btParallax.showHideParallax();
                btParallax.updateParallaxPosition();

                //Xu ly du lieu voi truong hop noi dung cua parallax la content
                if (options.contentType === 'postContent') {
                    if (btParallax.cPos.width() > btParallax.winWidth && btParallax.enableControlButton) {
                        btParallax.showNav(true);
                    } else {
                        btParallax.showNav(false);
                    }
                    btParallax.apContentUpdateStyle();
                }

                //Xu ly du lieu voi truong hop noi dung cua parallax la image

                if (options.contentType === 'image') {
                    if (btParallax.cPos.width() > btParallax.winWidth && btParallax.enableControlButton) {
                        btParallax.showNav(true);
                        if (!btParallax.aplistAnimate) {
                            btParallax.aplistAnimate = true;
                            btParallax.animateStart();
                        }
                    } else {
                        btParallax.showNav(false);
                        btParallax.cPos.css('left', '0px');
                        btParallax.aplistAnimate = false;
                        btParallax.animateStop();
                    }

                    btParallax.apImageUpdateStyle();


                }

                //Xu ly du lieu voi truong hop noi dung cua parallax la video
                if (options.contentType === 'video') {
                    adv.find('.item-contain').css({'height': btParallax.winHeight, 'width': btParallax.winWidth});
                }
            };

            //Ham xu ly cap nhat lai style cho kieu noi dung image
            this.apImageUpdateStyle = function () {
                if (options.autoResizeGallery === '1') {
                    btParallax.cPos.css('padding', '20px 0');
                } else {
                    if (btParallax.winHeight > ((options.item_height + options.spacing) * options.rows - options.spacing + 40)) {
                        btParallax.cPos.css('padding', (btParallax.winHeight - ((options.item_height + options.spacing) * options.rows - options.spacing)) / 2 + 'px 0');
                        adv.find('.button-wrap .close-btn').removeClass('has-scroll');
                        adv.find('.nav-wrap-in.next').removeClass('has-scroll');
                        btParallax.hasScroll = false;
                    } else {
                        btParallax.cPos.css('padding', '20px 0');
                        btParallax.hasScroll = true;
                        adv.find('.button-wrap .close-btn').addClass('has-scroll');
                        adv.find('.nav-wrap-in.next').addClass('has-scroll');
                    }
                }
            };

            //Ham xy ly cap nhat lai style cho kieu noi dung conent
            this.apContentUpdateStyle = function () {
                if (btParallax.winHeight > (btParallax.cPos.parent().height())) {
                    btParallax.cPos.parent().addClass('min-height').removeClass('max-height');
                    btParallax.hasScroll = false;
                    adv.find('.button-wrap .close-btn').removeClass('has-scroll');
                    adv.find('.nav-wrap-in.next').removeClass('has-scroll');
                } else {
                    btParallax.cPos.parent().addClass('max-height').removeClass('min-height');
                    btParallax.hasScroll = true;
                    adv.find('.button-wrap .close-btn').addClass('has-scroll');
                    adv.find('.nav-wrap-in.next').addClass('has-scroll');
                }

                //Tinh so luong cot cua item co the hien thi tuong ung voi kich thuoc man hinh hien tai.
                var item_num = Math.floor(btParallax.winWidth / (btParallax.colwidth));

                //Xac diinh kich thuoc the chua danh sach item duoc hien thi.
                if (item_num > btParallax.aplist.length) {
                    btParallax.post_wrap_width = (btParallax.cposWidth) - options.spacing;
                } else {
                    btParallax.post_wrap_width = ((btParallax.colwidth) * item_num) - options.spacing;
                }

                //Thiet lap kich thuoc cho the chua danh sach duocj hien thi.
                btParallax.cPos.parent().width(btParallax.post_wrap_width);
                //Thiet lap bij tri cua khoi item hien thi.
                btParallax.cPos.parent().css('left', (btParallax.winWidth - btParallax.post_wrap_width) / 2 + 'px');
            };

//            Ham cap nhat cac trang thai cua khoi parallax, duoc ap dung khi resize window vaf khoi tao khoi parallax
            this.apUpdate = function () {
                btParallax.eTopCurrent = btParallax.paraWrap.offset().top - $(window).scrollTop();
                btParallax.eTopCenter = ((btParallax.winHeight - btParallax.paraWrapHeight) / 2);
                btParallax.eLeftCurrent = btParallax.paraWrap.offset().left;
                btParallax.paraHeight = adv.height(), btParallax.paraWidth = adv.width();
                btParallax.s = Math.abs(btParallax.eTopCurrent - btParallax.eTopCenter);
                btParallax.backPosX = adv.find('.parallax-background').position().left;

//                css position for parallax block
                if (options.slideSize.type === 'full') {
                    btParallax.blockCssCurent = {
                        'position': 'fixed',
                        'z-index': 99999,
                        'width': '100%',
                        'height': btParallax.paraWrapHeight,
                        'top': btParallax.eTopCurrent,
                        'left': 0
                    };
                } else {
                    btParallax.blockCssCurent = {
                        'position': 'fixed',
                        'z-index': 99999,
                        'width': btParallax.paraWrapWidth,
                        'height': btParallax.paraWrapHeight,
                        'top': btParallax.eTopCurrent,
                        'left': btParallax.eLeftCurrent
                    };
                }
                btParallax.blockCssCenter = {'top': btParallax.eTopCenter};
            };

            //Ham xu ly an/hien khoi parallax khi resize kich thuoc trinh duyet
            this.showHideParallax = function () {
                if (btParallax.winWidth <= options.minWidthAllow) {
                    btParallax.paraWrap.addClass('hidden');
                } else {
                    btParallax.paraWrap.removeClass('hidden');
                }
            };

            //Ham xy ly auto resize
            this.galleryAutoResize = function () {
                if (!btParallax.isParallaxOpen || options.contentType !== 'image') {
                    return;
                }
                var item_size = (btParallax.winHeight - 40 - (options.rows - 1) * options.spacing) / options.rows;

                    btParallax.rowList.each(function () {
                        var item = $(this), item_style = '';
                        if (options.layout === 'flexible') {
                            //Kiem tra va xu ly doi voi moi vij tri item xac dinh.
                            //Truong hop vi tri cua item = 1,2,4,8,9 (kich thuoc width = height)
                            if (item.hasClass('row-1') || item.hasClass('row-2') || item.hasClass('row-4') || item.hasClass('row-8') || item.hasClass('row-9')) {
                                item_style = 'width:' + item_size + 'px;height:' + item_size + 'px;';
                            }

                            //Truong hop vi tri item = 3,7,6 (Kich thuoc width = 2 lan kich thuoc height)
                            if (item.hasClass('row-3') || item.hasClass('row-6') || item.hasClass('row-7')) {
                                item_style = 'width:' + (item_size * 2 + options.spacing) + 'px;height:' + item_size + 'px;';
                            }

                            //Truong hop vi tri item = 5,10 (Kich thuoc height = 2 lan kich thuoc width)
                            if (item.hasClass('row-5') || item.hasClass('row-10')) {
                                item_style = 'width:' + item_size + 'px;height:' + (item_size * 2 + options.spacing) + 'px;';
                            }

                            //tao style dat vi tri cho moi item dua vao vi tri cua item
                            if (item.hasClass('row-1')) {
                                item_style += 'top: 0; left: 0;';
                            } else if (item.hasClass('row-2')) {
                                item_style += 'top: 0; left: ' + (item_size + options.spacing) + 'px;';
                            } else if (item.hasClass('row-3')) {
                                item_style += 'top: ' + (item_size + options.spacing) + 'px; left: 0;';
                            } else if (item.hasClass('row-4')) {
                                item_style += 'top: ' + ((item_size + options.spacing) * 2) + 'px; left: 0;';
                            } else if (item.hasClass('row-5')) {
                                item_style += 'top: 0; left: ' + ((item_size + options.spacing) * 2) + 'px;';
                            } else if (item.hasClass('row-6')) {
                                item_style += 'top: ' + ((item_size + options.spacing) * 2) + 'px; left: ' + (item_size + options.spacing) + 'px;';
                            } else if (item.hasClass('row-7')) {
                                item_style += 'top: 0; left: ' + ((item_size + options.spacing) * 3) + 'px;';
                            } else if (item.hasClass('row-8')) {
                                item_style += 'top: ' + (item_size + options.spacing) + 'px; left: ' + ((item_size + options.spacing) * 3) + 'px;';
                            } else if (item.hasClass('row-9')) {
                                item_style += 'top: ' + ((item_size + options.spacing) * 2) + 'px; left: ' + ((item_size + options.spacing) * 3) + 'px;';
                            } else if (item.hasClass('row-10')) {
                                item_style += 'top: ' + (item_size + options.spacing) + 'px; left: ' + ((item_size + options.spacing) * 4) + 'px;';
                            }
                            item.attr('style', item_style);
                            btParallax.colwidth = (item_size + options.spacing) * 5;
                        }
                        if (options.layout === 'default') {
                            var ratio = options.item_width / options.item_height;
                            btParallax.colwidth = item_size * ratio + options.spacing;
                            item.css('height', item_size);
                            item.find('.thumb').css({'width': (btParallax.colwidth - options.spacing) + 'px', 'height': item_size + 'px'});
                        }
                    });



                //Gan gia tri cho bien kich thuoc cua khoi parallax
                btParallax.cposWidth = (btParallax.colwidth) * btParallax.aplist.length;

                //Set kich thuoc cho tung item doi voi kieu noi dung hinh anh
                btParallax.aplist.css({'width': (btParallax.colwidth - options.spacing) + 'px', 'margin-right': options.spacing});

                //Dat kich thuoc cho khoi parallax
                if (btParallax.aplist.length > 0) {
                    btParallax.cPos.width(btParallax.cposWidth);
                } else {
                    btParallax.cPos.css('width', '100%');
                }

                //Set kich thuoc chieu cao cho th chua khoi noi dung parallax
                btParallax.cPos.css('height', btParallax.winHeight + 'px');
            };


            //Ham Show-hide Navbar
            this.showNav = function (isShow) {
                if (isShow) {
                    if (btParallax.enableControlButton) {
                        adv.find('.nav-wrap').removeClass('hidden');
                    }
                } else {
                    adv.find('.nav-wrap').addClass('hidden');
                }
            };

            //Chay script
            btParallax.renderParallax();
        });
    };
})(jQuery);