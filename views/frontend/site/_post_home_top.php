<?php
/** @var $this SiteController */
/* @var $post Post */
/* @var $hideViewCount boolean */

$img = $post->getImageUrl('image_home_top');
if (empty($img)) {
    $img = $post->getImageUrl('image');
}
?>
<div class="f-width-box">
    <div class="b-news__short__block b-news__short__big b-col__2" style="height: 400px;">
        <a href="<?= $post->getUrl() ?>" style="background-image: url('<?= $img ?>')">
            <div class="b-news__short__big__info">
                <h2 class="b-news__short__title">
                    <?php if ($post->type_id == Post::TYPE_GUIDE) { ?>
                        <span class="b-news__short__gide">ГАЙД:</span>
                    <?php } ?>
                    <?= $post->title ?>
                </h2>
                <div class="b-news__short__big__cvc">
                    <?php if ($rubric = $post->getRubricTitle()): ?><span class="b-news__short__category"><?= $rubric ?></span><?php endif; ?>
                    <?php if (!$hideViewCount): ?><span class="b-news__short__view"><?= $post->getViewsCount() ?></span><?php endif; ?>
                    <?php if (Yii::app()->userComponent->isAuthenticated()): ?>
                    <div class="b-news__big__faves">
                        <div data-href="#form_add_post_view" data-post_id="<?= $post->id ?>" data-v="4" class="popup-with-form_faves addPostViewToFaves">
                            <svg class="svg_<?= $post->id ?>" width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path
                                        d="M8.28791 11.5771L8 11.3744L7.71209 11.5771L3.50939 14.5371L5.07562 9.64909L5.1853 9.30682L4.89581 9.0938L0.795615 6.0767H5.86987H6.22929L6.34381 5.73601L7.99991 0.809091L9.65601 5.73601L9.77053 6.0767H10.13H15.2044L11.1042 9.09398L10.8147 9.307L10.9244 9.64925L12.4903 14.5369L8.28791 11.5771ZM0.441238 5.81594C0.44126 5.81595 0.441282 5.81597 0.441304 5.81599L0.441238 5.81594ZM15.5588 5.81594L15.5585 5.81615C15.5586 5.81606 15.5587 5.81598 15.5588 5.8159L15.5588 5.81594ZM7.86295 0.401618C7.86292 0.401551 7.8629 0.401483 7.86288 0.401416L7.86295 0.401618Z"
                                        stroke="black" />
                            </svg>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </a>
    </div>
</div>
