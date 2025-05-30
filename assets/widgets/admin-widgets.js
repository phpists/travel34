if (typeof adminWidgets === "undefined" || !adminWidgets) {
    var adminWidgets = {};
}

adminWidgets.cdnScriptUrl = {
    ace: "https://cdnjs.cloudflare.com/ajax/libs/ace/1.4.5/ace.js"
};

adminWidgets.getCachedScript = (function ($) {
    "use strict";

    return function (url, options) {
        options = $.extend(options || {}, {
            dataType: "script",
            cache: true,
            url: url
        });
        return $.ajax(options);
    }
})(jQuery);

adminWidgets.ace = (function ($) {
    "use strict";

    var scriptUrl = adminWidgets.cdnScriptUrl.ace,
        callbacks = [],
        loading = false,
        loaded = false;

    function callPlugin(editorId, textareId, mode, theme, options) {
        var textarea = $("#" + textareId);
        var editor = ace.edit(editorId);
        editor.setTheme("ace/theme/" + theme);
        editor.getSession().setMode("ace/mode/" + mode);
        editor.getSession().setUseWrapMode(true);
        editor.setValue(textarea.val() || "", -1);
        editor.getSession().on("change", function () {
            textarea.val(editor.getSession().getValue()).trigger("change");
        });
        editor.setOptions(options);
    }

    return function (editorId, textareId, mode, theme, options) {
        if (loaded) {
            callPlugin(editorId, textareId, mode, theme, options);
        } else {
            callbacks.push({editorId: editorId, textareId: textareId, mode: mode, theme: theme, options: options});
            if (!loading) {
                loading = true;
                adminWidgets.getCachedScript(scriptUrl).done(function () {
                    loaded = true;
                    loading = false;
                    for (var i = 0; i < callbacks.length; i++) {
                        callPlugin(callbacks[i].editorId, callbacks[i].textareId, callbacks[i].mode, callbacks[i].theme, callbacks[i].options);
                    }
                });
            }
        }
    }
})(jQuery);
