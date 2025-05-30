var inputEvents = {};

inputEvents.hideImage = function (selector, image_selector) {
    if ($(selector).prop('checked')) {
        $(image_selector).closest('div.control-group').show();
    } else {
        $(image_selector).closest('div.control-group').hide();
    }
};

inputEvents.typeIdEvents = function () {
    // guide, photohistory type
    if ($.inArray($('#Post_type_id').val(), ["2", "3"]) !== -1) {
        $('#Post_custom_icon').closest('div.control-group').show();
    } else {
        $('#Post_custom_icon').closest('div.control-group').hide();
    }
    // news type
    if ($.inArray($('#Post_type_id').val(), ["1"]) !== -1) {
        $('#Post_image_news').closest('div.control-group').show();
        $('#Post_news_link').closest('div.control-group').show();
        $('#Post_news_link_title').closest('div.control-group').show();
        $('#Post_image').closest('div.control-group').hide();
    } else {
        $('#Post_image_news').closest('div.control-group').hide();
        $('#Post_news_link_title').closest('div.control-group').hide();
        $('#Post_news_link').closest('div.control-group').hide();
        $('#Post_image').closest('div.control-group').show();
    }
};

inputEvents.onLoad = function () {
    inputEvents.typeIdEvents();
    inputEvents.hideImage('#Post_need_image_big_post', '#Post_image_big_post');
    inputEvents.hideImage('#Post_is_home_top', '#Post_image_home_top');
    inputEvents.hideImage('#Post_is_home_top', '#Post_is_home_first_top');
    inputEvents.hideImage('#Post_is_big_top', '#Post_image_top');
    inputEvents.hideImage('#Post_is_big_top', '#Post_is_home_supertop');
    inputEvents.hideImage('#Post_is_gtb_post', '#Post_gtb_post_id');
    inputEvents.hideImage('#Post_is_gtu_post', '#Post_gtu_post_id');
};

jQuery(function ($) {
    inputEvents.onLoad();
    $('#Post_type_id').on('change', function () {
        inputEvents.typeIdEvents();
    });
    $('#Post_need_image_big_post').on('click', function () {
        inputEvents.hideImage('#Post_need_image_big_post', '#Post_image_big_post');
    });
    $('#Post_is_home_top').on('click', function () {
        inputEvents.hideImage('#Post_is_home_top', '#Post_image_home_top');
        inputEvents.hideImage('#Post_is_home_top', '#Post_is_home_first_top');
    });
    $('#Post_is_big_top').on('click', function () {
        inputEvents.hideImage('#Post_is_big_top', '#Post_image_top');
        inputEvents.hideImage('#Post_is_big_top', '#Post_is_home_supertop');
    });
    $('#Post_is_gtb_post').on('click', function () {
        inputEvents.hideImage('#Post_is_gtb_post', '#Post_gtb_post_id');
    });
    $('#Post_is_gtu_post').on('click', function () {
        inputEvents.hideImage('#Post_is_gtu_post', '#Post_gtu_post_id');
    });
});
