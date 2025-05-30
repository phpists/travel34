jQuery(function ($) {
    "use strict";

    $.alerts.hideInitial();
    $.alerts.loadingText = 'Загрузка';

    var clipboard = new ClipboardJS('.copytext', {
        text: function(trigger) {
            return $(trigger).text();
        }
    });
    clipboard.on('success', function() {
        $.alerts.showInfo('Скопировано', 1000, true);
    });
    clipboard.on('error', function() {
        $.alerts.showDanger('Ошибка', 1000, true);
    });

    $('.toggle-preview-test-widget').on('click', function () {
        $(this).closest('.preview-test-widget').toggleClass('hidden-test-widget');
        if ($(this).closest('.preview-test-widget').hasClass('hidden-test-widget')) {
            var date = new Date(new Date().getTime() + 7 * 86400000);
            document.cookie = "hidden-test-widget=1; path=/; expires=" + date.toUTCString();
        } else {
            document.cookie = "hidden-test-widget=0; path=/; expires=Thu, 01 Jan 1970 00:00:00 GMT";
        }
    });
});
