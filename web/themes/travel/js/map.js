jQuery(function ($) {

    var isTouch = ('ontouchstart' in document.documentElement);

    /* popup slider */
    var objectImgSlider;
    function objectImgSliderInit(){
        $('.object-img-slider .swiper-container').each(function(){
            var loop = true;
            if($(this).find('.swiper-slide').length <= 1){
                loop = false;
                $(this).parents('.object-img-slider').addClass('disabled').find('.swiper-wrapper').addClass('disabled');
            }
            // var $thisParent = $('.object-img-slider')
            objectImgSlider = new Swiper($(this)[0], {
                slidesPerView: 'auto',
                centeredSlides: true,
                watchSlidesVisibility: true,
                observer: true,
                loop: loop,
                lazy: {
                    loadPrevNext: true,
                    loadOnTransitionStart: true
                },
                navigation: {
                    nextEl: $(this).parents('.object-img-slider').find('.next-btn'),
                    prevEl: $(this).parents('.object-img-slider').find('.prev-btn')
                }
            });
        });
        setTimeout(function(){
            window.dispatchEvent(new Event('resize'));
        }, 50);
    }

    // Options
    var options = {
        //center: [49.260038, 31.352247],
        //center: [53.8843, 27.3132],
        center: [$(".map-box #map").attr('data-lat'), $(".map-box #map").attr('data-lng')],
        zoom: 7,
        minZoom: 2,
        zoomAnimation: false,
        scrollWheelZoom: false,
        fullscreenControl: true,
        tap: false
    };

    // New map
    var map = new L.Map('map', options);

    var osm = new L.TileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    });

    var CartoDB_Positron = L.tileLayer('https://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}{r}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors &copy; <a href="https://carto.com/attributions">CARTO</a>',
        subdomains: 'abcd',
        maxZoom: 19
    });

    map.addLayer(CartoDB_Positron);

    L.control.locate({
        drawCircle: false
    }).addTo(map);

    /*if (!isTouch) {
        map.touchExtend.disable();
    }*/

    var navyBlueIcon = L.icon({
        iconUrl: 'assets/markers/navy-blue.png',
        shadowUrl: 'assets/markers/shadow.png',

        iconSize: [17, 28],
        shadowSize: [18, 19],
        iconAnchor: [9, 28],
        shadowAnchor: [0, 19],
        popupAnchor: [0, -30]
    });

    var LeafIcon = L.Icon.extend({
        options: {
            iconSize: [30, 44],
            iconAnchor: [15, 36],
            popupAnchor: [108, -28]
        }
    });
    
    var markers = L.layerGroup().addTo(map);

    function parsePlacePopup(res) {
        var newPlacePopup = res.features;

        $.each(newPlacePopup, function(i, item){
            var popup = '',
                title = '',
                coordinates = '',
                description = '',
                // linkOne = '',
                // linkTwo = '',
                popupLink = '',
                links = '',
                className = '',
                objectImgSlide = '',
                imgSlider = '',
                iconImg = '';

            if (item.properties.title) {
                title = '<p class="title">' + item.properties.title + '</p>';
            }
            if (item.properties.coordinates) {
                coordinates = '<span class="coordinates">' + item.properties.coordinates + '</span>';
            }
            if (item.properties.description) {
                description = '<p class="text">' + item.properties.description + '</p>'
            }
            if(item.properties.objectImgSlider){
                $.each(item.properties.objectImgSlider, function(i, item){
                    objectImgSlide += '<div class="swiper-slide"><img src="'+ item +'" /></div>';
                });
            }

            if(item.properties.objectImgSlider) {
                imgSlider = '<div class="object-img-slider"><div class="swiper-container"><div class="swiper-wrapper">'+objectImgSlide+'</div></div><span class="swiper-btn prev-btn"><svg width="6" height="14" viewBox="0 0 6 14" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M3.0598e-07 7L6 13.0622L6 0.937822L3.0598e-07 7Z" fill="white"/></svg></span><span class="swiper-btn next-btn"><svg width="6" height="14" viewBox="0 0 6 14" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M6 7L-9.41288e-08 13.0622L4.35844e-07 0.937822L6 7Z" fill="white"/></svg></span></div>'
            }

            if (item.properties.links) {
                $.each(item.properties.links, function(i, item){
                    popupLink += '<a target="_blank" href="' + item.href + '" class="link"><span>' + item.text + '</span><span class="icon"><svg width="26" height="7" viewBox="0 0 26 7" fill="none" xmlns="http://www.w3.org/2000/svg"><line y1="3.5" x2="24" y2="3.5" stroke="black"/><path d="M26 3.5L22.25 6.53109L22.25 0.468911L26 3.5Z" fill="black"/></svg></span></a>'
                })
            }
            if(item.properties.links) {
                links = '<div class="links">'+ popupLink +'</div>'
            }

            iconImg = '<img src="'+ item.options.pinUrl +'" class="pin-img" />'
            className = item.properties.stylePopup;
            
            popup = title + coordinates + description + imgSlider + links + iconImg;

            var icon = new LeafIcon({iconUrl: item.options.pinUrl});
            
            
            // L.marker( item.geometry.coordinates, {icon: icon} ).bindPopup(popup, {
            //     minWidth: 212,
            //     maxWidth: 212,
            //     className: className
            // }).addTo( map )

            var marker = L.marker( item.geometry.coordinates, {icon: icon} );
            marker.bindPopup(popup, {
                minWidth: 212,
                maxWidth: 212,
                className: className
            });
            marker.addTo(markers);
            //markers.addLayer(marker);
        });
    }

    //map.addLayer(markers);
    
    function getPins(type) {
        var url = $(".map-box #map").attr('data-url');
        if (url) {
            if (type) url += '?type=' + type;
            $.getJSON(url, function(data){
                parsePlacePopup(data);
            });
        }
    }

    $(".filter-form input[type=checkbox]").on('click', function (e) {
        markers.clearLayers();
        getPins($(this).attr('data-type'));
    });
    
    getPins();

    $('body').on('click', '.leaflet-marker-icon', function(){
        if($('.object-img-slider').length) {
            objectImgSliderInit()
        }
    })  
    
});
