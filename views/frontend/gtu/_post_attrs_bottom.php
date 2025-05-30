<?php
/* @var $this GtuController */
/* @var $model GtuPost */
?>

<footer class="inner-article-data">
    <time class="time" datetime="<?= date('c', strtotime($model->date)) ?>"><?= date('d.m.Y', strtotime($model->date)) ?></time>

    <?php if ($model->gtuRubric !== null): ?>
        <span class="separator">|</span>
        <p class="rubric"><a href="<?= CHtml::encode($model->gtuRubric->getUrl()) ?>"><?= CHtml::encode($model->gtuRubric->getTitle()) ?></a></p>
    <?php endif; ?>

    <?php if ($model->author !== null): ?>
        <p class="author"><?= Yii::t('app', 'Author') ?>: &nbsp; <a href="<?= CHtml::encode($model->author->getUrl()) ?>"><?= CHtml::encode($model->author->title) ?></a></p>
    <?php endif; ?>

    <p class="article-views">
        <svg width="11" height="7" viewBox="0 0 11 7" fill="none">
            <path d="M0.0525379 3.32289C0.139686 3.18723 2.22511 0 5.5 0C8.77488 0 10.8603 3.18723 10.9475 3.32289C11.0175 3.43187 11.0175 3.56813 10.9475 3.67711C10.8603 3.81277 8.77488 7 5.5 7C2.22511 7 0.139686 3.81277 0.0525379 3.67711C-0.0175133 3.56813 -0.0175133 3.43187 0.0525379 3.32289ZM5.5 6.31253C7.94568 6.31253 9.72151 4.14202 10.1934 3.4997C9.72239 2.8566 7.95166 0.687511 5.5 0.687511C3.05432 0.687511 1.27849 2.85802 0.806645 3.50034C1.27761 4.1434 3.04834 6.31253 5.5 6.31253Z" fill="currentColor"></path>
            <path fill-rule="evenodd" clip-rule="evenodd" d="M7.63743 3.49998C7.63743 2.31938 6.68081 1.36243 5.49998 1.36243C4.31905 1.36243 3.36243 2.31938 3.36243 3.49998C3.36243 4.68047 4.31905 5.63743 5.49998 5.63743C6.68081 5.63743 7.63743 4.68047 7.63743 3.49998ZM6.12306 3.6308C6.60737 3.6308 6.99998 3.23819 6.99998 2.75388C6.99998 2.26957 6.60737 1.87696 6.12306 1.87696C5.63875 1.87696 5.24614 2.26957 5.24614 2.75388C5.24614 3.23819 5.63875 3.6308 6.12306 3.6308Z" fill="currentColor"></path>
        </svg>
        &nbsp;
        <?= $model->views_count ?>
    </p>
</footer>
