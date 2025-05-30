<?php
$user = Yii::app()->userComponent->getUser();
$collections = Collection::model()->findAllByAttributes(['user_id' => $user->id]);
?>

<div class="form_wrap form__add_wrap form__popup mfp-hide" id="form_add">
    <form action="<?= $this->createUrl('/profile/add-favorite') ?>" method="POST" id="form__add" class="form">
        <input id="favoritePostId" type="hidden" name="post_id">
        <p class="form_header">Добавить в избранное</p>
        <div class="form_section form_section_margin_little">
            <label for="choose_collection" class="form__label form__label_gray">Выбрать коллекцию</label>
            <div class="form__field">
                <select name="collection_id" id="choose_collection" class="form_long-input form__select">
                    <option value="" disabled selected>... (без коллекции)</option>
                    <?php foreach ($collections as $collection): ?>
                        <option value="<?= $collection->id ?>"><?= $collection->title ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
        <div class="form_section">
            <div class="form_button_long">
                <button type="submit">Применить
                    <svg width="14" height="24" viewBox="0 0 14 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                              d="M8.1125 11.9707L0.472152 23.7257L5.37154 23.7257L13.012 11.9707L5.37162 0.215641L0.472152 0.215633L8.1125 11.9707Z"
                              fill="black"/>
                    </svg>
                </button>
            </div>
        </div>
    </form>
    <a href="#form_create_collection" class="popup-with-form form__link_with-back">
        <svg width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
            <rect x="4.5" width="3" height="12" fill="black"/>
            <rect width="3" height="12" transform="matrix(0 -1 -1 0 12 7.5)" fill="black"/>
        </svg>
        <span>Создать коллекцию</span>
    </a>
</div>

