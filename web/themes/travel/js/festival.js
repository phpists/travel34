jQuery(function ($) {
    var chks = [
        '.b-festival__check__month',
        '.b-festival__check__style',
        '.b-festival__check__country',
        // new universal
        '.b-festival__check__param1',
        '.b-festival__check__param2',
        '.b-festival__check__param3'
    ];
    var chksGroups = [
        '.b-festival__check__month__group',
        '.b-festival__check__style__group',
        '.b-festival__check__country__group',
        // new universal
        '.b-festival__check__param1__group',
        '.b-festival__check__param2__group',
        '.b-festival__check__param3__group'
    ];
    var filterAttributes = {
        '.b-festival__check__month': 'month',
        '.b-festival__check__style': 'style',
        '.b-festival__check__country': 'country',
        // new universal
        '.b-festival__check__param1': 'param1',
        '.b-festival__check__param2': 'param2',
        '.b-festival__check__param3': 'param3'
    };


    $('.b-festival__header__filters').on('click', chks.join(','), function () {
        var classItem = $(this).attr('class');
        var classGroupItem = classItem + '__group';
        var $checkboxes = $('input[type="checkbox"].' + classItem);
        if ($checkboxes.filter(':checked').length === $checkboxes.length || $checkboxes.filter(':checked').length === 0) {
            $('.' + classGroupItem).attr('checked', 'checked');
        } else {
            $('.' + classGroupItem).removeAttr('checked');
        }

    });

    $('.b-festival__header__filters').on('click', chksGroups.join(','), function () {
        var classGroupItem = $(this).attr('class');
        var classItem = classGroupItem.replace('__group', '');
        //var $checkboxes = $('input[type="checkbox"].' + classItem);
        if ($(this).is(':checked')) {
            $('input[type="checkbox"].' + classItem).removeAttr('checked');
        }

    });
    $('.b-festival__button__submit__wrap').on('click', '.b-festival__button__submit', getData);

    function getData() {
        $('.full-width-300col').show();
        if (!$('.full-width-300col').next().hasClass('full-width-300col')) {
            $('.full-width-300col').next().hide();
        }
        $('.nothing-found').hide();
        $.each(chks, function (index, classItem) {
            if (!$(classItem).length) {
                return;
            }
            var classGroupItem = classItem + '__group';
            if ($(classGroupItem).is(':checked')) {
                return;
            }
            var $checkboxes = $('input[type="checkbox"]' + classItem);
            var filterValues = [];
            $checkboxes.each(function (index) {
                if ($(this).is(':checked')) {
                    filterValues.push($(this).val());
                }
            });

            $('.full-width-300col').each(function () {
                var dataAttribute = filterAttributes[classItem];
                var attribute = String($(this).data(dataAttribute));
                var itemValues = attribute.split(',');
                var intersection = itemValues.filter(function (el) {
                    return filterValues.indexOf(el) !== -1
                });
                if (intersection.length === 0) {
                    $(this).hide();
                    if (!$(this).next().hasClass('full-width-300col')) {
                        $(this).next().hide();
                    }
                }
            });

        });
        if ($('.full-width-300col:visible').length === 0) {
            $('.nothing-found').show();
        }
        $('html, body').animate({
            scrollTop: $('.b-festival__button__submit__wrap').position().top + 200
        });
    }

});
