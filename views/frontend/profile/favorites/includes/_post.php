<?php
/* @var $this Post */

$collection = UserCollection::model()->findByAttributes([
    'post_id' => $post->id
]);
?>
<div class="faves__item col-12 col-us-6 col-sm-6 col-md-4 col-lg-3">
    <a href="<?= $post->getUrl() ?>" class="faves__item_wrap">
        <div class="collections__item_img one-collection__item_img">
            <?php if ($post->type_id == Post::TYPE_NEWS): ?>
                <img src="<?= $post->getImageUrl('image_big_post') ?>"/>
            <?php else: ?>
                <img src="<?= $post->getImageUrl('image') ?>"/>
            <?php endif; ?>
        </div>
        <div class="faves__item_top">
            <div class="faves__item_data">
                <?php if ($rubric = $post->getRubricTitle()): ?>
                    <span class="faves__item_tag"><?= $rubric ?></span>
                    <span class="faves__item_slash">/</span>
                <?php endif; ?>
                <span class="faves__item_date"><?= $post->getDateCreate() ?></span>
            </div>

            <div class="faves__item_actions">
                <div class="faves__item_action popup-with-form_faves deleteFavoritePost"
                     data-post_id="<?= $post->id ?>"
                     data-is_collection="<?= isset($collection->collection_id) ? 1 : 0 ?>"
                     data-href="#form_edit_one">
                    <div class="faves__item_action_icon svg-bg-pencil"></div>
                </div>
            </div>
        </div>
        <div class="collections__item__header faves__item__header"><span><?= $post->title ?></span></div>
        <?php if ($post->summary): ?>
            <div class="faves__item_separator"></div>
            <p class="faves__item__description"><?= strip_tags($post->summary) ?></p>
        <?php endif; ?>
    </a>
</div>
