<?php
/** @var $model TestWidget */
/** @var $questions TestQuestion[] */
/** @var $questionsVariants TestVariant[][] */

$step1_title_has_border = $model->step1_title_has_border == 1;
$step2_title_has_border = $model->step2_title_has_border == 1;
$step3_title_has_border = $model->step3_title_has_border == 1;

$w1 = $model->has_border == 1 ? 920 : 940;
$w2 = $model->has_border == 1 ? 520 : 540;

$true_false = $model->type == TestWidget::TYPE_ONE;

$uniqid = uniqid('test');
?>

<div class="interactive-test-box itw-<?= $model->id ?>" data-uniqid="<?= $uniqid ?>" data-true-false="<?= (int)$true_false ?>" data-correct-count="0">

    <?= CHtml::beginForm(['/interactive/test'], 'post', ['data-start-url' => Yii::app()->createUrl('/interactive/start')]) . "\n" ?>
    <?= CHtml::hiddenField('widgetId', $model->id, ['id' => false]) . "\n" ?>
    <?= CHtml::hiddenField('userId', $uniqid, ['id' => false]) . "\n" ?>

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

    <div class="interactive-test start-step step">
        <div class="interactive-test-content">
            <p class="test-title">
                <?php if ($step1_title_has_border): ?>
                    <span><span class="border-position"><?= nl2br($model->title) ?></span></span>
                <?php else: ?>
                    <?= nl2br($model->title) ?>
                <?php endif; ?>
            </p>
            <?= $model->text ?>
        </div>
        <div class="buttons-box">
            <span class="js-next-step btn">
                <span class="alignment"><?= CHtml::encode($model->step1_button_text ?: 'СТАРТ!') ?></span>
            </span>
        </div>
    </div>

    <?php
    $count = 1;
    foreach ($questions as $question):
        if (!isset($questionsVariants[$question->id])) {
            continue;
        }
        $variants = $questionsVariants[$question->id];
        ?>
        <div class="interactive-test middle-step step<?= $count ?> step">
            <div class="interactive-test-content">
                <p class="test-title">
                    <?php if ($step2_title_has_border): ?>
                        <span><span class="border-position"><?= nl2br($question->title) ?></span></span>
                    <?php else: ?>
                        <?= nl2br($question->title) ?>
                    <?php endif; ?>
                </p>
                <?= $question->text ?>

                <div class="test-form">
                    <div class="radio-items-list<?= $question->grid_variant == TestQuestion::GRID_IMAGES_VERTICAL ? ' has-images' : '' ?><?= $question->grid_variant == TestQuestion::GRID_IMAGES ? ' has-images in-cols' : '' ?>">
                        <?php foreach ($variants as $variant): ?>
                            <?= $question->grid_variant == TestQuestion::GRID_IMAGES ? '<div class="col">' : '' ?>
                            <div class="test-radio-item">
                                <?php if ($question->grid_variant != TestQuestion::GRID_USUAL && !empty($variant->image)): ?>
                                    <img src="<?= $variant->getImageUrl('image') ?>" alt="">
                                <?php endif; ?>
                                <input id="step-radio-<?= $question->id ?>-<?= $variant->id ?>" name="answers[<?= $question->id ?>]" value="<?= $variant->id ?>" type="radio"<?= $true_false && $variant->is_correct == 1 ? ' data-boolean="true"' : '' ?>>
                                <label for="step-radio-<?= $question->id ?>-<?= $variant->id ?>"><?= nl2br($variant->text) ?> <span class="checked-bg"></span></label>
                            </div>
                            <?= $question->grid_variant == TestQuestion::GRID_IMAGES ? '</div>' : '' ?>
                            <?php if ($true_false && $variant->is_correct == 1): ?>
                                <input type="hidden" name="wins[<?= $question->id ?>]" value="<?= $variant->id ?>">
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </div>
                    <?php if ($true_false): ?>
                        <div class="test-answer">
                            <div class="true">
                                <p><?= CHtml::encode($question->correct_answer_text ?: 'Верно!') ?></p>
                                <p><?= nl2br($question->answer) ?></p>
                            </div>
                            <div class="false">
                                <p><?= CHtml::encode($question->wrong_answer_text ?: 'Неверно!') ?></p>
                                <p><?= nl2br($question->answer) ?></p>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>

            </div>
            <div class="buttons-box">
                <span class="js-next-step btn">
                    <span class="alignment"><?= CHtml::encode($model->step2_button_text ?: 'ДАЛЬШЕ!') ?></span>
                </span>
            </div>
        </div>

        <?php
        $count++;
    endforeach;
    ?>

    <div class="interactive-test final-step step">
        <div class="interactive-test-content"></div>
        <div class="buttons-box">
            <span class="js-next-step btn">
                <span class="alignment"><?= $model->step3_button_text ?: 'ЕЩЕ РАЗ!' ?></span>
            </span>
        </div>
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

    <?= CHtml::endForm() . "\n" ?>

</div>
