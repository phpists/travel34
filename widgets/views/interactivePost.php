<?php
/** @var $model InteractiveWidget */
/** @var $name string */
/** @var $resultModel InteractiveResult */
/** @var $url string */
/** @var $shareUrl string */

$step1_title_has_border = $model->step1_title_has_border == 1;
$step2_title_has_border = $model->step2_title_has_border == 1;
$step3_title_has_border = $model->step3_title_has_border == 1;

$w1 = $model->has_border == 1 ? 920 : 940;
$w2 = $model->has_border == 1 ? 520 : 540;

$skip2 = $model->skip_step2 == 1;

if ($skip2) {
    $step3_title = $model->step3_title ?: $model->title;
} else {
    $step3_title = $name ?: 'noname';
    $step3_title .= $model->step3_text_after;
}
?>

<div class="interactive-box iw-<?= $model->id ?><?= !$skip2 ? ' has-step2' : '' ?><?= $resultModel !== null ? ' has-result can-reload' : '' ?>">

    <?php if ($model->has_top_branding == 1 && !empty($model->top_branding_image)):
        $top_wrap1 = !empty($model->top_branding_url) ? '<a href="' . CHtml::encode($model->top_branding_url) . '" target="_blank">' : '';
        $top_wrap2 = !empty($model->top_branding_url) ? '</a>' : '';
        ?>
        <div class="top-branding">
            <?= $top_wrap1 ?>
            <?php if (!empty($model->top_branding_mobile_image)): ?>
                <img srcset="<?= $model->getImageUrl('top_branding_mobile_image') ?> <?= $w2 ?>w, <?= $model->getImageUrl('top_branding_image') ?> <?= $w1 ?>w"
                     sizes="(max-width: <?= $w2 ?>px) <?= $w2 ?>px, <?= $w1 ?>px"
                     src="<?= $model->getImageUrl('top_branding_image') ?>"
                     alt="">
            <?php else: ?>
                <img src="<?= $model->getImageUrl('top_branding_image') ?>" alt="">
            <?php endif; ?>
            <?= $top_wrap2 ?>
        </div>
    <?php endif; ?>

    <div class="interactive-inner clearfix">
        <div class="interactive-content">
            <p class="title step1-title">
                <?php if ($step1_title_has_border): ?>
                    <span><span class="border-position text"><?= nl2br(CHtml::encode($model->title)) ?></span></span>
                <?php else: ?>
                    <?= nl2br(CHtml::encode($model->title)) ?>
                <?php endif; ?>
            </p>
            <?php if (!$skip2): ?>
                <p class="title step2-title">
                    <?php if ($step2_title_has_border): ?>
                        <span><span class="border-position text"><?= nl2br(CHtml::encode($model->title)) ?></span></span>
                    <?php else: ?>
                        <?= nl2br(CHtml::encode($model->title)) ?>
                    <?php endif; ?>
                </p>
            <?php endif; ?>
            <p class="name-title" data-text-after="<?= !$skip2 ? $model->step3_text_after : '' ?>">
                <?php if ($step3_title_has_border): ?>
                    <span><span class="border-position text"><?= nl2br(CHtml::encode($step3_title)) ?></span></span>
                <?php else: ?>
                    <?= nl2br(CHtml::encode($step3_title)) ?>
                <?php endif; ?>
            </p>
            <?= CHtml::beginForm(['/interactive/result'], 'post', ['class' => 'enter-name-box']) . "\n" ?>
            <?= CHtml::hiddenField('widgetId', $model->id, ['id' => false]) . "\n" ?>
            <?= CHtml::hiddenField('pageUrl', $url, ['id' => false]) . "\n" ?>
            <?php if (!$skip2): ?>
                <label class="field-name" for="name-inp"><?= nl2br(CHtml::encode($model->step2_text)) ?></label>
                <input type="text" id="name-inp" name="name" class="form-control" maxlength="50">
            <?php endif; ?>
            <?= CHtml::endForm() . "\n" ?>
            <div class="interactive-result-box">
                <?php if ($resultModel !== null): ?>
                    <div class="interactive-result">
                        <?= $resultModel->text ?>
                        <div class="share-links" data-url="<?= CHtml::encode($shareUrl) ?>"></div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        <div class="buttons-box">
            <span class="js-start-interactive btn">
                <span class="alignment">СТАРТ!</span>
            </span>

            <span class="js-show-result btn">
                <span class="alignment">&gt;&gt;&gt;</span>
            </span>
            <span class="js-update-result btn">
                <span class="alignment">
                    <img src="<?= Yii::app()->theme->baseUrl ?>/images/interactive-update.svg" alt="" width="47" height="47">
                </span>
            </span>
            <?php if ($resultModel !== null): ?>
                <span class="js-reload-interactive btn">
                    <span class="alignment">В начало</span>
                </span>
            <?php endif; ?>
        </div>
        <div class="sub-bg"></div>
    </div>

    <?php if ($model->has_bottom_branding == 1 && !empty($model->bottom_branding_image)):
        $bottom_wrap1 = !empty($model->bottom_branding_url) ? '<a href="' . CHtml::encode($model->bottom_branding_url) . '" target="_blank">' : '';
        $bottom_wrap2 = !empty($model->bottom_branding_url) ? '</a>' : '';
        ?>
        <div class="bottom-branding">
            <?= $bottom_wrap1 ?>
            <?php if (!empty($model->bottom_branding_mobile_image)): ?>
                <img srcset="<?= $model->getImageUrl('bottom_branding_mobile_image') ?> <?= $w2 ?>w, <?= $model->getImageUrl('bottom_branding_image') ?> <?= $w1 ?>w"
                     sizes="(max-width: <?= $w2 ?>px) <?= $w2 ?>px, <?= $w1 ?>px"
                     src="<?= $model->getImageUrl('bottom_branding_image') ?>"
                     alt="">
            <?php else: ?>
                <img src="<?= $model->getImageUrl('bottom_branding_image') ?>" alt="">
            <?php endif; ?>
            <?= $bottom_wrap2 ?>
        </div>
    <?php endif; ?>

</div>
