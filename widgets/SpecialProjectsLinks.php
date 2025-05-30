<?php

class SpecialProjectsLinks extends CWidget
{
    public function run()
    {
        $sp_items = SpecialProject::getNewItems();
        if (count($sp_items)) {
            ?>
            <div class="projects">
                <p>спецпроекты:</p>
                <?php
                foreach ($sp_items as $sp_one) {
                    $img = $sp_one->getImageUrl('image');
                    $img_attrs = array();
                    if (!empty($sp_one->image) && preg_match('/\.svg$/i', $sp_one->image)) {
                        $img_attrs['width'] = !empty($sp_one->image_width) ? $sp_one->image_width : '16';
                    }
                    $atttrs = array();
                    if (Yii::app()->controller->id == 'special') {
                        $name = Yii::app()->request->getQuery('name');
                        if ($name == $sp_one->url) {
                            $atttrs['class'] = 'active';
                        }
                    }
                    echo CHtml::link((!empty($img) ? CHtml::image($img, $sp_one->title, $img_attrs) . ' ' : '') . $sp_one->title, $sp_one->getUrl(), $atttrs) . "\n";
                }
                ?>
            </div>
            <?php
        }
    }
}
