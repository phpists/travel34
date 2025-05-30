<?php
/* @var $this ProfileController */

$themeUrl = Yii::app()->theme->baseUrl;
Yii::app()->clientScript->registerCssFile(Common::assetsTime($themeUrl . '/css/bootstrap/bootstrap-grid.min.css'));
?>
<section class="post-body" style="background-color: #E2E2E2 !important;">
    <div class="container container-wide">
        <div class="wide-box">
            <h1 class="post-title">Коллекция:<br><?= $collection->title ?></h1>
            <div class="faves__wrap">
                <?php $this->renderPartial('include/menu'); ?>
                <div class="collections__sort one-collection__sort">
                    <div class="one-collection_wrap">
                        <span class="collections__sort_header">Сортировать:</span>
                        <a href="<?= $this->createUrl('profile/collection', ['collection_id' => $collection->id, 'create_date' => $create_date]) ?>"
                           class="collections__sort_item
                        <?php if ($create_date && $create_date == true): ?> open <?php endif; ?>
                        <?php if (isset($create_date)): ?> active <?php endif; ?>">
                        <span>
                            По дате добавления
                        </span>
                        </a>
                        <a href="<?= $this->createUrl('/profile/collection', ['collection_id' => $collection->id, 'publish_date' => $publish_date]) ?>"
                           class="collections__sort_item
                        <?php if ($publish_date && $publish_date == true): ?> open <?php endif; ?>
                        <?php if (isset($publish_date) && $publish_date != 2): ?> active <?php endif; ?>">
                            <span>По дате публикации</span>
                        </a>
                    </div>
                    <div class="one-collection_edit">
                        <svg width="14" height="14" viewBox="0 0 14 14" fill="none"
                             xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                  d="M9.83594 2.04297L11.9573 4.16429L4.43223 11.6893L2.31091 9.568L9.83594 2.04297Z"
                                  stroke="black" stroke-linecap="round" stroke-linejoin="round" />
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                  d="M2.3105 9.56787L1.25 12.7499L4.432 11.6894L2.3105 9.56787V9.56787Z"
                                  stroke="black" stroke-linecap="round" stroke-linejoin="round" />
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                  d="M11.9569 4.16388L9.83594 2.04288L10.1894 1.68938C10.778 1.12092 11.7136 1.12905 12.2922 1.70765C12.8708 2.28625 12.8789 3.22181 12.3104 3.81038L11.9569 4.16388Z"
                                  stroke="black" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        <a href="#form_edit" class="collections__sort_item popup-with-form editCollection" data-collection_id="<?= $collection->id ?>">
                            <span>Редактировать коллекцию</span>
                        </a>
                    </div>
                </div>
                <div class="faves__list row posts_list">
                    <?php foreach ($posts as $post) {
                        $this->renderPartial('collections/includes/_post', ['post' => $post]);
                    } ?>
                </div>
            </div>
        </div>
    </div>
</section>
<?php $this->renderPartial('modals/create_collection'); ?>
<?php $this->renderPartial('modals/edit_collection'); ?>