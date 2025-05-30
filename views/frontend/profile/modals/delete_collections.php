<?php
$user = Yii::app()->userComponent->getUser();
$collections = Collection::model()->findAllByAttributes(['user_id' => $user->id]);
?>
<div class="form_wrap form__edit_wrap form__popup mfp-hide" id="form_edit_one">
    <form action="<?= $this->createUrl('profile/delete-post-from-collection') ?>" method="POST" id="form_edit_one"
          class="form">
        <input id="deleteFavoritePostId" type="hidden" name="post_id">

        <p class="form_header">Редактировать</p>
        <div class="edit-collection-types">
            <div id="collectionBlock" class="square-radio edit-collection-type">
                <input
                        type="checkbox"
                        id="EditCollectionType1"
                        name="type_collection"
                        value="1">
                <label for="EditCollectionType1">Удалить из коллекции</label>
                <div class="edit-collection-types-icons">
                    <svg
                            width="73"
                            height="21"
                            viewBox="0 0 73 21"
                            fill="none"
                            xmlns="http://www.w3.org/2000/svg"
                    >
                        <path
                                d="M6.19718 2.57142V2.57125H1.93949C1.75151 2.57125 1.57971 2.63957 1.45994 2.74844L6.19718 2.57142ZM6.19718 2.57142L6.21042 2.57107M6.19718 2.57142L6.21042 2.57107M6.21042 2.57107C6.37175 2.5668 6.52512 2.61333 6.64474 2.69598L6.21042 2.57107ZM6.86893 3.00103L6.86849 2.99943C6.83814 2.88762 6.76366 2.77815 6.64475 2.69598L6.86893 3.00103ZM6.86893 3.00103L7.22662 4.30173C7.2863 4.51876 7.48364 4.66915 7.70872 4.66915M6.86893 3.00103L7.70872 4.66915M7.70872 4.66915H14.6318C14.8198 4.66915 14.9916 4.73749 15.1113 4.84631L15.4477 4.47638M7.70872 4.66915L15.4477 4.47638M15.4477 4.47638L15.1113 4.84631C15.2295 4.95381 15.2856 5.08877 15.2856 5.2181V14.1341C15.2856 14.2636 15.2295 14.3985 15.1113 14.5059L15.1112 14.506M15.4477 4.47638L15.1112 14.506M15.1112 14.506C14.9916 14.6148 14.8198 14.6831 14.6318 14.6831H1.93949C1.75145 14.6831 1.57969 14.6148 1.46 14.5059L1.4599 14.5059M15.1112 14.506L1.4599 14.5059M1.4599 14.5059C1.34175 14.3985 1.28564 14.2636 1.28564 14.1341V3.1202M1.4599 14.5059L1.28564 3.1202M1.28564 3.1202C1.28564 2.99082 1.34175 2.85589 1.45993 2.74845L1.28564 3.1202Z"
                                stroke="#888888"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                        />
                        <path
                                d="M40.3335 5.99805L43.6668 9.33138L40.3335 12.6647"
                                stroke="#888888"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                        />
                        <path
                                d="M43.6668 9.3313H28.3335"
                                stroke="#888888"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                        />
                        <path
                                d="M70 4L68.792 15.4727C68.7207 16.1511 68.1488 16.6663 67.4667 16.6667H60.5333C59.8509 16.6667 59.2786 16.1514 59.2073 15.4727L58 4"
                                stroke="#888888"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                        />
                        <path
                                d="M56.3335 4H71.6668"
                                stroke="#888888"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                        />
                        <path
                                d="M61 3.99992V1.99992C61 1.63173 61.2985 1.33325 61.6667 1.33325H66.3333C66.7015 1.33325 67 1.63173 67 1.99992V3.99992"
                                stroke="#888888"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                        />
                        <path
                                d="M64 7V14"
                                stroke="#888888"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                        />
                        <path
                                d="M67.0003 7L66.667 14"
                                stroke="#888888"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                        />
                        <path
                                d="M61 7L61.3333 14"
                                stroke="#888888"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                        />
                    </svg>
                </div>
            </div>
            <div class="square-radio edit-collection-type">
                <input
                        type="checkbox"
                        id="EditCollectionType2"
                        name="type_favorite"
                        value="2">
                <label for="EditCollectionType2">Удалить из избранного</label>
                <div class="edit-collection-types-icons">
                    <svg
                            width="73"
                            height="18"
                            viewBox="0 0 73 18"
                            fill="none"
                            xmlns="http://www.w3.org/2000/svg"
                    >
                        <path d="M8.28791 12.5771L8 12.3744L7.71209 12.5771L3.50939 15.5371L5.07562 10.6491L5.1853 10.3068L4.89581 10.0938L0.795615 7.0767H5.86987H6.22929L6.34381 6.73601L7.99991 1.80909L9.65601 6.73601L9.77053 7.0767H10.13H15.2044L11.1042 10.094L10.8147 10.307L10.9244 10.6493L12.4903 15.5369L8.28791 12.5771ZM0.441238 6.81594C0.44126 6.81595 0.441282 6.81597 0.441304 6.81599L0.441238 6.81594ZM15.5588 6.81594L15.5585 6.81615C15.5586 6.81606 15.5587 6.81598 15.5588 6.8159L15.5588 6.81594ZM7.86295 1.40162C7.86292 1.40155 7.8629 1.40148 7.86288 1.40142L7.86295 1.40162Z"
                              stroke="#888888"/>
                        <path
                                d="M40.3335 5.99805L43.6668 9.33138L40.3335 12.6647"
                                stroke="#888888"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                        />
                        <path
                                d="M43.6668 9.3313H28.3335"
                                stroke="#888888"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                        />
                        <path
                                d="M70 4L68.792 15.4727C68.7207 16.1511 68.1488 16.6663 67.4667 16.6667H60.5333C59.8509 16.6667 59.2786 16.1514 59.2073 15.4727L58 4"
                                stroke="#888888"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                        />
                        <path
                                d="M56.3335 4H71.6668"
                                stroke="#888888"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                        />
                        <path
                                d="M61 3.99992V1.99992C61 1.63173 61.2985 1.33325 61.6667 1.33325H66.3333C66.7015 1.33325 67 1.63173 67 1.99992V3.99992"
                                stroke="#888888"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                        />
                        <path
                                d="M64 7V14"
                                stroke="#888888"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                        />
                        <path
                                d="M67.0003 7L66.667 14"
                                stroke="#888888"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                        />
                        <path
                                d="M61 7L61.3333 14"
                                stroke="#888888"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                        />
                    </svg>
                </div>
            </div>
        </div>
        <div class="form_section">
            <label for="choose_collection" class="form__label form__label_dark">Переместить в коллекцию</label>
            <div class="form__field">
                <select name="collection" id="choose_collection" class="form_long-input form__select">
                    <option disabled>... (без коллекции)</option>
                    <?php foreach ($collections as $collection): ?>
                        <option value="<?= $collection->id ?>"><?= $collection->title ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
        <div class="form_button_long">
            <button type="submit">
                Применить
            </button>
        </div>
    </form>
</div>