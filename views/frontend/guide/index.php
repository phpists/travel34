<?php
/* @var $this GuideController */
/* @var $form CActiveForm */
/* @var $model HasIdeaForm */
/* @var $dataProvider CActiveDataProvider */
/* @var $names array */
/* @var $guidesImage string */

$themeUrl = Yii::app()->theme->baseUrl;

/** @var CClientScript $cs */
$cs = Yii::app()->clientScript;

$js = <<<JS
$('a.open-popup').magnificPopup({
    items: {
        src: '#help-form',
        type: 'inline'
    },
    midClick: true,
    removalDelay: 160,
    preloader: false,
    closeBtnInside: true,
    fixedContentPos: true
});
JS;

$cs->registerCssFile(Common::assetsTime($themeUrl . '/css/magnific-popup.css'));
$cs->registerScriptFile(Common::assetsTime($themeUrl . '/js/jquery.magnific-popup.min.js'));
$cs->registerScript('mfp-guides', $js, CClientScript::POS_READY);

$js = <<<JS
function hasIdeaFormSubmit(form, data, hasError) {
    if (!hasError) {
        jQuery.post(form.attr('action'), form.serialize(), function (res) {
            var resText = '', _cont = form.parent();
            if (res.status == 'ok') {
                resText = '<p class="big">Спасибо!</p><p>Мы обязательно все прочтем!</p>';
            } else {
                resText = '<p class="big">Ошибка!</p><p>Сообщение не отправлено!</p>';
            }
            _cont.find('p, form').remove();
            _cont.append(resText);
        }, 'json');
        return false;
    }
}
JS;
$cs->registerScript('has-idea-form-submit', $js, CClientScript::POS_END);

/* @var $posts Post[] */
$posts = $dataProvider->getData();

$pagination = $dataProvider->getPagination();

$totalNames = count($names);
$by4 = ceil($totalNames / 4);
?>

<div class="hero-image"<?php if (!empty($guidesImage)): ?> style="background-image: url('<?= $guidesImage ?>')"<?php endif; ?>>
    <div class="container">
        <div class="content">
            <p>Фирменные гайды от 34travel – это авторские путеводители по главным городам Европы и мира.
                Туристическая классика и инсайты от местных, топовые достопримечательности и скрытые от
                любопытных глаз заведения – мы выбираем только места, которые помогают прочувствовать дух и
                атмосферу городов. Как добраться, где жить и чем развлечься – в подробных путеводителях по Минску,
                Вильнюсу, Варшаве и другим любимым направлениям.</p>
        </div>
    </div>
</div>

<div class="b-main b-list-posts">
    <div class="guide-nav">
        <h5>Все гайды:</h5>
        <ul>
            <li>
                <ul>
                    <?php
                    $count = 0;
                    foreach ($names as $one) {
                        if ($count > 0 && $count % $by4 == 0 && $count < $totalNames) {
                            echo '</ul></li><li><ul>';
                        }
                        if ($one['type_id'] == Post::TYPE_MINIGUIDE && $one['is_new']) {
                            ?>
                            <li class="mini new"><a href="<?= $one['url'] ?>"><?= CHtml::encode($one['title']) ?></a><span>new</span><sup>mini</sup></li>
                            <?php
                        } elseif ($one['type_id'] == Post::TYPE_MINIGUIDE) {
                            ?>
                            <li class="mini"><a href="<?= $one['url'] ?>"><?= CHtml::encode($one['title']) ?></a><sup>mini</sup></li>
                            <?php
                        } elseif ($one['is_new']) {
                            ?>
                            <li class="new"><a href="<?= $one['url'] ?>"><?= CHtml::encode($one['title']) ?></a><span>new</span></li>
                            <?php
                        } else {
                            ?>
                            <li><a href="<?= $one['url'] ?>"><?= CHtml::encode($one['title']) ?></a></li>
                            <?php
                        }
                        $count++;
                    }
                    ?>
                </ul>
            </li>
        </ul>
    </div>

    <div class="b-news__short__list">
        <?php
        foreach ($posts as $post) {
            //$this->renderPartial('//site/_post_small_top', array('post' => $post));
            $this->renderPartial('//site/_post_simple', array('post' => $post));
        }
        ?>
    </div>
    <?php $this->widget('application.widgets.SitePager', array(
        'showMoreText' => 'Показать еще',
        'pages' => $pagination,
    )); ?>
</div>
