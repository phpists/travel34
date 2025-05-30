<?php

class GtbLangSelector extends CWidget
{
    public function run()
    {
        $languages = Yii::app()->params['gtbMenuLanguages'];
        $app_lang = Yii::app()->language;
        ?>
        <ul>
            <?php
            foreach ($languages as $lang => $lang_title) {
                if ($app_lang == $lang) {
                    echo '<li class="active">' . $lang_title . '</li>';
                } else {
                    echo '<li><a href="' . Yii::app()->urlManager->createUrl('/gtb/index', ['language' => $lang]) . '">' . $lang_title . '</a></li>';
                }
            }
            ?>
        </ul>
        <?php
    }
}