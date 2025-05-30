<?php
/* @var $this SiteController */
/* @var $error array */

$this->pageTitle = $code == 404 ? Yii::app()->name . ' - Ошибка 404' : Yii::app()->name . ' - Error';

if ($code == 404) {
    ?>
    <div class="b-main static-page">
        <h1>Ошибка 404</h1>
        <p>Извините, запрашиваемая вами страница не найдена</p>
    </div>
    <?php
} else {
    ?>
    <div class="b-main static-page">
        <h1>Ошибка <?php echo $code; ?></h1>
        <p><?php echo CHtml::encode($message); ?></p>
    </div>
    <?php
}
