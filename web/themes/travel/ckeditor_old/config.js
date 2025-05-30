/**
 * @license Copyright (c) 2003-2018, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see https://ckeditor.com/legal/ckeditor-oss-license
 */

CKEDITOR.editorConfig = function (config) {
    config.font_names = 'bebas_neue_regularregular/bebas_neue_regularregular;'
        + 'bebas_neuebold/bebas_neuebold;'
        + 'helioscondregular/helioscondregular;'
        + 'league_gothicregular/league_gothicregular;'
        + 'pt_serifregular/pt_serifregular;'
        + config.font_names;

    config.toolbar_Basic = [
        {'name': 'document', 'items': ['Source']},
        {'name': 'basicstyles', 'items': ['Bold', 'Italic', '-', 'RemoveFormat']},
        {'name': 'paragraph', 'items': ['NumberedList', 'BulletedList', '-', 'Outdent', 'Indent']},
        {'name': 'links', 'items': ['Link', 'Unlink']},
        {'name': 'about', 'items': ['About']}
    ];

    config.allowedContent = {
        $1: {
            elements: CKEDITOR.dtd,
            attributes: true,
            styles: true,
            classes: true
        }
    };
    // http://docs.ckeditor.com/#!/guide/dev_disallowed_content
    config.disallowedContent = 'form legend fieldset input select button acronym noembed noscript font center nobr strike;' +
        '*[align,border,longdesc,datasrc];' +
        'br[clear];' +
        'img[border]{width,height};' +
        'table[*]';

    config.entities = false;

    config.specialChars = config.specialChars.concat([
        ['&nbsp;', 'Non-breaking space'],
        ['І', 'Беларуская літара І'],
        ['і', 'Беларуская літара і'],
        ['Ў', 'Беларуская літара Ў'],
        ['ў', 'Беларуская літара ў']
    ]);

    config.removePlugins = 'bidi,flash,forms,newpage,pagebreak,print,save,scayt,smiley,wsc,exportpdf';
};

CKEDITOR.on('instanceReady', function (e) {
    // Insert &nbsp; if Ctrl+Space is pressed:
    e.editor.addCommand('insertNbsp', {
        exec: function (editor) {
            editor.insertHtml('&nbsp;');
        }
    });
    e.editor.setKeystroke(CKEDITOR.CTRL + 32, 'insertNbsp');

    // Modify HTML self-closing tags ending
    e.editor.dataProcessor.writer.selfClosingEnd = '>';
});

CKEDITOR.on('dialogDefinition', function (e) {
    var dialogName = e.data.name;
    var dialogDefinition = e.data.definition;
    if (dialogName === 'table') {
        var info = dialogDefinition.getContents('info');
        info.get('txtWidth')['default'] = '';
    }
});
