<div class="form_wrap form__edit_wrap form__popup mfp-hide" id="form_edit">
    <form action="<?= $this->createUrl('/profile/update-collection') ?>" method="POST" id="form__edit" class="form">
        <input type="hidden" id="editCollectionId" name="collection_id">
        <p class="form_header">Редактировать</p>
        <div class="form_section">
            <label for="name" class="form__label form__label_gray">Название коллекции</label>
            <div class="form__field">
                <input type="text" name="title" id="editCollectionTitle" placeholder="Название коллекции" class="form_long-input" required />
            </div>
        </div>
        <div class="form_button_long">
            <button type="submit">Сохранить
                <svg width="14" height="24" viewBox="0 0 14 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" clip-rule="evenodd"
                          d="M8.1125 11.9707L0.472152 23.7257L5.37154 23.7257L13.012 11.9707L5.37162 0.215641L0.472152 0.215633L8.1125 11.9707Z"
                          fill="black" />
                </svg>
            </button>
        </div>
    </form>
    <a id="deleteCollection" href="/" class="form__link_img">
        <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
            <g clip-path="url(#clip0_51_5467)">
                <path d="M1 3.5H13" stroke="#A5A5A5" stroke-linecap="round" stroke-linejoin="round" />
                <path
                    d="M2.5 3.5H11.5V12.5C11.5 12.7652 11.3946 13.0196 11.2071 13.2071C11.0196 13.3946 10.7652 13.5 10.5 13.5H3.5C3.23478 13.5 2.98043 13.3946 2.79289 13.2071C2.60536 13.0196 2.5 12.7652 2.5 12.5V3.5Z"
                    stroke="#A5A5A5" stroke-linecap="round" stroke-linejoin="round" />
                <path
                    d="M4.5 3.5V3C4.5 2.33696 4.76339 1.70107 5.23223 1.23223C5.70107 0.763392 6.33696 0.5 7 0.5C7.66304 0.5 8.29893 0.763392 8.76777 1.23223C9.23661 1.70107 9.5 2.33696 9.5 3V3.5"
                    stroke="#A5A5A5" stroke-linecap="round" stroke-linejoin="round" />
                <path d="M5.5 6.50146V10.503" stroke="#A5A5A5" stroke-linecap="round" stroke-linejoin="round" />
                <path d="M8.5 6.50146V10.503" stroke="#A5A5A5" stroke-linecap="round" stroke-linejoin="round" />
            </g>
            <defs>
                <clipPath id="clip0_51_5467">
                    <rect width="14" height="14" fill="white" />
                </clipPath>
            </defs>
        </svg>
        <span>Удалить коллекцию</span>
    </a>
</div>