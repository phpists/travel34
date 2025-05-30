jQuery(function ($) {
    "use strict";

    var $body = $('body');

    var $page_key = $('#select_page_key');
    var $item_id = $('#select_item_id');

    var $style_page_list = $('#style_page_list');

    buildSelect($page_key.val(), true);

    $page_key.on('change', function () {
        var page_key = $(this).val();
        buildSelect(page_key);
    });

    checkList();

    function buildSelect(page_key, initial) {
        $item_id.select2('destroy');
        var options, hide = false;
        var values = $('#' + page_key + '_values');
        if (values.length) {
            options = values.html();
        } else {
            options = '<option value=""></option>';
            hide = true;
        }
        setTimeout(function () {
            $item_id.html(options);
            $item_id.select2({'placeholder': 'Выбрать', 'allowClear': true, 'width': 'resolve'});
            if (hide) {
                $item_id.closest('.select_item_id_container').addClass('is-hidden').hide();
            } else {
                $item_id.closest('.select_item_id_container').removeClass('is-hidden').show();
            }
            if (initial) {
                $('.add-style-page[data-selected="1"]').trigger('click');
            }
        }, 100);
    }

    $body.on('click', '.add-style-page', function (e) {
        e.preventDefault();
        var $btn = $(this);
        var $tpl = $('<p/>');

        //var $page_key = $('#select_page_key');
        //var $item_id = $('#select_item_id');

        var $inp1 = $('<input/>').attr('type', 'hidden').attr('name', $btn.attr('data-page-keys-name'));
        var $inp2 = $('<input/>').attr('type', 'hidden').attr('name', $btn.attr('data-item-ids-name'));

        var select_page_key_val = $page_key.val() || '0';
        var select_page_key_name = $page_key.find('option:selected').text();

        var select_item_id_val = $item_id.val() || '0';
        var select_item_id_name = $item_id.find('option:selected').text();

        if (!$item_id.closest('.select_item_id_container').hasClass('is-hidden') && (!select_item_id_val || select_item_id_val === '0')) {
            $.alerts.showDanger('Выберите элемент!', 1000, true);
            return;
        }

        var class_name = 'style-page-' + select_page_key_val + '-' + select_item_id_val;

        if ($('.style-page.' + class_name).length) {
            $.alerts.showDanger('Уже прикреплено!', 1000, true);
            return;
        }

        setTimeout(function () {
            $item_id.select2('val', '');
        }, 100);

        $inp1.val(select_page_key_val);
        $inp2.val(select_item_id_val);

        $tpl.addClass('style-page').addClass(class_name);
        $tpl.append($inp1);
        $tpl.append($inp2);
        $tpl.append('<a href="#" title="Убрать" class="remove-style-page"><i class="icon-remove"></i></a>');
        $tpl.append(' <strong>' + select_page_key_name + '</strong>');
        if (select_item_id_val) {
            $tpl.append(' <span>' + select_item_id_name + '</span>');
        }
        $tpl.append(' <sup class="text-error">new</sup>');

        $style_page_list.append($tpl);

        checkList();
    });

    $body.on('click', '.remove-style-page', function (e) {
        e.preventDefault();
        $(this).closest('.style-page').remove();

        checkList();
    });

    function checkList() {
        if (!$style_page_list.find('.style-page').length) {
            $style_page_list.append('<p class="text-error empty-list-warn">Прикрепите стиль к чему-нибудь</p>');
        } else {
            $style_page_list.find('.empty-list-warn').remove();
        }
    }

});
