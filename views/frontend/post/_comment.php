<?php
/* @var $comment Comment|GtbComment */
/* @var $cookie_prefix string */

$themeUrl = Yii::app()->theme->baseUrl;
?>
<div class="b-comment__simple">
    <div class="b-comment__sub b-comment__sub__<?= $comment->level > 2 ? 2 : $comment->level ?>">
        <?php if (!empty($comment->author)) { ?>
            <div class="b-comment__avatar">
                <?php
                $userImage = !empty($comment->author->profile_img) ? str_replace('http://', '//', $comment->author->profile_img) : $themeUrl . '/images/user_icon_.png';
                ?>
                <a href="<?= CHtml::encode($comment->author->profile_url) ?>" target="_blank">
                    <img width="65" height="65" class="avatar" alt="<?= CHtml::encode($comment->author->username) ?>" src="<?= CHtml::encode($userImage) ?>">
                </a>
            </div>
        <?php } else { ?>
            <div class="b-comment__avatar anonymous">
                <img class="avatar" alt="<?= CHtml::encode(strip_tags($comment->user_name)) ?>" src="<?= $themeUrl . '/images/user_icon_.png' ?>">
            </div>
        <?php } ?>

        <div>
            <div class="b-comment__info">
                <strong>
                    <?php if (!empty($comment->author)) { ?>
                        <a href="<?= CHtml::encode($comment->author->profile_url) ?>" target="_blank"><?= CHtml::encode($comment->author->username) ?></a>
                    <?php } else { ?>
                        <?= CHtml::encode(strip_tags($comment->user_name)) ?>
                    <?php } ?>
                </strong> | <?= date('j.m.Y H:i', strtotime($comment->created_at)) ?>
            </div>
            <div class="b-comment__text">
                <p><?= $comment->status_id == GtbComment::STATUS_ENABLED ? nl2br(CHtml::encode($comment->content)) : 'Данный комментарий скрыт' ?></p>
            </div>
            <?php
            $cookiesHelper = Yii::app()->cookiesHelper;
            $alreadyVoted = Yii::app()->session[$cookie_prefix . $comment->id];
            if (empty($alreadyVoted)) {
                $alreadyVoted = $cookiesHelper->getCMsg($cookie_prefix . $comment->id);
            }
            ?>
            <div class="b-comment__rating" data-parent-id="<?= $comment->id ?>">
                <div class="b-comment__rating__block">
                    <?php $this->renderPartial('//post/_rating_block', array(
                        'comment' => $comment,
                        'active' => $alreadyVoted,
                    )); ?>
                </div>
                <!--<a href="#comment" class="b-comment__reply"><?= Yii::t('app', 'Reply') ?></a>-->
            </div>
        </div>
    </div>
</div>
