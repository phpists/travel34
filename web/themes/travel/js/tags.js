/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


var tags = {}
tags.onPageLoad = function() {
    tags.refresh();
}

tags.refresh = function() {
    var selectedType = $('.js-tags-type a.current').data('type');
    $('li[class^="js-tag"]').hide();
    $('li[class^="js-tag"]').each(function() {
        $(this).attr('data-visible', 0);
    })
    $('li.js-tag-' + selectedType).show();
    $('li.js-tag-' + selectedType).each(function(){
        $(this).attr('data-visible', 1);
    });
    
    $('.b-counties__list .b-counties__list__simple').each(function() {
        if ($(this).find('li[data-visible="1"]').length > 0) {
            $(this).show();
        } else {
            $(this).hide();
        }
    });  
    
    var selCountriesCount = $('.b-counties__cont a.current').length;
    var selAlphaCount = $('.b-counties__alph a.current').length;
    if (selCountriesCount > 0) {       
        $('.b-counties__list__alph').hide();
        $('.b-countries__list__cont').show();
        $('.b-counties__list__simple').hide();
        $('.b-counties__cont a.current').each(function(){
            var worldPartId = $(this).data('value');
            var element = $('.b-counties__list__simple[data-world-part="' + worldPartId + '"]');
            if (element.find('li[data-visible="1"]').length > 0) {
                element.show();
            }
        });
    } else if (selAlphaCount > 0 ) {
        $('.b-counties__cont a').removeClass('current');
        $('.b-countries__list__cont').hide();
        $('.b-counties__list__alph').show();
        $('.b-counties__list__simple').hide();
        $('.b-counties__alph a.current').each(function(){
            var letter = $(this).data('value');
            var element = $('.b-counties__list__simple[data-letter="' + letter + '"]');
            if (element.find('li[data-visible="1"]').length > 0) {
                element.show();
            }
        });
    }
    
}

$(function () {
    tags.onPageLoad();
    $('.js-tags-type').on('click', 'a', function () {
        $('.js-tags-type a').removeClass('current');
        $(this).addClass('current');
        tags.refresh();
    });
    $('.b-counties__cont').on('click', 'a', function () {
       $('.b-counties__alph a').removeClass('current');
       $(this).toggleClass('current');
       tags.refresh();
    });
    $('.b-counties__alph').on('click', 'a', function () {
       $('.b-counties__cont a').removeClass('current');
       $(this).toggleClass('current');
       tags.refresh();
    });
});