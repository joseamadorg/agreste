(function($) {
    "use strict";

    // Header Scroll
    const header = $('.navbar');
    const scrollUp = "scroll-up";
    const scrollDown = "scroll-down";
    let lastScroll = 0;

    $(window).on("scroll", () => {
        const currentScroll = window.scrollY;
        if (currentScroll <= 0) {
            header.removeClass(scrollUp);
            return;
        }

        if (currentScroll > lastScroll && !header.hasClass(scrollDown)) {
            // down
            header.removeClass(scrollUp).addClass(scrollDown);
        } else if (currentScroll < lastScroll && header.hasClass(scrollDown)) {
            // up
            header.removeClass(scrollDown).addClass(scrollUp);
        }
        lastScroll = currentScroll;
    });

    // Replacing with HOME_URL
    $(document).ready(function() {
        $('.footer-links a').each(function() {
            var link = $(this).attr('href');
            var newlink = link.replace("http://[url_link]", RepayAjax.HOME_URL);
            $(this).attr('href', newlink);
        });
    });

    // Dequeue CSS Files
    $(document).ready(function() {
        $('link').each(function() {
            var linkId = $(this).attr('id');
            if (linkId == 'style-css') {
                $(this).remove();
            }
        });
    });
    
    // Update cart icon counter
    $(document).on('click', '.add_to_cart_button', function() {
        setTimeout(function() {
            var data = {
                'action': 'cart_count_retriever'
            };
            $.post(wc_add_to_cart_params.ajax_url, data, function(response) {
                if (response == 1) {
                    $('.cart-btn a').append('<span class="cart-contents-count">' + response + '</span>');
                } else {
                    $('.cart-contents-count').text(response);
                }
            });
        }, 1500);
    });

    $(document).on('click', '.woocommerce .cart button.button', function() {
        setTimeout(function() {
            var data = {
                'action': 'cart_count_retriever'
            };
            $.post(wc_add_to_cart_params.ajax_url, data, function(response) {
                $('.cart-contents-count').text(response);
                $(document.body).trigger('wc_fragment_refresh');
            });
        }, 1000);
    });

    $(document).on('click', '.woocommerce a.remove', function() {
        setTimeout(function() {
            var data = {
                'action': 'cart_count_retriever'
            };
            $.post(wc_add_to_cart_params.ajax_url, data, function(response) {
                $('.cart-contents-count').text(response);
                $(document.body).trigger('wc_fragment_refresh');
            });
        }, 1000);
    });

    // Submenu Click Function
    $(document).ready(function() {
        $('.navbar-area .nav-container .navbar-collapse .navbar-nav li.menu-item-has-children .sub-menu .menu-item-has-children').on('click', function() {
            $(this).find('.navbar-area .nav-container .navbar-collapse .navbar-nav li.menu-item-has-children .sub-menu .menu-item-has-children > .sub-menu').toggleClass('show');
        });
    });

    // Back to top button
    $(function() {
        // Scroll event
        $(window).on('scroll', function() {
            var scrolled = $(window).scrollTop(); 
            if (scrolled > 200) $('#backtotop').fadeIn('slow').css('opacity', '1');
            if (scrolled < 200) $('#backtotop').fadeOut('slow');
        });

        // Click event
        $('#backtotop').on('click', function() {
            $("html, body").animate({ scrollTop: "0" }, 500);
        });
    });

})(jQuery);
