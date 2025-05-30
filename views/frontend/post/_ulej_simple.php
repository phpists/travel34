<?php
// ulej-tips--blue
// ulej-tips--violet
// ulej-tips--light-blue
// ulej-tips--green

$block = BlockAfterPostHelper::get();
?>
<style>
    .ulej-tips {
        padding-top: 66px;
    }
    .ulej-tips-subheading {
        max-width: 380px;
        margin-top: 35px;
        padding-bottom: 0;
    }
    @media screen and (min-width: 580px) {
        .ulej-tips-btn {
            margin-top: 50px;
        }
    }
    .ulej-tips--yellow {
        background-color: #ffe04e !important;
    }
    .ulej-tips-btn:hover {
        /*background-color: #f9e586 !important;*/
    }
</style>
<?php if ($block instanceof BlockAfterPost): ?>
<section class="ulej-tips-section">
    <div class="ulej-tips ulej-tips--yellow" style="background-color: <?= $block->background_color ?> !important;">
        <section class="ulej-tips-content">
            <div class="ulej-tips-header">
                <?php if ($block->image): ?>
                    <img src="<?= $block->getImageUrl('image') ?>" alt="hand with heart" class="ulej-tips-img">
                <?php endif ?>
                <?php if ($block->title): ?>
                    <h2 class="ulej-tips-heading" style="color: <?= $block->text_color ?> !important;"><?= $block->title ?></h2>
                <?php endif; ?>
            </div>
            <div class="ulej-tips-body">
                <?php if ($block->text): ?>
                    <p class="ulej-tips-subheading" style="color: <?= $block->text_color ?> !important;"><?= $block->text ?></p>
                <?php endif; ?>
                <?php if ($block->button_text && $block->button_url): ?>
                    <a href="<?= $block->button_url ?>" role="button" class="ulej-tips-btn" target="_blank"
                       onmouseover="this.style.backgroundColor='<?= $block->button_hover_color ?>'"
                       onmouseout="this.style.backgroundColor='<?= $block->button_color ?>'"
                       style="background-color: <?= $block->button_color ?>; color: <?= $block->button_text_color ?> !important"><?= $block->button_text ?></a>
                <?php endif; ?>
            </div>
        </section>
    </div>
</section>
<?php endif; ?>