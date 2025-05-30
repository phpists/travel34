<div class="subscription__tariffs_wrap row">
    <?php foreach ($subscriptions as $subscription): ?>
        <div class="subscription__tariffs_item <?= $subscription->id == Subscription::FOR_YEAR ? 'active' : '' ?> <?= $subscription->id == Subscription::FAMILY ? 'blocked_subscription' : '' ?> col-12 col-us-6 col-sm-6 col-md-4 col-lg-4">
            <div>
                <div class="subscription__tariff_title">
                    <div class="subscription__tariffs_check">
                        <input type="radio" class="custom-radio" id="subscription_<?= $subscription->id ?>"
                               name="subscription"
                               required
                            <?= $subscription->id == Subscription::FOR_YEAR ? 'checked' : '' ?>
                               value="<?= $subscription->id ?>"/>
                        <div class="subscription-square-radio"></div>
                        <label for="subscription_<?= $subscription->id ?>"><?= $subscription->title ?></label>
                    </div>
                    <span class="subscription__tariffs_line"></span>
                </div>
                <?= $subscription->description ?>
                <?php if ($subscription->id == Subscription::FAMILY): ?>
                    <div class="subscription__tariffs_price">
                        Coming soon
                    </div>
                <?php else: ?>
                    <div class="subscription__tariffs_price">
                        <?php if ($subscription->old_price > 0) { ?>
                            <span class="subscription__tariffs_old-price">€ <?= number_format($subscription->old_price, 2, '.', ''); ?></span>
                        <?php } ?>
                        <span class="subscription__tariffs_new-price">€ <?= number_format($subscription->price, 2, '.', ''); ?></span>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    <?php endforeach; ?>
</div>
<div class="form_wrap_inside">
    <p class="subscriptions__item">
        Подписка на 34travel – это идеи для поездок, авторские маршруты и фирменные гайды по городам мира, большие
        разборы тревел-трендов и актуальная информация из мира перелетов, виз и границ. Оформи подписку, чтобы ничего не
        пропустить.
    </p>
</div>
<div class="form_header form_header_margin_medium">Что входит в подписку?</div>
<ul class="subscriptions__list">
    <li class="subscriptions__item">
        <div>Полный доступ к фирменным гайдам 34travel.</div>
    </li>
    <li class="subscriptions__item">
        <div>Доступ ко всем платным материалам сайта с эксклюзивными маршрутами, подробными мануалами и советами для
            путешественников.
        </div>
    </li>
    <li class="subscriptions__item">
        <div>Возможность сохранять нужные материалы в «Избранное» и создавать «Коллекции» в личном кабинете.</div>
    </li>
    <li class="subscriptions__item">
        <div>Специальные предложения от наших партнеров.</div>
    </li>
</ul>