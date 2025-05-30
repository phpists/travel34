<?php
return [
    'adminEmail' => '34travelby@gmail.com', // email для уведомлений
    'senderEmail' => 'info@34travel.me', // email отправителя ~(совпадает с smtp аккаунтом)~ smtp отключен
    'defaultLanguage' => 'ru',
    'rowsPerHomePage' => 12, // posts rows pers page on homepage
    'rowsPerPostPage' => 3, // additional posts rows pers page on post page
    'relatedPostsCount' => 6, // related posts count on post page
    'postsPerPage' => 15,
    'guidesPerPage' => 15,
    'newGuidesCount' => 10, // кол-во самых свежих гайдов с пометкой "new"

    'rowsPerGtbPage' => 12,
    'gtbPostsPerPage' => 12,

    'rowsPerGtuPage' => 12,
    'gtuPostsPerPage' => 12,
    'rowsPerGtuPostPage' => 2,

    'newsPerPage' => 100,

    // для геотаргетинга в админке
    'countries' => [
        'by' => 'Беларусь',
        'ua' => 'Украина',
        'other' => 'Другие страны',
    ],
    // для выбора страны в шапке
    'displayCountries' => [
        'by' => 'Беларусь',
        'ua' => 'Украина',
        'other' => 'Все страны',
    ],
    // языки для GTB
    'gtbLanguages' => [
        'ru' => 'Русский',
        'en' => 'English',
        'be' => 'Белорусский',
    ],
    'gtbMenuLanguages' => [
        'ru' => 'Rus',
        'en' => 'Eng',
        'be' => 'Bel',
    ],
    // языки для GTU
    'gtuLanguages' => [
        'uk' => 'Українська',
        'ru' => 'Русский',
        'en' => 'English',
    ],
    'gtuMenuLanguages' => [
        'uk' => 'Ukr',
        'ru' => 'Rus',
        //'en' => 'Eng',
    ],
    // типы форм заявок
    'proposalFormTypes' => [
        'roulette' => 'Рулетка приключений',
        'prior' => 'Пакеты Premium',
    ],
    // шорткоды
    'shortcodes' => [
        'interactive' => [
            //'example' => '[interactive id=1]',
            'callback' => function ($attrs) {
                $id = isset($attrs['id']) ? (int)$attrs['id'] : 0;
                return Yii::app()->controller->widget('application.widgets.InteractivePostWidget', [
                    'modelId' => $id,
                ], true);
            },
        ],
        'test' => [
            //'example' => '[test id=1]',
            'callback' => function ($attrs) {
                $id = isset($attrs['id']) ? (int)$attrs['id'] : 0;
                return Yii::app()->controller->widget('application.widgets.TestPostWidget', [
                    'modelId' => $id,
                ], true);
            },
        ],
        'with_banner' => [
            //'example' => '[with_banner][/with_banner]',
            'callback' => function ($attrs, $content) {
                $content = Shortcodes::parse($content);
                $banner = Banner::getByPlace(Banner::PLACE_IN_POST);
                if ($banner === null) {
                    return $content;
                }
                $banner_code = '';
                if (trim($banner->code) !== '') {
                    $banner_code = $banner->code;
                } elseif (trim($banner->content) !== '') {
                    $banner_code = $banner->content;
                }
                if ($banner_code === '') {
                    return $content;
                }
                //$banner_code = str_replace('params:', 'onRender:function(){ console.log(this); },params:', $banner_code);
                return '<div class="wide-box"><div class="text-with-banner"><div class="col-text">' . $content . '</div><div class="col-banner">' . $banner_code . '</div></div></div>';
            },
        ],
    ],
    'relap-body-code' => '<script type="text/javascript" async src="https://relap.io/v7/relap.js" data-relap-token="A3sD9nL2tuwRNfbz"></script>',
    'relap-news' => '<div class="js-relap-anchor" data-relap-id="Ms0yZqZmfGWf1GZm">',
    'encryptionKey' => 'user_register',
    'google' => [
        'clientId' => '508443404190-8rljssfo94gghmb7q6hctnldnar560tf.apps.googleusercontent.com',
        'clientSecret' => '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',
    ],
];
