jQuery(function ($) {
    "use strict";

    var windowWidth = Math.max($(window).width(), window.innerWidth);

    $(window).on('resize', function(){
        windowWidth = Math.max($(window).width(), window.innerWidth);
    });

    $(window).on('orientationchange', function(){
        windowWidth = Math.max($(window).width(), window.innerWidth);
    });

    if ($('.interactive-test .test-answer p').length) {
        $('.interactive-test .test-answer p').each(function () {
            $(this).html('<span class="level-1"><span class="level-2"><span class="level-3">' + $(this).html() + '</span></span></span>');
        });
    }

    // init format all content
    formatContent($('.interactive-test-content > *'));

    function formatContent($selector) {
        $selector.each(function () {
            var tag = this.tagName.toLowerCase();
            if (tag === 'div' && $(this).hasClass('videoWrapper')) {
                $(this).css({width: '100%'}).wrap('<div class="interactive-test-media"></div>');
            }
            if (tag === 'p' && !$(this).hasClass('test-title')) {
                //console.log($(this).children().length);
                if ($(this).children().length) {
                    var childTag = $(this).children()[0].tagName.toLowerCase();
                    //console.log(childTag);
                    if (childTag === 'img' || childTag === 'iframe' || childTag === 'picture') {
                        $(this).addClass('interactive-test-media');
                        $(this).replaceWith('<div class="interactive-test-media">' + $(this).html() + '</div>');
                    }
                }
            }
        });
    }

    function resetTests($selector) {
        $selector.find('.interactive-test .test-radio-item').removeClass('disabled-inp');
        $selector.find('.interactive-test input[type="radio"]').prop('checked', false).attr('disabled', false).removeClass('highlighted');
        $selector.find('.interactive-test .test-answer').hide();
        $selector.find('.interactive-test.final-step .interactive-test-content').html('');
    }

    // init reset all
    if ($('.interactive-test input[type="radio"]').length) {
        resetTests($('.interactive-test-box'));
    }

    $('.interactive-test input[type="radio"]').change(function () {
        var $parentStep = $(this).closest('.step');
        var $box = $parentStep.closest('.interactive-test-box');
        var correct_count = parseInt($box.attr('data-correct-count')) || 0;

        if ($parentStep.find('.test-answer').length) {
            $parentStep.find('.test-radio-item').addClass('disabled-inp').find('input[type="radio"]').attr('disabled', true);
            if ($(this).attr('data-boolean')) {
                $parentStep.find('.test-answer, .test-answer > .false').hide();
                $parentStep.find('.test-answer .true').show();
                correct_count++;
                $box.attr('data-correct-count', correct_count);
            } else {
                if (!$parentStep.find('.test-answer .false').is(':visible')) {
                    $parentStep.find('.test-answer, .test-answer > .true').hide();
                }
                $parentStep.find('.test-answer .false').show();

                setTimeout(function () {
                    $parentStep.find('[data-boolean="true"]').addClass('highlighted');
                }, 200);
            }
            $parentStep.find('.test-answer').fadeIn(250);
        }
    });

    $('.test-radio-item img').click(function () {
        $(this).siblings('input[type="radio"]').trigger('click')
    });

    $('.interactive-test .js-next-step').click(function () {
        var $parentStep = $(this).closest('.step');
        var $box = $parentStep.closest('.interactive-test-box');
        var $form = $parentStep.closest('form');
        var testScrollTop = $box.offset().top;
        var scrollIndent = 72;

        if (windowWidth <= 780) {
            scrollIndent = 24
        }

        function scrollTest() {
            $('html, body').animate({
                scrollTop: testScrollTop - scrollIndent
            }, 150);
        }

        if (!$parentStep.hasClass('final-step')) {
            if ($parentStep.hasClass('start-step')) {
                // make unique user id every start
                var user_id = $box.attr('data-uniqid') + '-' + Math.random().toString(36).substr(2, 9);
                $form.find('input[name="userId"]').val(user_id);
                var url1 = $form.attr('data-start-url');
                $.post(url1, $form.serialize(), function (data) {
                    //console.log(data);
                }, 'html');
            }

            if ($parentStep.find('input[type="radio"]:checked').length || $parentStep.hasClass('start-step')) {
                $box.removeClass('itw-middle-step itw-final-step');
                var $nextStep = $parentStep.next('.step');
                // send data, get result
                if ($nextStep.hasClass('final-step')) {
                    $form.find('.interactive-test input[type="radio"]').attr('disabled', false);
                    var url = $form.attr('action');
                    var formData = $form.serialize();
                    $.post(url, formData, function (data) {
                        $nextStep.find('.interactive-test-content').html(data);
                        formatContent($nextStep.find('.interactive-test-content > *'));
                        var true_false = $box.attr('data-true-false') === '1';
                        if (true_false) {
                            var correct_count = parseInt($box.attr('data-correct-count')) || 0;
                            var steps_count = $box.find('.step.middle-step').length;
                            if ($nextStep.find('.test-title .border-position').length) {
                                var final_title1 = $nextStep.find('.test-title .border-position').html();
                                $nextStep.find('.test-title .border-position').html('' + correct_count + '/' + steps_count + '<br>' + final_title1);
                            } else {
                                var final_title2 = $nextStep.find('.test-title').html();
                                $nextStep.find('.test-title').html('' + correct_count + '/' + steps_count + '<br>' + final_title2);
                            }
                        }
                    }, 'html').fail(function () {
                        $nextStep.find('.interactive-test-content').html('<p class="test-title">Server Error!</p>');
                    });
                    $box.addClass('itw-final-step');
                } else {
                    $box.addClass('itw-middle-step');
                }
                $parentStep.hide();
                $nextStep.show();
                scrollTest();
                resetIframes($parentStep);
            }
        } else {
            $box.removeClass('itw-middle-step itw-final-step');
            $box.attr('data-correct-count', '0');
            $parentStep.hide().siblings('.start-step').show();
            resetTests($box);
            testScrollTop = $box.offset().top;
            scrollTest();
            resetIframes($parentStep);
        }

    });

    function resetIframes($selector) {
        $selector.find('iframe').each(function () {
            $(this).replaceWith($(this).clone());
        });
    }

});
