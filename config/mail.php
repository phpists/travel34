<?php

return [
    'viewPath' => 'application.views.frontend.mail',
    'layoutPath' => 'application.views.frontend.layouts',
    'baseDirPath' => 'webroot.media.mail',
    'savePath' => 'webroot.assets.mail',
    'testMode' => false,
    'layout' => 'mail',
    'CharSet' => 'UTF-8',
    'XMailer' => '',
    // SMTP
    //'Mailer' => 'smtp',
    //'Host' => 'smtp.gmail.com',
    //'Port' => 587,
    //'SMTPSecure' => 'tls',
    //'SMTPAuth' => true,
    //'Username' => 'noreply34travel@gmail.com',
    //'Password' => 'df0-ghk_jn34',
    'components' => [
        'mailer' => [
            'class' => 'application.extensions.mailer.YiiMailer',
            'Host' => 'smtp.beget.com',
            'Username' => '34t@farbatest.com',
            'Password' => 'rZkOvSS1nyx*',
            'Port' => 465,
            'SMTPAuth' => true,
            'SMTPSecure' => 'ssl',
        ],
    ],
];
