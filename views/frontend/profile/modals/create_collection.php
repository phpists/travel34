<div class="form_wrap form__edit_wrap form__popup mfp-hide" id="form_create">
    <form action="<?= $this->createUrl('/profile/add-collection') ?>" method="POST" id="form__create" class="form addCollectionViewFormInAccount">
        <p class="form_header">Создать коллекцию</p>
        <div class="form_section">
            <label for="name" class="form__label form__label_gray">Название коллекции</label>
            <div class="form__field">
                <input type="text" name="title" placeholder="Название коллекции" class="form_long-input" required />
            </div>
        </div>
        <div class="form_button_long">
            <button type="submit">Создать
                <svg width="14" height="24" viewBox="0 0 14 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" clip-rule="evenodd"
                          d="M8.1125 11.9707L0.472152 23.7257L5.37154 23.7257L13.012 11.9707L5.37162 0.215641L0.472152 0.215633L8.1125 11.9707Z"
                          fill="black" />
                </svg>
            </button>
        </div>
    </form>
</div>