<div class="form_wrap form__popup mfp-hide" id="subscription_cancel">
    <form action="<?= $this->createUrl('profile/subscriptionCanceled') ?>" method="POST" id="subscription__cancel" class="form form__create-collection">
        <input id="subscriptionUserId" type="hidden" name="id">

        <p class="form_header">Отменить подписку?</p>
        <div class="form_section">
            <div class="form__information_warning">
                Средства за текущий период не возвращаются, и доступ останется активным до <span id="subscriptionEndDate"></span>.
            </div>
        </div>
        <div class="form_section form_section_margin_little">
            <div class="form_button_long">
                <button type="submit">
                    ДА, ОТМЕНИТЬ ПОДПИСКУ
                </button>
            </div>
        </div>
        <div class="form_section form_section_margin_none">
            <div class="form_actions_wrapper">
                <a href="#" class="form_actions_link closeModal">
                    <svg
                        width="24"
                        height="24"
                        viewBox="0 0 24 24"
                        fill="none"
                        class="form_actions_link-icon"
                    >
                        <path d="M5 12L4.29289 11.2929L3.58579 12L4.29289 12.7071L5 12ZM17 13C17.5523 13 18 12.5523 18 12C18 11.4477 17.5523 11 17 11V13ZM8.29289 7.29289L4.29289 11.2929L5.70711 12.7071L9.70711 8.70711L8.29289 7.29289ZM4.29289 12.7071L8.29289 16.7071L9.70711 15.2929L5.70711 11.2929L4.29289 12.7071ZM5 13H17V11H5V13Z"
                              fill="#33363F"></path>
                    </svg>
                    Сохранить подписку
                </a>
            </div>
        </div>
    </form>
</div>