(function ($) {
    'use strict';

    $.alerts = {
        defaultTimeout: 5000,
        containerClass: '.notify-box',
        loadingText: 'Loading',

        hideInitial: function (timeout) {
            timeout = timeout || $.alerts.defaultTimeout;
            var $box = $($.alerts.containerClass);
            if ($box.length) {
                setTimeout(function () {
                    $box.find('.alert:not(.msg-fly)').fadeOut(200, function () {
                        $box.find('.alert:not(.msg-fly)').remove();
                    });
                }, timeout);
            }
        },

        showSuccess: function (message, timeout, autowidth) {
            show('success', message, timeout, autowidth);
        },
        showInfo: function (message, timeout, autowidth) {
            show('info', message, timeout, autowidth);
        },
        showWarning: function (message, timeout, autowidth) {
            show('warning', message, timeout, autowidth);
        },
        showDanger: function (message, timeout, autowidth) {
            show('error', message, timeout, autowidth);
        },
        showError: function (message, timeout, autowidth) {
            show('error', message, timeout, autowidth);
        },

        busyOn: function () {
            $('body').append('<div class="alert alert-warning loading-indicator">' + $.alerts.loadingText + '</div>');
        },
        busyOff: function () {
            var $body = $('body');
            $body.find('.loading-indicator').fadeOut(400, function () {
                $body.find('.loading-indicator').remove();
            });
        }
    };

    function show(type, message, timeout, autowidth) {
        timeout = timeout || $.alerts.defaultTimeout;
        autowidth = autowidth || false;
        var $box = $('body').find($.alerts.containerClass);
        if ($box.length) {
            var msg_key = 'msg-' + (new Date().getTime());
            $box.append('<div class="alert alert-' + type + ' alert-icon msg-fly ' + msg_key + (autowidth ? ' notify-auto-width' : '') + '">' + message + '</div>');
            // hide after timeout
            setTimeout(function () {
                $box.find('.' + msg_key).fadeOut(200, function () {
                    $box.find('.' + msg_key).remove();
                });
            }, timeout);
        }
    }

})(jQuery);