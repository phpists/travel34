<?php
/* @var $this ProfileController */
?>
<div class="post-body" style="background-color: #E2E2E2 !important;">
    <div class="container-wide container-form">
        <div classs="wide-box">
            <h1 class="post-title">Управление подпиской</h1>
            <div class="form_wrap">
                <div class="form_wrap_inside">
                    <div class="form_header form_header_margin">Моя подписка</div>
                    <div class="form_text_line">Семейная подписка на 1 год (автопродление)</div>
                    <div class="form_section">
                        <div class="form_short-text form_short-text_left form_short-text_margin">Вы можете добавить еще
                            один аккаунт в семейную подписку
                        </div>

                        <form action="" method="" id="add_account" class="form_short">
                            <label for="" class="form__label form__label_gray">E-mail аккаунта, который хотите
                                добавить:</label>
                            <div class="flex__wrap">
                                <div class="form__field form__field_short">
                                    <input type="text" name="add_acc" id="add_acc" placeholder="34family@gmail.com"
                                           required/>
                                </div>
                                <div class="form_short_btn">
                                    <button>Добавить</button>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="form_section form__info_wrap">
                        <div class="form__label form__label_black form_date_wrap"><span class="form__info_text">Дата начала подписки:</span><span>1 июня 2024</span>
                        </div>
                        <div class="form__label form__label_black form_status_wrap"><span class="form__info_text">Статус подписки:</span><span
                                    class="form_status">активна</span></div>
                        <div class="form__label form__label_black form_ordernum_wrap"><span class="form__info_text">Номер заказа</span><span>#123456789</span>
                        </div>
                    </div>
                    <div class="form_section">
                        <a href="/" class="form_simple_link form_short-text_left">Отменить подписку</a>
                    </div>
                    <a href="/" class="form_link">Изменить план</a>
                </div>
            </div>
        </div>
    </div>
</div>