(function($) {
    "use strict";

    var site = function() {
        this.navLi = $('#nav li').children('ul').hide().end();
        this.init();
    };

    site.prototype = {
        init: function() {
            this.setMenu();
        },
        setMenu: function() {
            $.each(this.navLi, function() {
                if ($(this).children('ul')[0]) {
                    $(this)
                        .append('<span />')
                        .children('span')
                        .addClass('hasChildren');
                }
            });
            this.navLi.hover(function() {
                $(this).find('> ul').stop(true, true).slideDown('slow', 'easeOutBounce');
            }, function() {
                $(this).find('> ul').stop(true, true).hide();
            });
        }
    };

    new site();
})(jQuery);