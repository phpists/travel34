<?php
/* @var $this ProfileController */

$themeUrl = Yii::app()->theme->baseUrl;
Yii::app()->clientScript->registerCssFile(Common::assetsTime($themeUrl . '/css/bootstrap/bootstrap-grid.min.css'));
?>
<section class="post-body" style="background-color: #E2E2E2 !important;">
    <div class="container container-wide">
        <div class="wide-box">
            <h1 class="post-title">Мои коллекции</h1>
            <div class="collections__wrap">
                <?php $this->renderPartial('include/menu'); ?>
                <div class="collections__sort collections__sort_account">
                    <span class="collections__sort_header">Сортировать:</span>
                    <a href="<?= $this->createUrl('profile/collections', ['create_date' => $create_date]) ?>"
                       class="collections__sort_item
                        <?php if ($create_date && $create_date == true): ?> open <?php endif; ?>
                        <?php if (isset($create_date)): ?> active <?php endif; ?>">
                        <span>
                            По дате добавления
                        </span>
                    </a>
                    <a href="<?= $this->createUrl('profile/collections', ['publish_date' => $publish_date]) ?>"
                       class="collections__sort_item
                        <?php if ($publish_date && $publish_date == true): ?> open <?php endif; ?>
                        <?php if (isset($publish_date) && $publish_date != 2): ?> active <?php endif; ?>">
                        <span>По дате публикации</span>
                    </a>
                </div>
                <div class="collections__list row">
                    <?php
                    foreach ($collections as $collection) {
                        $this->renderPartial('collections/includes/_item', ['collection' => $collection]);
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</section>
<?php $this->renderPartial('modals/create_collection'); ?>
<?php $this->renderPartial('modals/edit_collection'); ?>