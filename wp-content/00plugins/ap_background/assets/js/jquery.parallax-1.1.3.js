/*
 Plugin: jQuery Parallax
 Version 1.1.3
 Author: Ian Lunn
 Twitter: @IanLunn
 Author URL: http://www.ianlunn.co.uk/
 Plugin URL: http://www.ianlunn.co.uk/plugins/jquery-parallax/
 
 Dual licensed under the MIT and GPL licenses:
 http://www.opensource.org/licenses/mit-license.php
 http://www.gnu.org/licenses/gpl.html
 */

(function ($) {
    var $window = $(window);
    var windowHeight = $window.height();

    $window.resize(function () {
        windowHeight = $window.height();
    });

    $.fn.btparallaxfix = function (xpos, speedFactor, outerHeight) {
        var $this = $(this);
        var getHeight;
        var firstTop;

        firstTop = $this.offset().top;
        if (outerHeight) {
            getHeight = function (jqo) {
                return jqo.outerHeight(true);
            };
        } else {
            getHeight = function (jqo) {
                return jqo.height();
            };
        }

        // setup defaults if arguments aren't specified
        if (arguments.length < 1 || xpos === null)
            xpos = "50%";
        if (arguments.length < 2 || speedFactor === null)
            speedFactor = 0.1;
        if (arguments.length < 3 || outerHeight === null)
            outerHeight = true;

        // function to be called whenever the window is scrolled or resized
        function update() {
            var pos = $window.scrollTop();
            firstTop = $this.offset().top;
            if ($this.is(":hidden"))
                return;
            var top = $this.offset().top;
            var height = getHeight($this);

            // Check if totally above or totally below viewport
            if (top + height < pos || top > pos + windowHeight) {
                return;
            }

            $this.find('.parallax-background').css('top', Math.round(-1 * (firstTop - pos) * speedFactor) + "px");
        }

        $window.bind('scroll', update).resize(update);
        update();
    };
})(jQuery);
