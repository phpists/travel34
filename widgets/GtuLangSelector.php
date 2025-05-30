<?php

class GtuLangSelector extends CWidget
{
    public $ulClass;

    public function run()
    {
        $languages = Yii::app()->params['gtuMenuLanguages'];
        $app_lang = Yii::app()->language;
        ?>
        <ul<?= $this->ulClass ? ' class="' . CHtml::encode($this->ulClass) . '"' : '' ?>>
            <?php
            foreach ($languages as $lang => $lang_title) {
                if ($app_lang == $lang) {
                    echo '<li class="active">';
                } else {
                    echo '<li>';
                }
                echo '<a href="' . Yii::app()->urlManager->createUrl('/gtu/index', ['language' => $lang]) . '">' . $lang_title . '</a></li>';
            }
            ?>
        </ul>
        <?php
    }
}