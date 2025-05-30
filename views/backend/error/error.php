<?php
/* @var $this ErrorController */
/* @var $code int */
/* @var $message string */

$this->pageTitle = 'Ошибка ' . $code;
$this->breadcrumbs = [
    'Ошибка',
];
?>

<h1>Ошибка <?= $code ?></h1>

<div class="error">
    <?= CHtml::encode($message) ?>
</div>