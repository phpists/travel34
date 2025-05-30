<?php

return CMap::mergeArray(
    require(__DIR__ . '/main-' . APPLICATION_ENVIRONMENT . '.php'),
    [
        'theme' => 'travel',
        'preload' => [],
        'components' => [
            'clientScript' => [
                'packages' => [
                    'jquery' => [
                        'basePath' => 'application.assets.jquery',
                        'js' => ['jquery-2.2.4.min.js'],
                    ],
                ],
            ],
            'urlManager' => [
                'class' => 'ext.localeurls.GtbLocaleUrlManager',
                'urlFormat' => 'path',
                'showScriptName' => false,
                'rules' => [
                    '' => 'site/main',
                    'more' => 'site/more',
                    'sitemap.xml' => 'site/sitemapxml',
                    'captcha' => 'site/captcha',
                    'search' => 'search/results',
                    'feed' => 'feed/index',
                    'rss' => 'feed/index',
                    'yandexnews' => 'feed/yandex',
                    'yandexzen' => 'feed/zen',
                    'gotobelarus' => 'gtb/index',
                    'gotobelarus/todo/page/<page:\d+>' => 'gtb/todo',
                    'gotobelarus/todo' => 'gtb/todo',
                    'gotobelarus/rubric/<url:([\w-]+)>/page/<page:\d+>' => 'gtb/rubric',
                    'gotobelarus/rubric/<url:([\w-]+)>' => 'gtb/rubric',
                    'gotobelarus/post/<url:([\w-]+)>' => 'gtb/view',
                    'gotobelarus/<action:\w+>' => 'gtb/<action>',
                    'gotoukraine' => 'gtu/index',
                    'gotoukraine/todo/page/<page:\d+>' => 'gtu/todo',
                    'gotoukraine/todo' => 'gtu/todo',
                    'gotoukraine/rubric/<url:([\w-]+)>/page/<page:\d+>' => 'gtu/rubric',
                    'gotoukraine/rubric/<url:([\w-]+)>' => 'gtu/rubric',
                    'gotoukraine/post/<url:([\w-]+)>' => 'gtu/view',
                    'gotoukraine/<action:\w+>' => 'gtu/<action>',
                    'post/captcha' => 'post/captcha',
                    'post/more' => 'post/more',
                    'post/rate' => 'post/rateComment',
                    'post/<url:([\w-]+)>' => 'post/view',
                    'guides/page/<page:\d+>' => 'guide/index',
                    'guides' => 'guide/index',
                    'places/page/<page:\d+>' => 'people/index',
                    'places' => 'people/index',
                    'tags/<url:([\w-]+)>' => 'geo/view',
                    'tags' => 'geo/index',
                    'authors/<name:[ \w-]+>/page/<page:\d+>' => 'authors/view',
                    'authors/<name:[ \w-]+>' => 'authors/view',
                    'rubrics/<url:([\w-]+)>/page/<page:\d+>' => 'rubric/view',
                    'rubrics/<url:([\w-]+)>' => 'rubric/view',
                    'rubrics' => 'rubric/index',
                    'news' => 'news/index',
                    'special/<name:([\w-]+)>/page/<page:\d+>' => 'special/view',
                    'special/<name:([\w-]+)>' => 'special/view',
                    'special' => 'special/index',

                    'login' => 'login/login',
                    'login/google' => 'login/loginWithGoogle',
                    'login/oauth2callback' => 'login/Oauth2callback',
                    'login/oauth2callbackSubscriptionF1' => 'login/Oauth2callbackSubscription',
                    'login/oauth2callbackSubscriptionF2' => 'login/Oauth2callbackSubscriptionF2',
                    'registration' => 'registration/step1',
                    'registration-step-2' => 'registration/step2',
                    'logout' => 'login/logout',
                    'i-have-account' => 'login/iHaveAccount',
                    'login/register-finish' => 'login/registerFinish',

                    'profile/account' => 'profile/account',
                    'profile/subscription-family' => 'profile/subscriptionFamilyAdd',
                    'profile/subscription/canceled' => 'profile/subscriptionCanceled',
                    'profile/subscription/activate' => 'profile/subscriptionActivate',
                    'profile/subscription/promo-activate' => 'profile/subscriptionPromoActivate',
                    'profile/account-settings' => 'profile/accountSettings',
                    'profile/account-delete' => 'profile/accountDelete',
                    'profile/manage-subscriptions' => 'profile/manageSubscriptions',

                    'profile/favorites' => 'profile/favorites',
                    'profile/collections' => 'profile/collections',
                    'profile/collection/<collection_id:\d+>' => 'profile/collection',
                    'profile/add-collection' => 'profile/addCollection',
                    'profile/edit-collection' => 'profile/editCollection',
                    'profile/update-collection' => 'profile/updateCollection',
                    'profile/delete-collection/<collection_id:\d+>' => 'profile/deleteCollection',
                    'profile/add-favorite' => 'profile/addFavorite',
                    'profile/delete-collection-post/<post_id:\d+>' => 'profile/deleteCollectionPost',
                    'profile/add-favorite-from-post' => 'profile/addFavoriteFromPost',
                    'profile/add-collection-from-post' => 'profile/addCollectionFromPost',
                    'profile/delete-from-user-collection/<post_id:\d+>' => 'profile/deleteFromUserCollection',
                    'profile/delete-from-favorites/<post_id:\d+>' => 'profile/deleteFromFavorites',
                    'profile/delete-post-from-collection' => 'profile/deletePostFromCollection',

                    'reset/password' => 'forgotPassword/resetPassword',
                    'reset/user-subscription-password' => 'forgotPassword/resetUserSubscriptionPassword',
                    'reset/password-email' => 'forgotPassword/resetPasswordEmail',

                    'reset/login/password' => 'loginForgotPassword/resetPassword',
                    'reset/login/password-email' => 'loginForgotPassword/resetPasswordEmail',
                    'reset/login/reset-password-form' => 'loginForgotPassword/resetPasswordForm',

                    /* Flow 1: start */
                    'subscription/f1/step-one' => 'subscriptionF1/stepOne',
                    'subscription/f1/save-step-one' => 'subscriptionF1/saveStepOne',

                    'subscription/f1/step-two' => 'subscriptionF1/stepTwoEmail',
                    'subscription/f1/save-step-two' => 'subscriptionF1/saveStepTwoEmail',

                    'subscription/f1/step-two-auth' => 'subscriptionF1/stepTwoAuth',
                    'subscription/f1/save-step-two-login' => 'subscriptionF1/saveStepTwoLogin',
                    'subscription/f1/save-step-two-register' => 'subscriptionF1/saveStepTwoRegister',
                    'subscription/f1/confirm-step-two-register' => 'subscriptionF1/confirmStepTwoRegister',
                    'subscription/f1/step-two-success' => 'subscriptionF1/stepTwoSuccess',
                    'subscription/f1/reset-password' => 'subscriptionF1/stepTwoResetPasswordEmail',

                    'subscription/f1/step-three' => 'subscriptionF1/stepThree',

                    'subscription/f1/step-three-payment' => 'subscriptionF1/stepThreePayment',
                    'subscription/f1/step-three-payment/success' => 'subscriptionF1/stepThreePaymentSuccess',
                    'subscription/f1/step-three-payment/cancel' => 'subscriptionF1/stepThreePaymentCancel',
                    /* Flow 1: end */

                    /* Flow 2: start */
                    'subscription/f2/save-step-one' => 'subscriptionF2/saveStepOne',

                    'subscription/f2/step-two' => 'subscriptionF2/stepTwo',
                    'subscription/f2/save-step-two' => 'subscriptionF2/saveStepTwo',

                    'subscription/f2/step-two-auth' => 'subscriptionF2/stepTwoAuth',
                    'subscription/f2/save-step-two-login' => 'subscriptionF2/saveStepTwoLogin',
                    'subscription/f2/save-step-two-register' => 'subscriptionF2/saveStepTwoRegister',
                    'subscription/f2/confirm-step-two-register' => 'subscriptionF2/confirmStepTwoRegister',
                    'subscription/f2/step-two-success' => 'subscriptionF2/stepTwoSuccess',
                    'subscription/f2/reset-password' => 'subscriptionF2/stepTwoResetPasswordEmail',

                    'subscription/f2/step-three' => 'subscriptionF2/stepThree',
                    'subscription/f2/step-three-payment' => 'subscriptionF2/stepThreePayment',
                    'subscription/f2/step-three-payment/success' => 'subscriptionF2/stepThreePaymentSuccess',
                    'subscription/f2/step-three-payment/cancel' => 'subscriptionF2/stepThreePaymentCancel',
                    /* Flow 2: end */

                    /* Flow 3: start */
                    'subscription/f3/step-one' => 'subscriptionF3/stepOne',
                    'subscription/f3/show-step-one' => 'subscriptionF3/showStepOne',
                    'subscription/f3/save-step-one' => 'subscriptionF3/saveStepOne',
                    'subscription/f3/step-two' => 'subscriptionF3/stepTwo',
                    'subscription/f3/show-step-two' => 'subscriptionF3/showStepTwo',

                    'subscription/f3/step-three-payment' => 'subscriptionF3/stepThreePayment',
                    'subscription/f3/step-three-payment/success' => 'subscriptionF3/stepThreePaymentSuccess',
                    'subscription/f3/step-three-payment/cancel' => 'subscriptionF3/stepThreePaymentCancel',
                    /* Flow 3: end */

                    /* Flow 4: start */
                    'subscription/f4/step-one' => 'subscriptionF4/stepOne',
                    'subscription/f4/save-step-one' => 'subscriptionF4/saveStepOne',
                    'subscription/f4/step-two-auth-gift' => 'subscriptionF4/stepTwoAuthGift',

                    'subscription/f4/step-two' => 'subscriptionF4/stepTwo',

                    'subscription/f4/step-three-payment' => 'subscriptionF4/stepThreePayment',
                    'subscription/f4/step-three-payment/success' => 'subscriptionF4/stepThreePaymentSuccess',
                    'subscription/f4/step-three-payment/cancel' => 'subscriptionF4/stepThreePaymentCancel',
                    /* Flow 4: end */

                    /* Flow 5: start */
                    'subscription/f5/save-step-two-gift' => 'subscriptionF5/saveStepTwoGift',
                    'subscription/f5/show-step-three-gift' => 'subscriptionF5/showStepThreeGift',
                    'subscription/f5/step-two-gift-auth' => 'subscriptionF5/stepTwoGiftAuth',
                    'subscription/f5/step-three' => 'subscriptionF5/stepThree',

                    'subscription/f5/step-three-payment' => 'subscriptionF5/stepThreePayment',
                    'subscription/f5/step-three-payment/success' => 'subscriptionF5/stepThreePaymentSuccess',
                    'subscription/f5/step-three-payment/cancel' => 'subscriptionF5/stepThreePaymentCancel',

                    'subscription/f5/save-step-two-gift-login' => 'subscriptionF5/saveStepTwoGiftLogin',
                    'subscription/f5/save-step-two-gift-register' => 'subscriptionF5/saveStepTwoGiftRegister',
                    'subscription/f5/confirm-step-two-gift-register' => 'subscriptionF5/confirmStepTwoGiftRegister',

                    'subscription/f5/step-three-gift' => 'subscriptionF5/stepThreeGift',
                    'subscription/f5/save-step-three-gift' => 'subscriptionF5/saveStepThreeGift',
                    /* Flow 5: end */

                    /* Flow 6: start */
                    'subscription/f6/save-step-three-gift' => 'subscriptionF6/saveStepThreeGift',
                    /* Flow 6: end */

                    /* Flow 9: start */
                    'subscription/f9/update-subscription' => 'subscriptionF9/updateSubscription',
                    'subscription/f9/step-one' => 'subscriptionF9/stepOne',
                    'subscription/f9/save-step-one' => 'subscriptionF9/saveStepOne',

                    'subscription/f9/step-two' => 'subscriptionF9/stepTwo',
                    'subscription/f9/save-step-two' => 'subscriptionF9/saveStepTwo',

                    'subscription/f9/step-two-auth-gift' => 'subscriptionF9/stepTwoAuthGift',
                    'subscription/f9/step-three-payment' => 'subscriptionF9/stepThreePayment',
                    'subscription/f9/step-three-payment/success' => 'subscriptionF9/stepThreePaymentSuccess',
                    'subscription/f9/step-three-payment/cancel' => 'subscriptionF9/stepThreePaymentCancel',
                    /* Flow 9: end */

                    /* Flow 11: start */
                    'subscription/f11/step-one' => 'subscriptionF11/stepOne',
                    'subscription/f11/save-step-one' => 'subscriptionF11/saveStepOne',

                    'subscription/f11/step-two' => 'subscriptionF11/stepTwo',
                    'subscription/f11/save-step-two' => 'subscriptionF11/saveStepTwo',

                    'subscription/f11/step-three' => 'subscriptionF11/stepThree',

                    'subscription/f11/step-three-payment' => 'subscriptionF11/stepThreePayment',
                    'subscription/f11/step-three-payment/success' => 'subscriptionF1/stepThreePaymentSuccess',
                    'subscription/f11/step-three-payment/cancel' => 'subscriptionF1/stepThreePaymentCancel',
                    /* Flow 11: end */

                    /* Activate gift */
                    'activate-gift' => 'profile/activateGift',

                    /* Setting */
                    'subscription/payment-cancel' => 'subscription/cancelPaymentPage',


                    /* Promo-code */
                    'promo-code/activate' => 'promoCode/activatePromoCode',

                    /* Test gift subscription */
                    'profile/test-gift-sab' => 'profile/testGiftSub',
                    'profile/test-update-sab' => 'profile/testUpdateSub',

                    /* Webhook */
                    'subscription/webhook' => 'subscription/stripeWebhook',
                    'test' => 'subscription/test',

                    /* Cookie */
                    'set/cookie' => 'cookie/setCookie',

                    'page/<url:([\w-]+)>' => 'site/page',
                    '<controller:\w+>/<id:\d+>' => '<controller>/view',
                    '<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
                    '<controller:\w+>/<action:\w+>' => '<controller>/<action>',
                ],
            ],
            'request' => [
                'class' => 'ext.localeurls.GtbLocaleHttpRequest',
                'gtbLanguages' => [
                    'ru',
                    'en',
                    'be'
                ],
                'gtuLanguages' => [
                    'uk',
                    'ru',
                    'en',
                ],
            ],
        ],
    ]
);
