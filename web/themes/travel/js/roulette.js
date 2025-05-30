jQuery(function ($) {
// ROULETTE

    $('select:not(.jagermeister-select)').select2({
        minimumResultsForSearch: Infinity
    });
    $('.jagermeister-select').select2({
        minimumResultsForSearch: Infinity,
        dropdownCssClass: "jagermeister-dropdown"
    });

    $(".phone-input").mask("+375 99 999 99 99", {placeholder: "_"});

    function randomInteger(min, max) {
        var rand = min + Math.random() * (max - min);
        rand = Math.round(rand);
        return rand;
    }

    var param1_name = $('.roulette-form').data('param1');
    var param2_name = $('.roulette-form').data('param2');

    if ($('.roulette-wrap').length) {
        $('.roulette-wrap .event').each(function () {
            var params1 = $(this).attr('data-' + param1_name);
            var params2 = $(this).attr('data-' + param2_name);
            params1 += ' all';
            params2 += ' all';
            $(this).attr('data-' + param1_name, params1);
            $(this).attr('data-' + param2_name, params2);
        });
    }

    $('.roulette-form button, .roulette-wrap .again').click(function (e) {
        e.stopPropagation();
        e.preventDefault();
        var param1 = $('#' + param1_name + '-select').val(),
            param2 = $('#' + param2_name + '-select').val(),
            eventArray = [],
            visibleIndex = 0;
        $('.events-grid .event').each(function (e) {
            if (!$(this).hasClass('visible') && ($(this).data(param1_name).indexOf(param1) + 1) && ($(this).data(param2_name).indexOf(param2) + 1)) {
                eventArray.push($(this).index())
            }
        });
        if (eventArray.length) {
            if (eventArray.length > 1) {
                visibleIndex = randomInteger(0, eventArray.length - 1);
            }
            $('.events-grid .event.visible').removeClass('visible');
            $('.nothing-found').removeClass('visible');
            $('.roulette-form button').hide();
            $('.again').addClass('visible');
            $('.bank-box').addClass('visible');
            $('.events-grid .event').eq(eventArray[visibleIndex]).addClass('visible');
            $('html, body').stop().animate({
                scrollTop: $('.events-grid').offset().top
            }, 300);
        } else if ($('.events-grid .event.visible').length) {
            if (!($('.events-grid .event.visible').data(param1_name).indexOf(param1) + 1) || !($('.events-grid .event.visible').data(param2_name).indexOf(param2) + 1)) {
                $('.events-grid .event.visible').removeClass('visible');
                $('.nothing-found').addClass('visible');
                $('.bank-box').removeClass('visible');
                $('html, body').stop().animate({
                    scrollTop: $('.roulette-wrap').offset().top
                }, 300);
            }
            else {
                $('html, body').stop().animate({
                    scrollTop: $('.events-grid').offset().top
                }, 300);
            }
        } else {
            $('.events-grid .event.visible').removeClass('visible');
            $('.nothing-found').addClass('visible');
            $('.bank-box').removeClass('visible');
            $('html, body').stop().animate({
                scrollTop: $('.roulette-wrap').offset().top
            }, 300);
        }
    });

    $('#ProposalForm_confirmed').on('change', function () {
        $('.bank-form-box button').prop('disabled', !$(this).prop('checked'));
    });
});

//End ROULETTE