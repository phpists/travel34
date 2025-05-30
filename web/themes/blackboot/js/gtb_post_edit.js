var inputEvents = {};

inputEvents.hideImage = function (selector, image_selector) {
    if ($(selector).prop('checked')) {
        $(image_selector).closest('div.control-group').show();
    } else {
        $(image_selector).closest('div.control-group').hide();
    }
};

inputEvents.hideImageSupertop = function () {
    if ($('#GtbPost_is_home_supertop').prop('checked')) {
        $('#GtbPost_image_supertop').closest('div.control-group').show();
        $('#GtbPost_image_home_supertop').closest('div.control-group').show();
    } else if ($('#GtbPost_is_supertop').prop('checked')) {
        $('#GtbPost_image_supertop').closest('div.control-group').show();
        $('#GtbPost_image_home_supertop').closest('div.control-group').hide();
    } else {
        $('#GtbPost_image_supertop').closest('div.control-group').hide();
        $('#GtbPost_image_home_supertop').closest('div.control-group').hide();
    }
};

inputEvents.onLoad = function () {
    inputEvents.hideImage('#GtbPost_is_image_in_post', '#GtbPost_image_in_post');
    inputEvents.hideImage('#GtbPost_is_top', '#GtbPost_image_top');
    inputEvents.hideImage('#GtbPost_is_top', '#GtbPost_is_home_top');
    inputEvents.hideImage('#GtbPost_is_big_top', '#GtbPost_image_big_top');
    inputEvents.hideImage('#GtbPost_is_big_top', '#GtbPost_is_home_big_top');
    inputEvents.hideImageSupertop();
};

jQuery(function ($) {
    inputEvents.onLoad();
    $('#GtbPost_is_image_in_post').on('click', function () {
        inputEvents.hideImage('#GtbPost_is_image_in_post', '#GtbPost_image_in_post');
    });
    $('#GtbPost_is_top').on('click', function () {
        inputEvents.hideImage('#GtbPost_is_top', '#GtbPost_image_top');
        inputEvents.hideImage('#GtbPost_is_top', '#GtbPost_is_home_top');
    });
    $('#GtbPost_is_big_top').on('click', function () {
        inputEvents.hideImage('#GtbPost_is_big_top', '#GtbPost_image_big_top');
        inputEvents.hideImage('#GtbPost_is_big_top', '#GtbPost_is_home_big_top');
    });
    $('#GtbPost_is_supertop, #GtbPost_is_home_supertop').on('click', function () {
        inputEvents.hideImageSupertop();
    });
});
