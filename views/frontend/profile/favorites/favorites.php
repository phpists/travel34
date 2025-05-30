<?php
/* @var $this ProfileController */

$themeUrl = Yii::app()->theme->baseUrl;
Yii::app()->clientScript->registerCssFile(Common::assetsTime($themeUrl . '/css/bootstrap/bootstrap-grid.min.css'));
?>
<div class="post-body" style="background-color: #E2E2E2 !important;">
    <div class="container container-wide">
        <div classs="wide-box">
            <h1 class="post-title">Избранное</h1>
            <div class="faves__wrap">
                <?php $this->renderPartial('include/menu'); ?>
                <div class="collections__sort">
                    <span class="collections__sort_header">Сортировать:</span>
                    <a href="<?= $this->createUrl('/profile/favorites', ['create_date' => $create_date]) ?>"
                       class="collections__sort_item
                        <?php if ($create_date && $create_date == true): ?> open <?php endif; ?>
                        <?php if (isset($create_date)): ?> active <?php endif; ?>">
                        <span>
                            По дате добавления
                        </span>
                    </a>
                    <a href="<?= $this->createUrl('/profile/favorites', ['publish_date' => $publish_date]) ?>"
                       class="collections__sort_item
                        <?php if ($publish_date && $publish_date == true): ?> open <?php endif; ?>
                        <?php if (isset($publish_date) && $publish_date != 2): ?> active <?php endif; ?>">
                        <span>По дате публикации</span>
                    </a>
                </div>
                <div class="faves__list row">
                    <?php foreach ($posts as $post) {
                        $this->renderPartial('favorites/includes/_post', ['post' => $post]);
                    } ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $this->renderPartial('modals/create_collection'); ?>
<?php $this->renderPartial('modals/edit_collection'); ?>
<?php $this->renderPartial('modals/delete_collections'); ?>

