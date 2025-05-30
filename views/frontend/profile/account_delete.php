<div class="post-body" style="background-color: #E2E2E2 !important;">
    <div class="container-wide container-form">
        <div class="wide-box">
            <h1 class="post-title">Удаление аккаунта</h1>
            <div class="form_wrap form_wrap_short">
                <div class="form_wrap_inside form_wrap_inside_wide">
                    <div class="form__information_warning">
                        <p>
                            Удалив аккаунт, ты потеряешь все коллекции
                            и доступ к подписке.
                        </p>
                        <p>
                            Уверен(-а), что хочешь безвозвратно удалить аккаунт?
                        </p>
                    </div>
                    <a href="<?= $this->createUrl('profile/account-delete?is_delete=true') ?>" class="form_link form-link_margin">ДА, УДАЛИТЬ АККАУНТ</a>
                    <div class="form_actions_wrapper">
                        <a href="<?= Yii::app()->request->urlReferrer ?>" class="form_actions_link">
                            <svg
                                width="24"
                                height="24"
                                viewBox="0 0 24 24"
                                fill="none"
                                class="form_actions_link-icon"
                            >
                                <path d="M5 12L4.29289 11.2929L3.58579 12L4.29289 12.7071L5 12ZM17 13C17.5523 13 18 12.5523 18 12C18 11.4477 17.5523 11 17 11V13ZM8.29289 7.29289L4.29289 11.2929L5.70711 12.7071L9.70711 8.70711L8.29289 7.29289ZM4.29289 12.7071L8.29289 16.7071L9.70711 15.2929L5.70711 11.2929L4.29289 12.7071ZM5 13H17V11H5V13Z" fill="#33363F"/>
                            </svg>
                            Вернуться в аккаунт
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>