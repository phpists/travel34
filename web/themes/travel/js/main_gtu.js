jQuery(function ($) {

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
    if(isAndroidBrowser) {
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
    function stickyFooter(){
        var footerEl = $('#footer');
        footerEl.css('marginTop', - footerEl.height());
        $('#indent').css('paddingBottom', footerEl.height());
    }
    /*______*/

    /*Equal height*/
    // var equalheight = function(container){
    //     var currentTallest = 0,
    //         currentRowStart = 0,
    //         rowDivs = [],
    //         $el,
    //         topPosition = 0;
    //     $(container).each(function() {
    //         $el = $(this);
    //         $($el).height('auto');
    //         topPosition = $el.position().top;
    //         var currentDiv;

    //         if (currentRowStart != topPosition) {
    //             for (currentDiv = 0 ; currentDiv < rowDivs.length ; currentDiv++) {
    //                 rowDivs[currentDiv].height(currentTallest);
    //             }
    //             rowDivs.length = 0; // empty the array
    //             currentRowStart = topPosition;
    //             currentTallest = $el.height();
    //             rowDivs.push($el);
    //         } else {
    //             rowDivs.push($el);
    //             currentTallest = (currentTallest < $el.height()) ? ($el.height()) : (currentTallest);
    //         }
    //         for (currentDiv = 0 ; currentDiv < rowDivs.length ; currentDiv++) {
    //             rowDivs[currentDiv].height(currentTallest);
    //         }
    //     });
    // };
    /*_________*/


    $(window).load(function(){
        stickyFooter();
        //equalheight('.equal');
    });

    $(window).scroll(function(){
        if($(this).scrollTop() > $(window).height() && windowWidth > 1400 && $('.goUp').length){
            $('.goUp').addClass('visible');

        } else {
            $('.goUp').removeClass('visible');
        }
    });


    $(window).resize(function () {
        windowWidth = Math.max($(window).width(), window.innerWidth);
        waitForFinalEvent(function(){
            stickyFooter();
            fullHeight();
            fullWidthBox();
            //equalheight('.equal');
        }, 50);
    });

    $(window).on('orientationchange', function(){
        stickyFooter();
        fullHeight();
        fullWidthBox();
        //equalheight('.equal');
    });

    $('#wrapper').click(function(){
        $root.removeClass('search-visible');
        $('.has-child').removeClass('nav-visible');
    });

    $('.search-box, .search-form, nav').click(function(e){
        e.stopPropagation();
    });

    $('header nav > ul > li').each(function(){
        if($(this).find('ul').length > 0) {
            $(this).addClass('has-child').append('<i class="arrow"></i>')
        }
    });

    $('nav').on('click','.has-child > a, .has-child .arrow', function(e){
        if(!$root.hasClass('desktop') || ($root.hasClass('desktop') && windowWidth < 960)) {
            e.preventDefault();
            e.stopPropagation();
            if (!$(this).parent().hasClass('nav-visible')) {
                $('.has-child').removeClass('nav-visible');
                $(this).parent().addClass('nav-visible');
            }
            else {
                $(this).parent().removeClass('nav-visible');
            }
        }
    });

    $('.open-search').click(function(){
        if(!$root.hasClass('search-visible')) {
            $root.addClass('search-visible').removeClass('menu-open').find('.search-form input[type="text"]').focus();
            $('.user-menu-box').removeClass('visible');
        }
        // else {
        //     $root.removeClass('search-visible');
        // }
    });
    $('.js-close-search').click(function(){
        if($root.hasClass('search-visible')) {
            $root.removeClass('search-visible');
        }
    })

    $('.close-form').click(function(){
        $(this).closest('.search-box').removeClass('visible');
    });

    function fullHeight(){
        $('.full-height').each(function(){
            if($('.full-height').hasClass('post-title-box') && $('body').hasClass('boxed')) {
                $(this).height($(window).height()*75/100)
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
        slidesToShow    : 1,
        adaptiveHeight: true,
        slidesToScroll  : 1
    }).on('afterChange breakpoint beforeChange', function(event, slick, currentSlide, nextSlide){
        $(this).parents('.simple-slider').find('.current-slide-num').html(slick.currentSlide+1);
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
        var docWidth = 0;
        if (!$root.find('body').hasClass('boxed')) {
            docWidth = $(window).width();
        } else {
            docWidth = $('.post-body').innerWidth();
        }
        $('.full-width-box').each(function () {
            $(this).css({
                marginLeft: -(docWidth - $('.post-body > .container').width()) / 2,
                marginRight: -(docWidth - $('.post-body > .container').width()) / 2
            })
        });
    }

    fullWidthBox();

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


    var lazyLoadingFlag = false;
    $('body').on('click', ".js-show-more-articles", function (e) {
        e.preventDefault();
        if (!lazyLoadingFlag) {
            lazyLoadingFlag = true;
            var url = $(this).attr('data-url');
            var $grid = $(this).parent().find('.articles-grid');
            $(this).closest('.articles-box').addClass('loading');
            infiniteLoadArticles(url, $grid);
        }
    });


    function infiniteLoadArticles(url, articlesGrid) {
        $.ajax({
            url: url,
            dataType: 'html',
            success: function (data) {
                var $data = $('<div/>').html(data);
                $data.find('.article-item').addClass('hidden');

                $data.find('.articles-box-title').remove();

                var content = $data.find('.articles-grid').html();

                setTimeout(function () {
                    articlesGrid.append(content);

                    /*if (articlesGrid.find('.responsimg').length) {
                        $('.responsimg').responsImg();
                    }*/
                }, 500);

                setTimeout(function () {
                    var delay = .05;
                    var animation;

                    articlesGrid.find('.hidden').each(function () {
                        animation = "all .2s ease " + delay + 's';
                        $(this).css({"transition": animation});
                        delay = delay + .05;
                        $(this).removeClass('hidden');
                    });
                    articlesGrid.find('.hidden').removeClass('hidden');

                    articlesGrid.closest('.articles-box').removeClass('loading');
                    lazyLoadingFlag = false;
                }, 750);

                setTimeout(function () {
                    articlesGrid.find('.article-item').attr('style', '');
                }, 1500);

                if ($data.find('.js-show-more-articles').length) {
                    var newHref = $data.find('.js-show-more-articles').attr('data-url');
                    articlesGrid.next('.js-show-more-articles').attr('data-url', newHref);
                } else {
                    setTimeout(function () {
                        articlesGrid.next('.js-show-more-articles').hide();
                    }, 750);
                }
            },
            error: function () {
                lazyLoadingFlag = false;
                alert('Page not found!');
            }
        });
    }

    $('.js-open-nav').click(function(){
        if(!$root.hasClass('opened-nav')){
            $root.addClass('opened-nav');
            //$(this).attr('title', 'Меню');

            $('.nav > ul > li').each(function(){
                if($(this).hasClass('active') && $(this).find('.dropdown').length) {
                    $(this).addClass('opened-dropdown').find('.dropdown').show();
                }
            });
        }
        else {
            $root.removeClass('opened-nav');
            //$(this).attr('title', 'Закрыть меню');
            setTimeout(function () {
                $('.nav li').removeClass('opened-dropdown').find('.dropdown').hide();
            }, 300);
        }
    });
    $('.js-close-nav').click(function(){
        if($root.hasClass('opened-nav')){
            $root.removeClass('opened-nav');
            //$(this).attr('title', 'Закрыть меню');
            setTimeout(function () {
                $('.nav li').removeClass('opened-dropdown').find('.dropdown').hide();
            }, 300);
        }
    })


});
