(function ($) {
    "use strict";
    $(window).load(function () {
        var $container = $('#our-class-main');
        $container.isotope({
            itemSelector: '.element-item'
        });
        $('#filters button').click(function () {
            var selector = $(this).attr('data-filter');
            $('#filters button').removeClass('is-checked');
            $(this).addClass('is-checked');
            $container.isotope({filter: selector});
            return false;
        });
        $('#load-more-class').click(function () {
            var itemTarget = $(this);
            if ($(itemTarget).hasClass('all-loaded')) {
                return;
            }
            var pages = $('.post-pagination a');
            var listPageUrl = new Array(), endPage = false;
            pages.each(function () {
                if ($(this).hasClass('loaded')) {
                } else {
                    listPageUrl.push($(this));
                }
            });
            if (listPageUrl.length === 2) {
                endPage = true;
            }
            var pageLoad = listPageUrl[0];
            $.ajax({
                type: "GET",
                url: $(pageLoad).attr('href'),
                cache: false,
                beforeSend: function (xhr) {
                    itemTarget.find('.ajax-loading-icon').show();
                },
                success: function (transport) {
                    var html = $(transport).find('div .element-item');
                    if (itemTarget.hasClass('load-teacher')) {
                        $container = $('#our-trainers');
                        var img = new Image();
                        $(img).load(function () {
                            $container.append(html);
                        }).error(function () {
                            alert('Can\'t load image!');
                        }).attr('src', $('.box-inner img', html).attr('src'));
                    }
                    if (itemTarget.hasClass('load-courses')) {
                        var img = new Image();
                        $(img).load(function () {
                            $container.append(html).isotope('insert', html);
                        }).error(function () {
                            alert('Can\'t load image!');
                        }).attr('src', $('.box-inner img', html).attr('src'));
                    }
                    $(pageLoad).addClass('loaded');
                    itemTarget.find('.ajax-loading-icon').hide();
                    if (endPage) {
                        itemTarget.addClass('all-loaded').html('All Loaded');
                    }
                }
            });
        });
    })
})(jQuery);