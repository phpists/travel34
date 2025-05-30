/**
 * Galleria Classic Theme 2012-04-04
 * http://galleria.io
 *
 * Licensed under the MIT license
 * https://raw.github.com/aino/galleria/master/LICENSE
 *
 */

(function($) {

/*global jQuery, Galleria */
Galleria.configure({
    thumbnails: false,
    imageCrop: 'height',
    _toggleInfo: false
});
Galleria.addTheme({
    name: 'classic',
    author: 'Galleria',
    css: '../css/galleria.classic.css',
    defaults: {
        transition: 'slide',
        thumbCrop:  'height',

        // set this to false if you want to show the caption all the time:
        _toggleInfo: true
    },
    init: function(options) {

        Galleria.requires(1.25, 'This version of Classic theme requires Galleria 1.2.5 or later');

        // add some elements
        this.addElement('info-link','info-close');
        this.append({
            'info' : ['info-link','info-close']
        });

        // cache some stuff
        var info = this.$('info-link,info-close,info-text'),
            touch = Galleria.TOUCH,
            click = touch ? 'touchstart' : 'click';

        // show loader & counter with opacity
        //this.$('loader,counter').show().css('opacity', 0.4);

        // some stuff for non-touch browsers
        if (! touch ) {
            //this.addIdleState( this.get('image-nav-left'), { left:-50 });
            //this.addIdleState( this.get('image-nav-right'), { right:-50 });
            //this.addIdleState( this.get('play'), { right:-50 });
            //this.addIdleState( this.get('counter'), { opacity:0 });
        }

        // toggle info
        if ( options._toggleInfo === true ) {
            info.bind( click, function() {
                info.toggle();
            });
        } else {
            info.show();
            this.$('info-link, info-close').hide();
        }

        this.bind('loadstart', function(e) {
            if (!e.cached) {
                this.$('loader').show().fadeTo(200, 0.4);
            }

            this.$('info').toggle( this.hasInfo() );

            $(e.thumbTarget).css('opacity',1).parent().siblings().children().css('opacity', 0.6);
        });

        this.bind('loadfinish', function(e) {
            this.$('loader').fadeOut(200);
        });
    }
});
Galleria.ready(function(options) {
    var gallery = this;
    $(this._dom['image-nav']).css('top', (this._height)/2);
    $(this._dom['counter']).css('top', this._height - 30);
    $(this._dom['play']).css('top', this._height - 30);
    $(this._dom['play']).click(function() {
        if (!$(this).hasClass('playing')) {
            gallery.addIdleState( gallery.get('image-nav-left'), {left:-50});
            gallery.addIdleState( gallery.get('image-nav-right'), {right:-50});
            gallery.addIdleState( gallery.get('play'), {right:-50});
            gallery.addIdleState( gallery.get('counter'), {opacity:0});
        } else {
            gallery.removeIdleState( gallery.get('image-nav-left'));
            gallery.removeIdleState( gallery.get('image-nav-right'));
            gallery.removeIdleState( gallery.get('play'));
            gallery.removeIdleState( gallery.get('counter'));
        }
        gallery.playToggle(5000);
        $(this).toggleClass('playing');
    });
    // listen to when an image is shown
    this.bind("loadfinish", function(e) {
            var infoHeight = $(this._dom['info']).height();

            $(this._dom['container']).animate({
                height: this._height + infoHeight
            }, 300, function() {
            });
    });
});
}(jQuery));
