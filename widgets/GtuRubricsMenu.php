<?php

class GtuRubricsMenu extends CWidget
{
    public function run()
    {
        $todo_title = Yii::t('app', 'To Do');
        $todo_url = Yii::app()->urlManager->createUrl('/gtu/todo');
        $active_todo = Yii::app()->controller->action->id == 'todo';
        if (Yii::app()->controller->action->id == 'rubric') {
            $rubric_url = Yii::app()->request->getQuery('url');
        } else {
            $rubric_url = false;
        }

        $attrs = in_array(Yii::app()->language, ['ru', 'en']) ? ['hide_in_menu_' . Yii::app()->language => 0] : ['hide_in_menu' => 0];

        /** @var GtuRubric[] $rubrics */
        $rubrics = GtuRubric::model()->enabled()->findAllByAttributes($attrs);
        $items = [];
        foreach ($rubrics as $rubric) {
            $active_rubric = $rubric_url && $rubric_url == $rubric->url;
            $item = [
                'title' => $rubric->getTitle(),
                'url' => $rubric->getUrl(),
                'active' => $active_rubric,
            ];
            if ($rubric->in_todo_list == 1) {
                $items['todo'][] = $item;
                // force active to do item
                if ($active_rubric) {
                    $active_todo = true;
                }
            } else {
                $items[] = $item;
            }
        }

        /*$items[] = [
            'title' => Yii::t('app', 'Map'),
            'url' => Yii::app()->urlManager->createUrl('/gtu/map'),
            'active' => Yii::app()->controller->action->id == 'map'
        ]*/
        ?>
        <ul>
            <?php
            foreach ($items as $key => $item) {
                if ($key === 'todo') {
                    ?>
                    <li class="has-child<?= $active_todo ? ' active' : '' ?>">
                        <a href="<?= $todo_url ?>"><?= CHtml::encode($todo_title) ?></a>
                        <ul>
                            <?php
                            foreach ($item as $subitem) {
                                ?>
                                <li<?= $subitem['active'] ? ' class="active"' : '' ?>>
                                    <a href="<?= $subitem['url'] ?>"><?= CHtml::encode($subitem['title']) ?></a>
                                </li>
                                <?php
                            }
                            ?>
                        </ul>
                    </li>
                    <?php
                } else {
                    ?>
                    <li<?= $item['active'] ? ' class="active"' : '' ?>>
                        <a href="<?= $item['url'] ?>"><?= CHtml::encode($item['title']) ?></a>
                    </li>
                    <?php
                }
            }
            ?>
        </ul>
        <?php
    }
}
