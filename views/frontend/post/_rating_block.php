<?php
/** @var $comment Comment|GtbComment */
/** @var $active string */
?>
<a href="#" class="b-comment__rate plus <?= $active == 'plus' ? 'active' : '' ?>"></a>
<span class="b-comment__rating__number"><?= $comment->likes_count ?></span>
<a href="#" class="b-comment__rate minus <?= $active == 'minus' ? 'active' : '' ?>"></a>
<span class="b-comment__rating__number"><?= $comment->dislikes_count ?></span>
<span class="b-comment__rating__all">
    <?php
    $rating = $comment->likes_count - $comment->dislikes_count;
    if ($rating > 0) { ?>
        <span class="b-comment__rating__positive">+<?= $rating ?></span>
    <?php } elseif ($rating < 0) { ?>
        <span class="b-comment__rating__negative"><?= $rating ?></span>
    <?php } ?>
</span>