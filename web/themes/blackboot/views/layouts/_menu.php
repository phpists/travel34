<?php
/* @var $this BackEndController */
?>
<div class="nav-collapse" id="menu-top">
    <?php
    $this->widget('bootstrap.widgets.TbMenu', [
        'activateParents' => true,
        'items' => [
            [
                'label' => 'Посты',
                'url' => ['/post/index'],
                'items' => [
                    ['label' => 'Посты', 'url' => ['/post/index'], 'active' => $this->id == 'post'],
                    ['label' => 'Рубрики', 'url' => ['/rubric/index'], 'active' => $this->id == 'rubric'],
                    ['label' => 'Спецпроекты', 'url' => ['/specialProject/index'], 'active' => $this->id == 'specialProject'],
                    ['label' => 'Авторы', 'url' => ['/author/index'], 'active' => $this->id == 'author'],
                ],
            ],
            [
                'label' => 'Go To Belarus',
                'url' => ['/gtbPost/index'],
                'items' => [
                    ['label' => 'Посты', 'url' => ['/gtbPost/index'], 'active' => $this->id == 'gtbPost'],
                    ['label' => 'Рубрики', 'url' => ['/gtbRubric/index'], 'active' => $this->id == 'gtbRubric'],
                    ['label' => 'Баннеры', 'url' => ['/gtbBanner/index'], 'active' => $this->id == 'gtbBanner'],
                    ['label' => 'Комментарии', 'url' => ['/gtbComment/index'], 'active' => $this->id == 'gtbComment'],
                    ['label' => Yii::t('app', 'Places'), 'url' => ['/gtbPlace/index'], 'active' => $this->id == 'gtbPlace'],
                ],
            ],
            [
                'label' => 'Go To Ukraine',
                'url' => ['/gtuPost/index'],
                'items' => [
                    ['label' => 'Посты', 'url' => ['/gtuPost/index'], 'active' => $this->id == 'gtuPost'],
                    ['label' => 'Рубрики', 'url' => ['/gtuRubric/index'], 'active' => $this->id == 'gtuRubric'],
                    ['label' => 'Баннеры', 'url' => ['/gtuBanner/index'], 'active' => $this->id == 'gtuBanner'],
                    ['label' => Yii::t('app', 'Places'), 'url' => ['/gtuPlace/index'], 'active' => $this->id == 'gtuPlace'],
                ],
            ],
            [
                'label' => 'Гео',
                'url' => '#',
                'items' => [
                    ['label' => 'Города', 'url' => ['/city/index'], 'active' => $this->id == 'city'],
                    ['label' => 'Страны', 'url' => ['/country/index'], 'active' => $this->id == 'country'],
                ],
            ],
            [
                'label' => 'Контент',
                'url' => '#',
                'items' => [
                    ['label' => 'Страницы', 'url' => ['/page/index'], 'active' => $this->id == 'page'],
                    ['label' => 'Блоки', 'url' => ['/block/index'], 'active' => $this->id == 'block'],
                    ['label' => 'SEO-теги', 'url' => ['/seoTag/index'], 'active' => $this->id == 'seoTag'],
                    ['label' => 'Блок под постом', 'url' => ['/blockAfterPost/index'], 'active' => $this->id == 'blockAfterPost'],
                ],
            ],
            ['label' => 'Интерактив', 'url' => ['/interactiveWidget/index'], 'active' => $this->id == 'interactiveWidget'],
            ['label' => 'Тесты', 'url' => ['/testWidget/index'], 'active' => in_array($this->id, ['testWidget', 'testQuestion', 'testResult'])],
            ['label' => 'Стили', 'url' => ['/style/index'], 'active' => $this->id == 'style'],
            ['label' => 'Баннеры', 'url' => ['/banner/index'], 'active' => $this->id == 'banner'],
            ['label' => 'Подписка', 'url' => ['/subscriptionSetting/index'], 'active' => $this->id == 'subscription'],
            [
                'label' => 'Промокоды',
                'url' => '#',
                'items' => [
                    ['label' => 'Подарочные промокоды', 'url' => ['/promoCodeGift/index'], 'active' => $this->id == 'giftPromoCode'],
                    ['label' => 'Скидочные промокоды', 'url' => ['/promoCode/index'], 'active' => $this->id == 'promoCode'],
                ],
            ],
            [
                'label' => 'Ещё',
                'url' => '#',
                'items' => [
                    ['label' => 'Комментарии', 'url' => ['/comment/index'], 'active' => $this->id == 'comment'],
                    ['label' => 'Заявки', 'url' => ['/proposal/index'], 'active' => $this->id == 'proposal'],
                    ['label' => 'Пользователи', 'url' => ['/user/index'], 'active' => $this->id == 'user'],
                    ['label' => 'Настройки', 'url' => ['/setting/index'], 'active' => $this->id == 'setting'],
                    ['label' => 'Шаблоны писем', 'url' => ['/emailTemplate/index'], 'active' => $this->id == 'emailTemplate'],
                ],
            ],
        ],
    ]);
    $this->widget('bootstrap.widgets.TbMenu', [
        'activateParents' => true,
        'htmlOptions' => ['class' => 'pull-right'],
        'items' => [
            [
                'label' => 'Tools',
                'url' => '#',
                'items' => [
                    ['label' => Yii::t('app', 'Change Password'), 'url' => ['/admin/password']],
                    ['label' => Yii::t('app', 'Сlear Cache'), 'url' => ['/admin/clearCache']],
                    ['label' => 'elFinder', 'url' => ['/elfinder/index'], 'linkOptions' => ['target' => '_blank']],
                    ['label' => 'Gii', 'url' => ['/gii/default/index'], 'linkOptions' => ['target' => '_blank'], 'visible' => APPLICATION_ENVIRONMENT == 'local'],
                ],
            ],
            [
                'label' => 'Выйти',
                'url' => ['/admin/logout'],
                'visible' => !Yii::app()->user->isGuest,
                'linkOptions' => ['title' => Yii::app()->user->name],
            ],
        ],
    ]);
    ?>
</div>
