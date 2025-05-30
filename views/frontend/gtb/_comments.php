<?php
/* @var $this GtbController */
/* @var $model GtbPost */

$themeUrl = Yii::app()->theme->baseUrl;

if ($model->comments_count == 0) {
    return;
}

$postsCommentsTreeList = $model->getCommentsTreeList();
?>

<div class="b-comment__wrap">
    <div class="b-comment">
        <h2><?= Yii::t('app', 'Comments') ?> (<?= $model->comments_count ?>)</h2>
        <div class="b-comment__list" id="comments">
            <?php foreach ($postsCommentsTreeList as $comment):
                /** @var $comment GtbComment */
                ?>
                <div class="b-comment__simple">
                    <div class="b-comment__sub b-comment__sub__<?= $comment->level > 2 ? 2 : $comment->level ?>">
                        <div class="b-comment__avatar anonymous">
                            <img width="75" height="75" class="avatar" alt="<?= CHtml::encode(strip_tags($comment->author ? $comment->author->username : $comment->user_name)) ?>" src="<?= $themeUrl . '/images/user_icon_.png' ?>">
                        </div>

                        <div>
                            <div class="b-comment__info">
                                <strong><?= CHtml::encode(strip_tags($comment->author ? $comment->author->username : $comment->user_name)) ?></strong> | <?= date('j.m.Y H:i', strtotime($comment->created_at)) ?>
                            </div>
                            <div class="b-comment__text">
                                <p><?= $comment->status_id == GtbComment::STATUS_ENABLED ? nl2br(CHtml::encode($comment->content)) : 'Данный комментарий скрыт' ?></p>
                            </div>
                            <div class="b-comment__rating" data-parent-id="<?= $comment->id ?>">
                                <div class="b-comment__rating__block">
                                    <span class="b-comment__rate plus"></span>
                                    <span class="b-comment__rating__number"><?= $comment->likes_count ?></span>
                                    <span class="b-comment__rate minus"></span>
                                    <span class="b-comment__rating__number"><?= $comment->dislikes_count ?></span>
                                    <span class="b-comment__rating__all">
                                        <?php $rating = $comment->likes_count - $comment->dislikes_count; ?>
                                        <?php if ($rating > 0) { ?>
                                            <span class="b-comment__rating__positive">+<?= $rating ?></span>
                                        <?php } elseif ($rating < 0) { ?>
                                            <span class="b-comment__rating__negative"><?= $rating ?></span>
                                        <?php } ?>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>
