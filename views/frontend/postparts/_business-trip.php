<?php
/* @var $text string */

$themeUrl = Yii::app()->theme->baseUrl;
?>

<style>
    .post-body .bank-box .descr h4 span, .post-body .bank-box .bank-form-box h3 span {
        border-color: #5da3ab;
    }
</style>

<div class="wide-box">
    <div class="roulette-wrap full-width">
        <div class="bank-box visible">
            <div class="descr">
                <div class="bank-logo">
                    <img src="<?= $themeUrl ?>/images/ruletka/prior_upd.png" alt="" srcset="<?= $themeUrl ?>/images/ruletka/prior_upd-x2.png 2x">
                </div>
                <?= BlocksHelper::get('prior_form_text') ?>
            </div>
            <div class="bank-form-box">
                <?php $this->widget('application.widgets.ProposalFormWidget', ['blockName' => 'prior_form_result', 'formType' => 'prior']); ?>
            </div>
        </div>
    </div>
</div>

<?= BlocksHelper::get('prior_footer_text') ?>
