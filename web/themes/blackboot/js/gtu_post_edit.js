var inputEvents = {};

inputEvents.hideImage = function (selector, image_selector) {
    if ($(selector).prop('checked')) {
        $(image_selector).closest('div.control-group').show();
    } else {
        $(image_selector).closest('div.control-group').hide();
    }
};

inputEvents.hideImageSupertop = function () {
    if ($('#GtuPost_is_home_supertop').prop('checked')) {
        $('#GtuPost_image_supertop').closest('div.control-group').show();
        $('#GtuPost_image_home_supertop').closest('div.control-group').show();
    } else if ($('#GtuPost_is_supertop').prop('checked')) {
        $('#GtuPost_image_supertop').closest('div.control-group').show();
        $('#GtuPost_image_home_supertop').closest('div.control-group').hide();
    } else {
        $('#GtuPost_image_supertop').closest('div.control-group').hide();
        $('#GtuPost_image_home_supertop').closest('div.control-group').hide();
    }
};

inputEvents.onLoad = function () {
    inputEvents.hideImage('#GtuPost_is_image_in_post', '#GtuPost_image_in_post');
    inputEvents.hideImage('#GtuPost_is_top', '#GtuPost_image_top');
    inputEvents.hideImage('#GtuPost_is_top', '#GtuPost_is_home_top');
    inputEvents.hideImage('#GtuPost_is_big_top', '#GtuPost_image_big_top');
    inputEvents.hideImage('#GtuPost_is_big_top', '#GtuPost_is_home_big_top');
    inputEvents.hideImageSupertop();
};

jQuery(function ($) {
    inputEvents.onLoad();
    $('#GtuPost_is_image_in_post').on('click', function () {
        inputEvents.hideImage('#GtuPost_is_image_in_post', '#GtuPost_image_in_post');
    });
    $('#GtuPost_is_top').on('click', function () {
        inputEvents.hideImage('#GtuPost_is_top', '#GtuPost_image_top');
        inputEvents.hideImage('#GtuPost_is_top', '#GtuPost_is_home_top');
    });
    $('#GtuPost_is_big_top').on('click', function () {
        inputEvents.hideImage('#GtuPost_is_big_top', '#GtuPost_image_big_top');
        inputEvents.hideImage('#GtuPost_is_big_top', '#GtuPost_is_home_big_top');
    });
    $('#GtuPost_is_supertop, #GtuPost_is_home_supertop').on('click', function () {
        inputEvents.hideImageSupertop();
    });
});
