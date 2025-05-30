<?php
/* @var $this SiteController */
/* @var $model ContactForm */
/* @var $form CActiveForm */

$this->pageTitle   = Yii::app()->name . ' - ' . Yii::t('app', 'Contact Us');
$this->breadcrumbs = array(
    Yii::t('app', 'Home') => Yii::app()->getBaseUrl(true),
    Yii::t('app', 'Feedback'),
);
?>
<div class ="mainContentBg static">
    <div class="filter">
        <?php
        $this->widget('zii.widgets.CBreadcrumbs', array(
            'links'                => $this->breadcrumbs,
            'homeLink'             => false,
            'tagName'              => 'ul',
            'separator'            => '',
            'activeLinkTemplate'   => '<li><a href="{url}">{label}</a> <span class="divider">/</span></li>',
            'inactiveLinkTemplate' => '<li><span>{label}</span></li>',
            'htmlOptions'          => array('class' => 'breadcrumbs')
        ));
        ?>
    </div>
    <?php if (Yii::app()->user->hasFlash('contact')): ?>

        <div class="flash-success">
            <?php echo Yii::app()->user->getFlash('contact'); ?>
        </div>

    <?php else: ?>
    <?php if (!empty($page)) : ?>
        <?php echo $page->content ?>       
    <?php endif; ?>

    <div class="form contact-form">

        <?php
        $form = $this->beginWidget('CActiveForm', array(
            'id'                     => 'contact-form',
            'enableClientValidation' => true,
            'clientOptions'          => array(
                'validateOnSubmit' => true,
            ),
        ));
        ?>

        <p class="note"><?php echo Yii::t('app', 'Fields with {text} are required.', array('{text}' => '<span class="required">*</span>')); ?></p> 

        <div class="row">
            <?php echo $form->labelEx($model, 'name'); ?>
    <?php echo $form->textField($model, 'name'); ?>
    <?php echo $form->error($model, 'name'); ?>
        </div>

        <div class="row">
            <?php echo $form->labelEx($model, 'email'); ?>
    <?php echo $form->textField($model, 'email'); ?>
    <?php echo $form->error($model, 'email'); ?>
        </div>

        <div class="row">
            <?php echo $form->labelEx($model, 'phone'); ?>
    <?php echo $form->textField($model, 'phone'); ?>
    <?php echo $form->error($model, 'phone'); ?>
        </div>

        <div class="row">
            <?php echo $form->labelEx($model, 'subject'); ?>
    <?php echo $form->textField($model, 'subject', array('size' => 60, 'maxlength' => 128)); ?>
    <?php echo $form->error($model, 'subject'); ?>
        </div>

        <div class="row">
            <?php echo $form->labelEx($model, 'body'); ?>
    <?php echo $form->textArea($model, 'body', array('rows' => 6)); ?>
        <?php echo $form->error($model, 'body'); ?>
        </div>

        <?php  if(CCaptcha::checkRequirements()): ?>
          <div class="row captcha-code">
          <?php echo $form->labelEx($model,'verifyCode'); ?>
          <div>
          <?php $this->widget('CCaptcha'); ?>
          <?php echo $form->textField($model,'verifyCode'); ?>
          </div>
          <div class="hint"><?php echo Yii::t('app', 'Please enter the letters as they are shown in the image above.<br/>Letters are not case-sensitive.') ?></div>
          <?php echo $form->error($model,'verifyCode'); ?>
          </div>
          <?php endif; ?>

        <div class="row buttons">
        <?php echo CHtml::submitButton(Yii::t('app', 'Send'), array(
            'class' => 'btn btn-default'
        )); ?>
        </div>

    <?php $this->endWidget(); ?>

    </div><!-- form -->

<?php endif; ?>
</div>