<?php
/** @var $models Post[] */
?>

<div class="b-main__month latest-news">
    <div class="b-main__list b-main__list__top">
        <ul class="news-list">
            <?php foreach ($models as $post): ?>
                <li>
                    <div class="b-main__list__image">
                        <a href="<?= $post->getUrl() ?>">
                            <img src="<?= $post->getImageUrl('image_news') ?>" alt="" width="60" height="60">
                        </a>
                    </div>
                    <a href="<?= $post->getUrl() ?>" class="b-main__list__link">
                        <time datetime="<?= date('c', strtotime($post->date)) ?>"><?= date('j.m', strtotime($post->date)) ?></time><?= $post->title ?>
                    </a>
                </li>
            <?php endforeach; ?>
            <li style="display: none"></li>
        </ul>
    </div>
</div>
