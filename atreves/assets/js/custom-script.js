(function($) {
    "use strict";
    $(document).ready(function() {
        $('[name="activate_akd_framework"]').wrap('<form id="activate-plugin-form" method="post"></form>');
        $('#activate-plugin-form').append('<input type="hidden" name="_wpnonce" value="' + urls.akdNonce + '">');
        $('#activate-plugin-form').append('<input type="hidden" name="activate_akd_framework_plugin" value="activate" />');
 
        $(document).on('click', '.install-akd-framework', function(e){
            e.preventDefault();
            var $button = $(this);
            var data = {
                action: 'install_plugin',
                plugin_slug: $button.data('slug'),
                plugin_name: $button.data('name'),
                akdNonce: urls.akdNonce
            };
            $button.text($button.data('processing')).attr('disabled', 'disabled');
            $.post(urls.ajaxUrl, data, function(response) {
                Swal.fire('Success!', response.data, 'success');
                window.location.href = urls.adminUrl +'admin.php?page=akd-framework';
            }).fail(function(xhr, status, error) {
                alert(xhr.responseText);
                $button.text('Install').removeAttr('disabled');
            });
        });
 
        if (window.location.href.indexOf(urls.themeTemplate) > -1 && window.location.href.indexOf("theme-editor.php") === -1) {
            document.body.classList.add('akd-dashboard-card');
        }
    });
})(jQuery);