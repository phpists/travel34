<?php
/** @var string $url */
/** @var string $text */
/** @var string $comment */
?>

<p><strong>URL:</strong> <?= CHtml::encode($url) ?><br/>
<strong>Текст с ошибкой:</strong> <?= nl2br(CHtml::encode($text)) ?><br/>
<strong>Комментарий:</strong> <?= nl2br(CHtml::encode($comment)) ?></p>
