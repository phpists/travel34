jQuery(function ($) {

    FastClick.attach(document.body);

    var navU = navigator.userAgent;
    // Android Mobile
    var isAndroidMobile = navU.indexOf('Android') > -1 && navU.indexOf('Mozilla/5.0') > -1 && navU.indexOf('AppleWebKit') > -1;
    // Apple webkit
    var regExAppleWebKit = new RegExp(/AppleWebKit\/([\d.]+)/);
    var resultAppleWebKitRegEx = regExAppleWebKit.exec(navU);
    var appleWebKitVersion = (resultAppleWebKitRegEx === null ? null : parseFloat(regExAppleWebKit.exec(navU)[1]));
    // Chrome
    var regExChrome = new RegExp(/Chrome\/([\d.]+)/);
    var resultChromeRegEx = regExChrome.exec(navU);
    var chromeVersion = (resultChromeRegEx === null ? null : parseFloat(regExChrome.exec(navU)[1]));
    // Native Android Browser
    var isAndroidBrowser = isAndroidMobile && (appleWebKitVersion !== null && appleWebKitVersion < 537) || (chromeVersion !== null && chromeVersion < 37);

    var windowWidth = Math.max($(window).width(), window.innerWidth),
        $root = $('html');
    if (isAndroidBrowser) {
        $root.addClass('stock-android')
    }
    var waitForFinalEvent = (function () {
        var timer = 0;
        return function (callback, ms) {
            clearTimeout(timer);
            timer = setTimeout(callback, ms);
        };
    })();

    /*Footer*/
    function stickyFooter() {
        var footerEl = $('footer');
        footerEl.css('marginTop', -footerEl.height());
        $('#indent').css('paddingBottom', footerEl.height());
    }

    /*______*/

    /*Equal height*/
    var equalheight = function (container) {
        var currentTallest = 0,
            currentRowStart = 0,
            rowDivs = [],
            $el,
            topPosition = 0;
        $(container).each(function () {
            $el = $(this);
            $($el).height('auto');
            topPosition = $el.position().top;
            var currentDiv;

            if (currentRowStart != topPosition) {
                for (currentDiv = 0; currentDiv < rowDivs.length; currentDiv++) {
                    rowDivs[currentDiv].height(currentTallest);
                }
                rowDivs.length = 0; // empty the array
                currentRowStart = topPosition;
                currentTallest = $el.height();
                rowDivs.push($el);
            } else {
                rowDivs.push($el);
                currentTallest = (currentTallest < $el.height()) ? ($el.height()) : (currentTallest);
            }
            for (currentDiv = 0; currentDiv < rowDivs.length; currentDiv++) {
                rowDivs[currentDiv].height(currentTallest);
            }
        });
    };
    /*_________*/


    $(window).load(function () {
        stickyFooter();
        equalheight('.equal');
    });

    $(window).resize(function () {
        windowWidth = Math.max($(window).width(), window.innerWidth);
        waitForFinalEvent(function () {
            stickyFooter();
            fullHeight();
            fullWidthBox();
            fullWidthBoxOld();
            equalheight('.equal');
        }, 50);
    });

    $(window).on('orientationchange', function () {
        stickyFooter();
        fullHeight();
        fullWidthBox();
        fullWidthBoxOld();
        equalheight('.equal');
    });

    $('#wrapper').click(function () {
        $root.removeClass('search-visible');
        $('.has-child').removeClass('nav-visible');
    });

    $('.search-box, .search-form, nav').click(function (e) {
        e.stopPropagation();
    });

    $('header nav > ul > li').each(function () {
        if ($(this).find('ul').length > 0) {
            $(this).addClass('has-child').append('<i class="arrow"></i>')
        }
    });

    $('nav').on('click', '.has-child > a, .has-child .arrow', function (e) {
        if (!$root.hasClass('desktop') || ($root.hasClass('desktop') && windowWidth < 960)) {
            e.preventDefault();
            e.stopPropagation();
            if (!$(this).parent().hasClass('nav-visible')) {
                $('.has-child').removeClass('nav-visible');
                $(this).parent().addClass('nav-visible');
            } else {
                $(this).parent().removeClass('nav-visible');
            }
        }
    });

    $('.open-search').click(function () {
        if (!$root.hasClass('search-visible')) {
            $root.addClass('search-visible').removeClass('menu-open').find('.search-form input[type="text"]').focus();
            $('.user-menu-box').removeClass('visible');
        } else {
            $root.removeClass('search-visible');
        }
    });

    $('.close-form').click(function () {
        $(this).closest('.search-box').removeClass('visible');
    });

    function fullHeight() {
        $('.full-height').each(function () {
            if ($('.full-height').hasClass('post-title-box') && $('body').hasClass('boxed')) {
                $(this).height($(window).height() * 75 / 100)
            }
            else {
                $(this).height($(window).height())
            }
        })
    }

    fullHeight();

    var slidePadding = '25%';
    if ($('body').hasClass('boxed')) {
        slidePadding = '15%'
    }

    $('.simple-slider .slider').slick({
        slidesToShow: 1,
        adaptiveHeight: true,
        slidesToScroll: 1
    }).on('afterChange breakpoint beforeChange', function (event, slick, currentSlide, nextSlide) {
        $(this).parents('.simple-slider').find('.current-slide-num').html(slick.currentSlide + 1);
    });

    $('.slider-with-part .slider').slick({
        slidesToShow: 1,
        slidesToScroll: 1,
        centerMode: true,
        centerPadding: slidePadding,
        dots: false,
        infinite: true,
        responsive: [
            {
                breakpoint: 1024,
                settings: {
                    centerPadding: '15%'
                }
            },
            {
                breakpoint: 640,
                settings: {
                    slidesToShow: 1,
                    adaptiveHeight: true,
                    slidesToScroll: 1,
                    centerMode: false
                }
            }
        ]
    }).on('afterChange breakpoint beforeChange', function (event, slick, currentSlide, nextSlide) {
        $(this).parents('.slider-with-part').find('.current-slide-num').html(slick.currentSlide + 1);
    });

    function fullWidthBox() {
        if (!$('.post-body').length) {
            return;
        }
        var docWidth = 0;
        if (!$root.find('body').hasClass('boxed')) {
            docWidth = $(window).width();
        } else {
            docWidth = $('.post-body').innerWidth();
        }
        $('.full-width-box').each(function () {
            var contWidth = $(this).parent('.container').width();
            $(this).css({
                marginLeft: -(docWidth - contWidth) / 2,
                marginRight: -(docWidth - contWidth) / 2
            })
        });
    }

    fullWidthBox();

    function fullWidthBoxOld() {
        if (!$('.b-post').length) {
            return;
        }
        var docWidth = 0;
        if (!$root.find('body').hasClass('boxed')) {
            docWidth = $(window).width();
        } else {
            docWidth = $('.b-post').width();
        }
        $('.full-width-box').each(function () {
            $(this).css({
                marginLeft: -(docWidth - $('.b-post__text').width()) / 2,
                marginRight: -(docWidth - $('.b-post__text').width()) / 2
            })
        });
    }

    fullWidthBoxOld();

    function createSlideCounter(box) {
        var totalSlides = box.find('.slide:not(.slick-cloned)').length,
            curIndex = parseInt(box.find('.slick-current').attr('data-slick-index')) + 1;
        box.find('.counter').html('<span class="current-slide-num">' + curIndex + '</span>' + ' / ' + totalSlides);
    }

    $('.slider-with-part, .simple-slider').each(function () {
        createSlideCounter($(this));
    });

    $('.toggle-autoplay').on('click', function () {
        if (!$(this).hasClass('playing')) {
            $(this).addClass('playing').closest('.slider-with-part').find('.slider').slick('slickPlay');
        } else {
            $(this).removeClass('playing').closest('.slider-with-part').find('.slider').slick('slickPause');
        }
    });

    //go up button
    $('.goUp').click(function () {
        $('html, body').animate({
            scrollTop: 0
        }, 500);
    });

    var $allVideos = $("iframe.full-width-youtube");
    $allVideos.each(function () {
        $(this).removeAttr('height').removeAttr('width').wrap('<div class="videoWrapper"></div>')
    });

    $('body').on('click', '.show-more-gtb-home-posts', function (e) {
        e.preventDefault();
        var $element = $(this);
        var $postsContainter = $element.closest('main');
        var moreUrl = $element.data('url');
        $element.hide();
        $element.parents('.b-nav').find('.more-waiting').css('display', 'block');
        $.post(moreUrl, function (data) {
            $element.parents('.b-nav').remove();
            $postsContainter.append(data);
            $postsContainter.imagesLoaded().always(function () {
                equalheight('.equal');
            });
        });
    });

    $('body').on('click', '.show-more-gtb-posts', function (e) {
        e.preventDefault();
        var $element = $(this);
        var $postsContainter = $element.closest('.additional-posts');
        var moreUrl = $element.data('url');
        $element.hide();
        $element.parents('.b-nav').find('.more-waiting').css('display', 'block');
        $.post(moreUrl, function (data) {
            $element.parents('.b-nav').remove();
            $postsContainter.append(data);
            $postsContainter.imagesLoaded().always(function () {
                equalheight('.equal');
            });
        });
    });

});
