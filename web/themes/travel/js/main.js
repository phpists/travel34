jQuery(function ($) {

    if ('FastClick' in window) {
        FastClick.attach(document.body);
    }

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

    // label activ'e
    $(".b-header__open-menu").click(function () {
        $("body").removeClass('active');
        $(".b-header__open-search").removeClass('active');
        $(".b-header__search").fadeOut('fast');

        $("body").toggleClass('active');
        $(this).toggleClass('active');
        $(".b-header__menu").fadeToggle('fast');
        return false;
    });

    // label activ'e
    $(".b-header__open-search").click(function () {

        $("body").removeClass('active');
        $(".b-header__open-menu").removeClass('active');
        $(".b-header__menu").fadeOut('fast');

        $("body").toggleClass('active');
        $(this).toggleClass('active');
        $(".b-header__search").fadeToggle('fast');
        return false;
    });

    var popID = $('.b-panorama__title');
    var popMargTop = ($(popID).height() - 100) / 2;
    $(popID).css({
        'padding-top': popMargTop
    });

    $('.index-page .b-main').addClass('already-done');

    $('body').on('click', '.show-more-home-posts', function (e) {
        e.preventDefault();
        var $element = $(this);
        var $postsContainter = $element.closest('.b-main');
        var moreUrl = $element.data('url');
        $element.hide();
        $element.parents('.b-nav').find('.more-waiting').css('display', 'block');
        $.post(moreUrl, function (data) {
            $element.parents('.b-nav').remove();
            $postsContainter.after(data);
            var new_count = $('.b-main:not(.already-done)').length, already_loaded = 0;
            $('.b-main:not(.already-done)').addClass('current-loading');
            $('.b-main:not(.already-done)').each(function () {
                var $el = $(this);
                $el.addClass('already-done');
                $el.imagesLoaded().always(function () {
                    already_loaded++;
                    if (already_loaded == new_count) {
                        windowWidth = Math.max($(window).width(), window.innerWidth);
                        if(windowWidth > 1230) {
                            createGrid(4, '.index-page .b-main.current-loading .b-news__short__list', true);
                        } else if(windowWidth > 990) {
                            createGrid(3, '.index-page .b-main.current-loading .b-news__short__list', true);
                        } else {
                            createGrid(2, '.index-page .b-main.current-loading .b-news__short__list', true);
                        }
                        $('.current-loading').removeClass('current-loading');
                        equalheight('.index-page .b-main.current-loading .b-news__short__block');
                        $(window).trigger('resize')
                    }
                });
            });
        });
    });

    $('body').on('click', '.show-more-posts', function (e) {
        e.preventDefault();
        var $element = $(this);
        var $postsContainter = $element.closest('.additional-posts');
        var moreUrl = $element.data('url');
        $element.hide();
        $element.parents('.b-nav').find('.more-waiting').css('display', 'block');
        $.post(moreUrl, function (data) {
            $element.parents('.b-nav').remove();
            $postsContainter.append(data);
        });
    });

    // Cache selectors
    var lastId,
        topMenu = $(".b-panorama"),
        topMenuHeight = topMenu.outerHeight(),
        // All list items
        menuItems = topMenu.find('a[href^="#"]'),
        // Anchors corresponding to menu items
        scrollItems = menuItems.map(function () {
            var href = $(this).attr("href");
            if (/^#/.test(href)) {
                var item = $(href);
                if (item.length) {
                    return item;
                }
            }
        });

    // Bind click handler to menu items
    // so we can get a fancy scroll animation
    menuItems.click(function (e) {
        var href = $(this).attr("href"),
            offsetTop = (href === "#" || href === "/") ? 0 : $(href).offset().top - 35;
        $('html, body').stop().animate({
            scrollTop: offsetTop
        }, 300);
        e.preventDefault();
    });

    // Bind to scroll
    $(window).scroll(function () {
        // Get container scroll position
        var fromTop = $(this).scrollTop() + topMenuHeight;

        // Get id of current scroll item
        var cur = scrollItems.map(function () {
            if ($(this).offset().top < fromTop)
                return this;
        });
        // Get the id of the current element
        cur = cur[cur.length - 1];
        var id = cur && cur.length ? cur[0].id : "";

        if (lastId !== id) {
            lastId = id;
            // Set/remove active class
            menuItems
                .parent().removeClass("active")
                .end().filter('[href="#' + id + '"]').parent().addClass("active");
        }
    });

    // Find all YouTube videos
    var $allVideos = $("iframe.full-width-youtube"),
        // The element that is fluid width
        $fluidEl = $(".b-post");

    // Figure out and save aspect ratio for each video
    $allVideos.each(function () {

       /* $(this)
            .data('aspectRatio', this.height / this.width)
            // and remove the hard coded width/height
            .removeAttr('height')
            .removeAttr('width');*/
       $(this).removeAttr('height').removeAttr('width').wrap('<div class="videoWrapper"></div>')
    });

    //go up button
    $('.goUp').click(function () {
        $('html, body').animate({
            scrollTop: 0
        }, 500);
    });

    $('ul.tabs__caption').on('click', 'li:not(.active)', function () {
        $(this)
            .addClass('active').siblings().removeClass('active')
            .closest('div.b-page__content__tabs').find('div.tabs__content').removeClass('active').eq($(this).index()).addClass('active');
    });

    /*Footer*/
    function stickyFooter(){
        $('footer').css('marginTop', - $('footer').height());
        $('#indent').css('paddingBottom', $('footer').height());
    }
    /*______*/

    /*Equal height*/
    var equalheight = function(container){
        var currentTallest = 0,
            currentRowStart = 0,
            rowDivs = [],
            $el;
        $(container).each(function() {
            $el = $(this);
            $($el).height('auto');
            var topPostion = $el.position().top, currentDiv;

            if (currentRowStart != topPostion) {
                for (currentDiv = 0 ; currentDiv < rowDivs.length ; currentDiv++) {
                    rowDivs[currentDiv].height(currentTallest);
                }
                rowDivs.length = 0; // empty the array
                currentRowStart = topPostion;
                currentTallest = $el.height();
                rowDivs.push($el);
            } else {
                rowDivs.push($el);
                currentTallest = (currentTallest < $el.height()) ? ($el.height()) : (currentTallest);
            }
            for (currentDiv = 0 ; currentDiv < rowDivs.length ; currentDiv++) {
                rowDivs[currentDiv].height(currentTallest);
            }
        });
    };
    /*_________*/

    function rebuildGrid(initial) {
        if(windowWidth > 1230 && !bigDesktopGrid) {
            createGrid(4, false, initial)
        }
        else if(windowWidth < 1231 && windowWidth > 990 && !mediumDesktopGrid) {
            createGrid(3, false, initial)
        }
        else if(windowWidth < 991 && !smallDesktopGrid) {
            createGrid(2, false, initial)
        }
    }

    $(window).load(function(){
        rebuildGrid(true);
        equalheight('.index-page .b-news__short__block');
    });

    $(window).resize(function () {
        windowWidth = Math.max($(window).width(), window.innerWidth);
        waitForFinalEvent(function(){
            stickyFooter();
            rebuildGrid();
            equalheight('.index-page .b-news__short__block');
            fullWidthBox();
            fullWidthBoxOld();
        }, 50);
    });

    $(window).on('orientationchange', function(){
        stickyFooter();
        fullWidthBox();
        fullWidthBoxOld();
    });

    $('#wrapper').click(function(){
        $('.country-select').removeClass('visible');
        $('.user-menu-box').removeClass('visible');
        $('html').removeClass('menu-open, search-visible');
    });

    $('.country-select, .search, .open-user-menu').click(function(e){
        e.stopPropagation();
    });

    $('.search-form').click(function(e){
        e.stopPropagation();
    })

    $('.open-search').click(function(){
        if(!$('html').hasClass('search-visible')) {
            $('html').addClass('search-visible').removeClass('menu-open').find('.search-form input[type="text"]').focus();
            $('.user-menu-box').removeClass('visible');
        }
        else {
            $('html').removeClass('search-visible');
        }
    });

    $('.close-form').click(function(){
        $(this).closest('.search-box').removeClass('visible');
    });

    $('.country-select p').click(function(){
        if(!$(this).closest('.country-select').hasClass('visible')) {
            $(this).closest('.country-select').addClass('visible');
        }
        else {
            $(this).closest('.country-select').removeClass('visible');
        }
    });

    $('.open-user-menu').click(function(){
        if(!$(this).closest('.user-menu-box').hasClass('visible')) {
            $(this).closest('.user-menu-box').addClass('visible');
            $('html').removeClass('menu-open search-visible');
        }
        else {
            $(this).closest('.user-menu-box').removeClass('visible');
        }
    });

    $('.menu-btn').click(function (e) {
        e.stopPropagation();
        e.preventDefault();
        if(!$('html').hasClass('menu-open')) {
            $('html').addClass('menu-open').removeClass('search-visible');
            $('.user-menu-box').removeClass('visible');
        }
        else {
            $('html').removeClass('menu-open');
            $('.has-child').removeClass('visible');
        }
    });

    $('.menu-panel').click(function(e){
        e.stopPropagation();
    });
    var bigDesktopGrid = false;
    var mediumDesktopGrid = false;
    var smallDesktopGrid = false;

    function createGrid(perRow, selector, initial){
        selector = selector || '.index-page .b-news__short__list';
        initial = initial || false;
        if(perRow == 4 ) {
            bigDesktopGrid = true;
            mediumDesktopGrid = false;
            smallDesktopGrid = false;
        }
        else if(perRow == 3 ) {
            bigDesktopGrid = false;
            mediumDesktopGrid = true;
            smallDesktopGrid = false;
        }
        else if (perRow == 2) {
            bigDesktopGrid = false;
            mediumDesktopGrid = false;
            smallDesktopGrid = true;
        }
        if (perRow == 4 && initial) {
            return;
        }
        $(selector).each(function(){
            var $this = $(this);
            var postsObject = {
                smallPosts: [],
                mediumPosts: [],
                setMediumPost: function(box){
                    box.append(this.mediumPosts[0]);
                    this.mediumPosts.splice(0, 1);
                },
                setSmallPost: function(box){
                    box.append(this.smallPosts[0]);
                    this.smallPosts.splice(0, 1);
                }
            };
            var postsArray = $(this).children('div');
            for (var i = 0; i < postsArray.length; i++) {
                if($(postsArray[i]).hasClass('b-col__2')){
                    postsObject.mediumPosts.push($(postsArray[i]));
                }
                else if($(postsArray[i]).hasClass('b-col__1')){
                    postsObject.smallPosts.push($(postsArray[i]));
                }
            }
            var lastMediumPost = false;
            $(this).empty();
            while(postsObject.smallPosts.length || postsObject.mediumPosts.length) {
                equalheight('.index-page .b-news__short__block');
                var postInRow = perRow;
                for (var j = 0; j < perRow; j++) {
                    if(perRow > 2) {
                        if (lastMediumPost) {
                            if (postsObject.mediumPosts.length > 0) {
                                postsObject.setMediumPost($this);
                                postInRow = postInRow - 2;
                            }
                            else {
                                if (postsObject.smallPosts.length) {
                                    postsObject.setSmallPost($this);
                                    postInRow = postInRow - 1;
                                }
                            }
                            lastMediumPost = false;
                        }
                        else {
                            if (postInRow == 2) {
                                if (postsObject.mediumPosts.length > 0) {
                                    postsObject.setMediumPost($this);
                                    postInRow = postInRow - 2;
                                    lastMediumPost = true;
                                }
                                else {
                                    postsObject.setSmallPost($this);
                                    postInRow = postInRow - 1;
                                }
                            }
                            else if (postsObject.smallPosts.length) {
                                postsObject.setSmallPost($this);
                                postInRow = postInRow - 1;
                            }
                        }
                    }
                    else if (perRow <= 2){
                        if (lastMediumPost) {
                            if (postsObject.smallPosts.length) {
                                postsObject.setSmallPost($this);
                                postsObject.setSmallPost($this);
                                postInRow = postInRow - 2;
                                lastMediumPost = false;
                            }
                            else {
                                postsObject.setMediumPost($this);
                                postInRow = postInRow - 2;
                                lastMediumPost = true;
                            }
                        }
                        else {
                            if (postsObject.mediumPosts.length > 0) {
                                postsObject.setMediumPost($this);
                                postInRow = postInRow - 2;
                                lastMediumPost = true;
                            }
                            else {
                                if (postsObject.smallPosts.length) {
                                    postsObject.setSmallPost($this);
                                    postInRow = postInRow - 2;
                                    lastMediumPost = false;
                                }
                            }
                        }
                    }
                    if (postInRow === 0) {
                        break;
                    }
                }
            }
        });
        $(window).trigger('resize')
    }

    $('.open-hidden-content').on('click', function (e) {
        e.preventDefault();
        e.stopPropagation();
        $(this).closest('.hidden-content-wrapper').addClass('visible');
    });

    $('.close-hidden-content').on('click', function (e) {
        e.preventDefault();
        e.stopPropagation();
        var $this= $(this);
        $this.closest('.hidden-content-wrapper').removeClass('visible');
        $('html, body').animate({
            scrollTop: $this.closest('.hidden-content-wrapper').offset().top
        }, 500);
    });

    // JS FROM GTB

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
            $(this).css({
                marginLeft: -(docWidth - $('.post-body .container').width()) / 2,
                marginRight: -(docWidth - $('.post-body .container').width()) / 2
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

    if($('.banner-new').length){
        $('.banner-new').parents('.b-news__short__list').css('overflow', 'visible');
        $('.banner-new').parents('.banner').addClass('full-width');
    }

});
