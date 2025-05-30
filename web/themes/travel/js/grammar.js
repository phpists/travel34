jQuery(function ($) {
    var ctrlDown = false, enterDown = false, popupDisplayed = false;
    var serverScript = "/site/grammar";

    var popupMarkup = '\
        <style type="text/css">\
            #grammar-popup-wrapper,#grammar-popup-wrapper *{-webkit-box-sizing:border-box;-moz-box-sizing:border-box;box-sizing:border-box}\
            #grammar-popup-wrapper{position:fixed;z-index:65000}\
            #grammar-popup{background:white;border:1px solid #000;width:440px}\
            #grammar-popup .gr-form-border{padding:10px}\
            #grammar-popup .gr-title,#grammar-popup .gr-url,#grammar-popup .gr-text{font-family:"PT Serif","Times New Roman",serif;text-transform:none}\
            #grammar-popup .gr-title{font-weight:bold;font-size:20px;margin-bottom:10px}\
            #grammar-popup .gr-url{margin-bottom:10px;font-weight:bold;color:blue}\
            #grammar-popup .gr-text{margin-bottom:10px}\
            #grammar-popup .gr-comment{margin-bottom:10px}\
            #grammar-popup .gr-comment textarea{width:100%;padding: 5px;overflow-y:auto;resize:vertical;border:1px solid gray}\
            #grammar-popup .gr-comment textarea.gr-error{border-color:red}\
            #grammar-popup .gr-buttons button{height:25px;cursor:pointer;padding:0 10px;font-size:13px}\
            #grammar-popup .gr-header-bar{height:25px;background:black}\
            #grammar-popup .gr-close-button{font:20px Arial,sans-serif;float:right;width:25px;height:25px;line-height:23px;cursor:pointer;color:white;text-align:center}\
        </style>\
        <div id="grammar-popup-wrapper">\
            <div id="grammar-popup">\
                <div class="gr-header-bar"><span class="gr-close-button" title="Закрыть">&times;</span></div>\
                <div class="gr-form-border">\
                    <div class="gr-title">Я хочу сообщить об ошибке на странице:</div>\
                    <div class="gr-url"><!-- URL --></div>\
                    <div class="gr-text"><!-- TEXT --></div>\
                    <div class="gr-comment"><textarea rows="4" cols="49" name="comment"></textarea></div>\
                    <div class="gr-buttons">\
                        <button type="button" class="gr-send-button">Отправить</button>\
                        <button type="button" class="gr-cancel-button">Отменить</button>\
                    </div>\
                </div>\
            </div>\
        </div>';

    var okMessageMarkup = '\
        <div class="gr-header-bar"><span class="gr-close-button" title="Закрыть">&times;</span></div>\
        <div class="gr-form-border">\
            <div class="gr-title">Спасибо, ваше сообщение принято.</div>\
            <div class="gr-buttons"><button type="button" class="gr-cancel-button">OK</button></div>\
        </div>';

    var errorMessageMarkup = '\
        <div class="gr-header-bar"><span class="gr-close-button" title="Закрыть">&times;</span></div>\
        <div class="gr-form-border">\
            <div class="gr-title">Произошла ошибка при отправке сообщения.</div>\
            <div class="gr-buttons"><button type="button" class="gr-cancel-button">OK</button></div>\
        </div>';

    var getText = function () {
        if (window.getSelection) {
            return window.getSelection().toString();
        } else {
            return document.selection.createRange().text;
        }
    };

    var closeForm = function () {
        $("#grammar-popup-wrapper").remove();
        popupDisplayed = false;
    };

    var showOKMessage = function () {
        $("#grammar-popup").html(okMessageMarkup).find('.gr-cancel-button, .gr-close-button').click(closeForm);
    };

    var showErrorMessage = function () {
        $("#grammar-popup").html(errorMessageMarkup).find('.gr-cancel-button, .gr-close-button').click(closeForm);
    };

    var processForm = function (event) {
        var text = getText().slice(0, 100);

        if (!popupDisplayed && ctrlDown && enterDown && text.replace(/ /g, '') != '') {
            event.preventDefault();

            ctrlDown = false;
            enterDown = false;

            popupDisplayed = true;

            $('body').prepend(
                popupMarkup
                    .replace(/<!-- URL -->/g, window.location.href)
                    .replace(/<!-- TEXT -->/g, '...' + text + '...')
            );

            var $wrapper = $("#grammar-popup-wrapper");
            var $popup = $("#grammar-popup");

            $wrapper.css({
                top: ($(window).height() / 2 - $wrapper.height() / 2) + "px",
                left: ($(window).width() / 2 - $wrapper.width() / 2) + "px"
            });

            $popup.find('textarea[name="comment"]').focus(function () {
                $(this).removeClass('gr-error');
            });

            $popup.find('.gr-cancel-button, .gr-close-button').click(closeForm);

            $popup.find('.gr-send-button').click(function () {
                var commentText = $popup.find('textarea[name="comment"]').val();
                if (commentText == '') {
                    $popup.find('textarea[name="comment"]').addClass('gr-error');
                } else {
                    $.post(serverScript, {
                        url: window.location.href,
                        text: text,
                        comment: $popup.find('textarea[name="comment"]').val()
                    }, function (data) {
                        if (data.status == 'ok') {
                            showOKMessage();
                        } else {
                            showErrorMessage();
                        }
                    }, 'json').fail(function () {
                        showErrorMessage();
                    });
                }
            });
        }
    };

    $(document).keydown(function (event) {
        if (event.keyCode == '13')
            enterDown = true;
        if (event.keyCode == '17')
            ctrlDown = true;
        processForm(event);
    });

    $(document).keyup(function (event) {
        if (event.keyCode == '13')
            enterDown = false;
        if (event.keyCode == '17')
            ctrlDown = false;
        processForm(event);
    });
});