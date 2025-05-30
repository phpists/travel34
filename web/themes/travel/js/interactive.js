jQuery(function ($) {
    "use strict";

    $('.interactive-result-box').each(function () {
        if ($(this).find('.share-links').length) {
            $(this).find(".share-links").simpleShare({
                enabledProviders: ["twitter", "facebook", "vk"]
            });
        }
    });

    $('.js-start-interactive').click(function () {
        var thisParent = $(this).parents('.interactive-box');
        if (thisParent.hasClass('has-step2')) {
            $(this).parents('.interactive-box').addClass('step2');
        } else {
            thisParent.removeClass('step2').addClass('has-result');
            parentBox = $(this).parents('.interactive-box');
            getResults();
        }
    });

    $('.js-show-result').click(function () {
        submitName(this);
    });

    $('.enter-name-box').on('submit', function (e) {
        e.preventDefault();
        submitName(this);
    });

    var parentBox;

    function submitName(el) {
        var thisParent = $(el).parents('.interactive-box');
        var val = thisParent.find('.enter-name-box .form-control').val();
        val = $.trim(val);
        if (val.length < 2) {
            thisParent.find('.enter-name-box .form-control').addClass('error-inp');
        } else {
            var userName = thisParent.find('.enter-name-box .form-control').val();
            thisParent.removeClass('step2').addClass('has-result');
            if (thisParent.find('.name-title').find('.text').length) {
                thisParent.find('.name-title').find('.text').text(userName + thisParent.find('.name-title').attr('data-text-after'));
            } else {
                thisParent.find('.name-title').text(userName + thisParent.find('.name-title').attr('data-text-after'));
            }

            if (loading) {
                alert('Please wait');
            } else {
                parentBox = $(el).parents('.interactive-box');
                getResults();
            }
        }
    }

    $('.js-update-result').click(function () {
        if (loading) {
            alert('Please wait');
        } else {
            parentBox = $(this).parents('.interactive-box');
            getResults();
        }
    });

    $('.js-reload-interactive').click(function () {
        $(this).parents('.interactive-box').removeClass('has-result can-reload');
    });

    var loading = false;

    function getResults() {
        var $form = parentBox.find('form');
        loading = true;
        $.post($form.attr('action'), $form.serialize(), function (data) {
            parentBox.find('.interactive-result-box').html(data);
            if (parentBox.find(".share-links").length) {
                parentBox.find(".share-links").simpleShare({
                    enabledProviders: ["twitter", "facebook", "vk"]
                });
            }

            $('html, body').animate({
                scrollTop: parentBox.offset().top - 24
            }, 200);


            loading = false;
        }, 'html').fail(function () {
            loading = false;
            alert('Server error');
        });
    }

    $('.enter-name-box .form-control').on('input', function () {
        if ($(this).hasClass('error-inp')) {
            $(this).removeClass('error-inp');
        }
    });

});
