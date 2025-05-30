<?php
/** @var $model HasIdeaForm */
?>

<p>Посетитель сайта предлагает помощь или идею.</p>

<p><strong>Имя</strong> <?= CHtml::encode($model->name) ?><br />
<strong>Как связаться:</strong> <?= CHtml::encode($model->method) ?><br />
<strong>Сообщение:</strong> <?= nl2br(CHtml::encode($model->message)) ?></p>
