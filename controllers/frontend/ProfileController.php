<?php


class ProfileController extends FrontEndController
{
    public function actionAccount()
    {
        $this->pageTitle = '34travel.me - Мой аккаунт';

        if (!Yii::app()->userComponent->isAuthenticated()) {
            $this->redirect('/login');
        }

        $user = Yii::app()->userComponent->getUser();
        $userSubscriptions = UserSubscription::model()->with('subscription')->findAllByAttributes([
            'user_id' => $user->id,
            'subscription_type' => Subscription::MYSELF
        ]);

        $this->render('account', [
            'user' => $user,
            'userSubscriptions' => $userSubscriptions,
        ]);
    }

    public function actionAccountSettings()
    {
        $user = Yii::app()->userComponent->getUser();

        $this->render('account_setting', [
            'user' => $user
        ]);
    }

    public function actionAccountDelete()
    {
        if (isset($_GET['is_delete']) && $_GET['is_delete']) {
            $user = Yii::app()->userComponent->getUser();

            if ($user) {
                $userModel = User::model()->findByAttributes(['id' => $user->id]);
                if ($userModel) {
                    SubscriptionComponent::sendAccountDeleteEmail($userModel->email);
                    $userModel->delete();
                }

                $subscriptions = UserSubscription::model()->findAllByAttributes(['user_id' => $user->id]);
                foreach ($subscriptions as $subscription) {
                    $subscription->delete();
                }

                $collections = UserCollection::model()->findAllByAttributes(['user_id' => $user->id]);
                foreach ($collections as $collection) {
                    $collection->delete();
                }

                Yii::app()->user->logout();

                $this->redirect(Yii::app()->homeUrl);
            } else {
                throw new CHttpException(404, 'Користувача не знайдено.');
            }
        }

        $this->render('account_delete');
    }

    public function actionManageSubscriptions()
    {
        $user = Yii::app()->userComponent->getUser();
        $subscription = UserSubscription::model()->findByAttributes([
            'user_id' => $user->id,
            'status_id' => UserSubscription::SUCCESS,
            'subscription_type' => UserSubscription::MYSELF,
        ], [
            'order' => 'id DESC'
        ]);

        if ($subscription) {
            $this->redirect('/subscription/f9/update-subscription?subscription=' . $subscription->id);
        } else {
            $this->redirect('/subscription/f11/step-one');
        }
    }

    public function actionSubscriptionFamilyAdd()
    {
        if (!Yii::app()->userComponent->isAuthenticated()) {
            $this->redirect('/login');
        }

        $this->render('subscription_family_add');
    }

    public function actionSubscriptionCanceled()
    {
        $user = Yii::app()->userComponent->getUser();
        $userSubscription = UserSubscription::model()->findByPk($_POST['id']);
        if ($userSubscription) {
            $userSubscription->is_active = UserSubscription::CANCELED;
            $userSubscription->update();

            SubscriptionComponent::sendUnsubscribeEmail($user->email);
        }

        $this->redirect(Yii::app()->request->urlReferrer);
    }

    /**
     * Активація підписки при кліку на кнопку активації
     */
    public function actionSubscriptionActivate()
    {
        $user = Yii::app()->userComponent->getUser();
        $userSubscription = UserSubscription::model()->findByPk($_GET['id']);
        $gift = UserSubscriptionGift::model()->findByPk($_GET['gift_id']);

        $loginUserSubscription = UserSubscription::model()->findByAttributes([
            'user_id' => $user->id,
            'subscription_type' => Subscription::MYSELF
        ], [
            'order' => 'id DESC'
        ]);

        if (!$userSubscription) {
            $this->redirect(Yii::app()->request->urlReferrer);
        }

        UserSubscription::model()->updateAll(
            ['is_auto_renewal' => 0],
            'user_id = :user_id',
            [
                ':user_id' => isset($user) ? $user->id : null,
            ]
        );

        $subscription = Subscription::model()->findByPk($userSubscription->subscription_id);
        if ($loginUserSubscription) {
            $subscriptionDate = $subscription->getSubscriptionDates($loginUserSubscription['date_start'], $loginUserSubscription['date_end']);

            $userSubscription->user_id = isset($user) ? $user->id : null;
            $userSubscription->subscription_id = $subscription->id;
            $userSubscription->status_id = UserSubscription::SUCCESS;
            $userSubscription->subscription_type = Subscription::MYSELF;
            $userSubscription->date_start = $subscriptionDate['date_start'];
            $userSubscription->date_end = $subscriptionDate['date_end'];
            $userSubscription->created_at = date('Y-m-d H:i:s');
            $userSubscription->updated_at = date('Y-m-d H:i:s');
            $userSubscription->position = $loginUserSubscription->position + 1;
            $userSubscription->is_active = UserSubscription::INACTIVE;
            $userSubscription->is_auto_renewal = UserSubscription::INACTIVE;
            $userSubscription->save();
        } else {
            $subscriptionDate = $subscription->getGiftSubscriptionDates($gift['gift_date']);

            $userSubscription->user_id = isset($user) ? $user->id : null;
            $userSubscription->subscription_id = $subscription->id;
            $userSubscription->status_id = UserSubscription::SUCCESS;
            $userSubscription->subscription_type = Subscription::MYSELF;
            $userSubscription->date_start = $subscriptionDate['date_start'];
            $userSubscription->date_end = $subscriptionDate['date_end'];
            $userSubscription->created_at = date('Y-m-d H:i:s');
            $userSubscription->updated_at = date('Y-m-d H:i:s');
            $userSubscription->position = 1;
            $userSubscription->is_active = UserSubscription::ACTIVE;
            $userSubscription->is_auto_renewal = UserSubscription::INACTIVE;
            $userSubscription->save();
        }

        if ($gift) {
            $gift->status_id = UserSubscriptionGift::ACTIVE;
            $gift->available_activations = 1;
            $gift->save();
        }

        $this->redirect(Yii::app()->request->urlReferrer);
    }

    /**
     * Активація підписки при кліку на посилання активації з листа
     */
    public function actionActivateGift()
    {
        $encryptedId = Yii::app()->request->getParam('token');
        $giftId = UserSubscriptionGift::decryptId(urldecode($encryptedId));

        $gift = UserSubscriptionGift::model()->findByPk($giftId);
        $userSubscription = UserSubscription::model()->findByPk($gift->user_subscription_id);
        $user = User::model()->findByAttributes(['email' => $gift->gift_email]);

        $loginUserSubscription = UserSubscription::model()->findByAttributes([
            'user_id' => $user->id,
            'subscription_type' => Subscription::MYSELF
        ], [
            'order' => 'id DESC'
        ]);

        if (!$userSubscription) {
            $this->redirect(Yii::app()->request->urlReferrer);
        }

        $subscription = Subscription::model()->findByPk($userSubscription->subscription_id);
        if ($loginUserSubscription) {
            $subscriptionDate = $subscription->getSubscriptionDates($loginUserSubscription['date_start'], $loginUserSubscription['date_end']);

            $userSubscription->user_id = isset($user) ? $user->id : null;
            $userSubscription->subscription_id = $subscription->id;
            $userSubscription->status_id = UserSubscription::SUCCESS;
            $userSubscription->subscription_type = Subscription::MYSELF;
            $userSubscription->date_start = $subscriptionDate['date_start'];
            $userSubscription->date_end = $subscriptionDate['date_end'];
            $userSubscription->created_at = date('Y-m-d H:i:s');
            $userSubscription->updated_at = date('Y-m-d H:i:s');
            $userSubscription->position = $loginUserSubscription->position + 1;
            $userSubscription->is_active = UserSubscription::INACTIVE;
            $userSubscription->is_auto_renewal = UserSubscription::INACTIVE;
            $userSubscription->save();
        } else {
            $subscriptionDate = $subscription->getGiftSubscriptionDates($gift['gift_date']);

            $userSubscription->user_id = isset($user) ? $user->id : null;
            $userSubscription->subscription_id = $subscription->id;
            $userSubscription->status_id = UserSubscription::SUCCESS;
            $userSubscription->subscription_type = Subscription::MYSELF;
            $userSubscription->date_start = $subscriptionDate['date_start'];
            $userSubscription->date_end = $subscriptionDate['date_end'];
            $userSubscription->created_at = date('Y-m-d H:i:s');
            $userSubscription->updated_at = date('Y-m-d H:i:s');
            $userSubscription->position = 1;
            $userSubscription->is_active = UserSubscription::ACTIVE;
            $userSubscription->is_auto_renewal = UserSubscription::INACTIVE;
            $userSubscription->save();
        }

        if ($gift) {
            $gift->status_id = UserSubscriptionGift::ACTIVE;
            $gift->available_activations = 1;

            if ($gift->save()) {
                Yii::app()->session['user_id'] = $user->id;
                Yii::app()->session['user_email'] = $user->email;
            }
        }

        $this->redirect('/profile/account');
    }

    public function actionSubscriptionPromoActivate()
    {
        $user = Yii::app()->userComponent->getUser();
        $promoCode = strtolower(Yii::app()->request->getPost('promo'));
        if (!$promoCode) {
            return ['status' => 'error', 'message' => 'Промокод не передан'];
        }

        $defaultPromoCode = PromoCode::model()->find('promo_code = :promo', [':promo' => $promoCode]);
        if ($defaultPromoCode) {
            return $this->renderJSON([
                'status' => 'error',
                'message' => 'Упс! Похоже, этот промокод предоставляет скидку, а не подписку в подарок. Введи его при оплате выбранного тарифного плана.'
            ]);
        }

        $statusIds = [UserSubscriptionGift::SEND_CLIENT, UserSubscriptionGift::INACTIVE];
        $criteria = new CDbCriteria([
            'condition' => 'LOWER(code) = :promo_code AND gift_email = :gift_email AND status_id IN (' . implode(',', $statusIds) . ')',
            'params' => [
                ':promo_code' => $promoCode,
                ':gift_email' => $user->email
            ],
        ]);

        $gift = UserSubscriptionGift::model()->find($criteria);
        if (!$gift) {
            return $this->renderJSON([
                'status' => 'error',
                'message' => 'Упс! К сожалению, этот промокод уже неактивен.'
            ]);
        }

        $user = Yii::app()->userComponent->getUser();
        $subscriptionId = json_decode($gift->type_id, true);
        $subscription = Subscription::model()->findByPk($subscriptionId);
        if (!$subscription) {
            return $this->renderJSON([
                'status' => 'error',
                'message' => 'Неверный тип подписки'
            ]);
        }

        $existingSubscription = UserSubscription::model()->findByAttributes([
            'user_id' => $user->id,
            'status_id' => UserSubscription::SUCCESS,
        ], [
            'order' => 'id DESC'
        ]);

        if ($existingSubscription) {
            $subscriptionDate = $subscription->getSubscriptionDates($existingSubscription->date_start, $existingSubscription->date_end);
            $isActive = UserSubscription::INACTIVE;
        } else {
            $subscriptionDate = $subscription->getSubscriptionDates();
            $isActive = UserSubscription::ACTIVE;
        }

        if (!$subscriptionDate) {
            return $this->renderJSON([
                'status' => 'error',
                'message' => 'Не удалось получить даты подписки'
            ]);
        }

        $userSubscription = new UserSubscription();
        $userSubscription->user_id = $user->id;
        $userSubscription->subscription_id = $subscriptionId;
        $userSubscription->status_id = UserSubscription::SUCCESS;
        $userSubscription->subscription_type = Subscription::MYSELF;
        $userSubscription->date_start = $subscriptionDate['date_start'];
        $userSubscription->date_end = $subscriptionDate['date_end'];
        $userSubscription->is_active = $isActive;

        if ($userSubscription->save()) {
            $gift->status_id = UserSubscriptionGift::USED;
            $gift->available_activations = 1;
            $gift->update();

            return $this->renderJSON([
                'status' => 'success',
                'message' => 'Подарочный промокод применен!'
            ]);
        }

        return $this->renderJSON([
            'status' => 'error',
            'message' => 'Не вдалося застосувати промокод'
        ]);
    }


    public function actionFavorites()
    {
        $this->pageTitle = '34travel.me - Избранное';

        if (!Yii::app()->userComponent->isAuthenticated()) {
            $this->redirect('/login');
        }
        $params = $_GET;
        $user = Yii::app()->userComponent->getUser();
        $criteria = new CDbCriteria;
        $criteria->select = '*';
        $criteria->alias = 'p';
        $criteria->with = array(
            'userCollections' => array(
                'condition' => 'userCollections.user_id = :userId',
                'params' => array(
                    ':userId' => $user->id,
                ),
                'together' => true,
            ),
        );
        $criteria->together = true;

        if (isset($params['publish_date'])) {
            if ($params['publish_date'] == true) {
                $publishDate = 0;
                $criteria->order = 'userCollections.created_at ASC';
            } else {
                $publishDate = 1;
                $criteria->order = 'userCollections.created_at DESC';
            }
        } else {
            if ($params['create_date'] == null) {
                $publishDate = 1;
                $criteria->order = 'userCollections.created_at DESC';
            }
        }

        if (isset($params['create_date'])) {
            if ($params['create_date'] == true) {
                $createDate = 0;
                $criteria->order = 'p.created_at ASC';
            } else {
                $createDate = 1;
                $criteria->order = 'p.created_at DESC';
            }
        } else {
            if ($params['publish_date'] == null) {
                $createDate = 1;
                $criteria->order = 'p.created_at DESC';
            }
        }

        if ($params['create_date'] == null && $params['publish_date'] == null) {
            $params['create_date'] = 1;
            $createDate = 1;
            $publishDate = 2;
            $criteria->order = 'userCollections.created_at DESC';
        }

        $posts = Post::model()->findAll($criteria);

        $this->render('favorites/favorites', [
            'posts' => $posts,
            'publish_date' => $publishDate,
            'create_date' => $createDate
        ]);
    }

    public function actionCollections()
    {
        $this->pageTitle = '34travel.me - Коллекции';

        if (!Yii::app()->userComponent->isAuthenticated()) {
            $this->redirect('/login');
        }
        $params = $_GET;

        $user = Yii::app()->userComponent->getUser();
        $criteria = new CDbCriteria();
        $criteria->select = '*';
        $criteria->alias = 'c';
        $criteria->join = 'LEFT JOIN tr_user_collection uc ON uc.collection_id = c.id';
        $criteria->condition = 'c.user_id = :userId';
        $criteria->params = array(':userId' => $user->id);
        $criteria->group = 'c.id';

        if (isset($params['publish_date'])) {
            if ($params['publish_date'] == true) {
                $publishDate = 0;
                $criteria->order = 'c.id ASC';
            } else {
                $publishDate = 1;
                $criteria->order = 'c.id DESC';
            }
        } else {
            if ($params['create_date'] == null) {
                $publishDate = 1;
                $criteria->order = 'c.id DESC';
            }
        }

        if (isset($params['create_date'])) {
            if ($params['create_date'] == true) {
                $createDate = 0;
                $criteria->order = 'c.created_at ASC';
            } else {
                $createDate = 1;
                $criteria->order = 'c.created_at DESC';
            }
        } else {
            if ($params['publish_date'] == null) {
                $createDate = 1;
                $criteria->order = 'c.created_at DESC';
            }
        }

        if ($params['create_date'] == null && $params['publish_date'] == null) {
            $params['create_date'] = 1;
            $createDate = 1;
            $publishDate = 2;
            $criteria->order = 'c.created_at DESC';
        }

        $collections = Collection::model()->findAll($criteria);

        $this->render('collections/collections', [
            'collections' => $collections,
            'publish_date' => $publishDate,
            'create_date' => $createDate
        ]);
    }

    public function actionCollection()
    {
        $this->pageTitle = '34travel.me - Мои коллекции';

        if (!Yii::app()->userComponent->isAuthenticated()) {
            $this->redirect('/login');
        }
        $params = $_GET;
        $user = Yii::app()->userComponent->getUser();
        $collection = Collection::model()->findByAttributes(['id' => $params['collection_id']]);

        $criteria = new CDbCriteria;
        $criteria->select = '*';
        $criteria->alias = 'p';
        $criteria->with = array(
            'userCollections' => array(
                'condition' => 'userCollections.collection_id = :collectionId AND userCollections.user_id = :userId',
                'params' => array(
                    ':collectionId' => $collection->id,
                    ':userId' => $user->id,
                ),
                'together' => true,
            ),
        );
        $criteria->together = true;

        if (isset($params['publish_date'])) {
            if ($params['publish_date'] == true) {
                $publishDate = 0;
                $criteria->order = 'p.date ASC';
            } else {
                $publishDate = 1;
                $criteria->order = 'p.date DESC';
            }
        } else {
            if ($params['create_date'] == null) {
                $publishDate = 1;
                $criteria->order = 'p.date DESC';
            }
        }

        if (isset($params['create_date'])) {
            if ($params['create_date'] == true) {
                $createDate = 0;
                $criteria->order = 'p.created_at ASC';
            }
        } else {
            if ($params['publish_date'] == null) {
                $createDate = 1;
                $criteria->order = 'p.created_at DESC';
            }
        }

        if ($params['create_date'] == null && $params['publish_date'] == null) {
            $params['create_date'] = 1;
            $createDate = 1;
            $publishDate = 2;
            $criteria->order = 'p.created_at DESC';
        }

        $posts = Post::model()->findAll($criteria);

        $this->render('collections/collection', [
            'user' => $user,
            'posts' => $posts,
            'collection' => $collection,
            'publish_date' => $publishDate,
            'create_date' => $createDate
        ]);
    }

    public function actionAddCollection()
    {
        if (!Yii::app()->userComponent->isAuthenticated()) {
            $this->redirect('/login');
        }
        $params = $_POST;
        $user = Yii::app()->userComponent->getUser();

        $collection = new Collection();
        $collection->title = $params['title'];
        $collection->user_id = $user->id;
        $collection->save();

        return $this->renderJSON([
            'status' => true,
        ]);
    }

    public function actionEditCollection()
    {
        if (!Yii::app()->userComponent->isAuthenticated()) {
            $this->redirect('/login');
        }
        $params = $_POST;
        $collection = Collection::model()->findByAttributes(['id' => $params['collection_id']]);

        if (empty($collection)) {
            return [];
        }

        return $this->renderJSON([
            'collection' => $collection,
            'delete_collection' => $this->createUrl('/profile/', ['delete-collection' => $collection->id])
        ]);
    }

    public function actionUpdateCollection()
    {
        if (!Yii::app()->userComponent->isAuthenticated()) {
            $this->redirect('/login');
        }
        $params = $_POST;
        $collection = Collection::model()->findByAttributes(['id' => $params['collection_id']]);

        if ($collection) {
            $collection->title = $params['title'];
            $collection->save();
        }

        $this->redirect('/profile/collections');
    }

    public function actionDeleteCollection()
    {
        if (!Yii::app()->userComponent->isAuthenticated()) {
            $this->redirect('/login');
        }
        $params = $_GET;
        $collection = Collection::model()->findByAttributes(['id' => $params['collection_id']]);

        if ($collection) {
            $user = Yii::app()->userComponent->getUser();
            $userCollection = UserCollection::model()->findByAttributes([
                'collection_id' => null,
                'user_id' => $user->id
            ]);

            $collection->delete();

            if ($userCollection) {
                $userCollection->update();
            }
        }

        $this->redirect('/profile/collections');
    }

    public function actionAddFavorite()
    {
        if (!Yii::app()->userComponent->isAuthenticated()) {
            $this->redirect('/login');
        }
        $params = $_POST;
        $user = Yii::app()->userComponent->getUser();

        $userCollection = UserCollection::model()->findByAttributes([
            'post_id' => $params['post_id'],
            'user_id' => $user->id,
        ]);

        if ($userCollection) {
            if ($params['collection_id']) {
                $userCollection->collection_id = $params['collection_id'];
            }
            $userCollection->save();
        } else {
            $userCollection = new UserCollection();
            $userCollection->post_id = $params['post_id'];
            $userCollection->user_id = $user->id;

            if ($params['collection_id']) {
                $userCollection->collection_id = $params['collection_id'];
            }
            $userCollection->save();
        }

        $this->redirect(Yii::app()->user->returnUrl);
    }

    public function actionDeleteCollectionPost()
    {
        if (!Yii::app()->userComponent->isAuthenticated()) {
            $this->redirect('/login');
        }
        $params = $_GET;
        $user = Yii::app()->userComponent->getUser();

        $userCollectionPost = UserCollection::model()->findByAttributes([
            'post_id' => $params['post_id'],
            'user_id' => $user->id
        ]);

        if ($userCollectionPost) {
            $userCollectionPost->delete();
        }
    }

    public function actionAddFavoriteFromPost()
    {
        if (!Yii::app()->userComponent->isAuthenticated()) {
            $this->redirect('/login');
        }
        $params = $_POST;
        $user = Yii::app()->userComponent->getUser();

        $userCollection = UserCollection::model()->findByAttributes([
            'post_id' => $params['post_id'],
            'user_id' => $user->id,
        ]);

        if ($userCollection) {
            if ($params['collection_id']) {
                $userCollection->collection_id = $params['collection_id'];
            } else {
                $userCollection->collection_id = null;
            }
            $userCollection->save();
        } else {
            $userCollection = new UserCollection();
            $userCollection->post_id = $params['post_id'];
            $userCollection->user_id = $user->id;

            if ($params['collection_id']) {
                $userCollection->collection_id = $params['collection_id'];
            } else {
                $userCollection->collection_id = null;
            }
            $userCollection->save();
        }

        return $this->renderJSON([
            'status' => true,
            'is_reload' => $params['is_reload']
        ]);
    }

    public function actionAddCollectionFromPost()
    {
        if (!Yii::app()->userComponent->isAuthenticated()) {
            $this->redirect('/login');
        }
        $params = $_POST;
        $user = Yii::app()->userComponent->getUser();

        $collection = new Collection();
        $collection->title = $params['title'];
        $collection->user_id = $user->id;
        $collection->save();

        return $this->renderJSON([
            'status' => true,
            'collection' => $collection
        ]);
    }

    public function actionDeleteFromUserCollection()
    {
        if (!Yii::app()->userComponent->isAuthenticated()) {
            $this->redirect('/login');
        }
        $params = $_GET;
        $user = Yii::app()->userComponent->getUser();

        $userCollectionPost = UserCollection::model()->findByAttributes([
            'post_id' => $params['post_id'],
            'user_id' => $user->id
        ]);

        if ($userCollectionPost) {
            $userCollectionPost->collection_id = null;
            $userCollectionPost->update();
        }

        return $this->renderJSON([
            'status' => true,
        ]);
    }

    public function actionDeleteFromFavorites()
    {
        if (!Yii::app()->userComponent->isAuthenticated()) {
            $this->redirect('/login');
        }
        $params = $_GET;
        $user = Yii::app()->userComponent->getUser();

        $userCollectionPost = UserCollection::model()->findByAttributes([
            'post_id' => $params['post_id'],
            'user_id' => $user->id
        ]);

        if ($userCollectionPost) {
            $userCollectionPost->delete();
        }

        return $this->renderJSON([
            'status' => true,
        ]);
    }

    public function actionDeletePostFromCollection()
    {
        if (!Yii::app()->userComponent->isAuthenticated()) {
            $this->redirect('/login');
        }
        $params = $_POST;
        $user = Yii::app()->userComponent->getUser();

        if (isset($params['type_collection']) && $params['type_collection'] == UserCollection::DELETE_FROM_COLLECTION){
            $userCollectionPost = UserCollection::model()->findByAttributes([
                'post_id' => $params['post_id'],
                'user_id' => $user->id
            ]);

            if ($userCollectionPost) {
                $userCollectionPost->collection_id = null;
                $userCollectionPost->update();
            }
        }

        if (isset($params['type_favorite']) && $params['type_favorite'] == UserCollection::DELETE_FROM_FAVORITE){
            UserCollection::model()->findByAttributes([
                'post_id' => $params['post_id'],
                'user_id' => $user->id
            ])->delete();
        }

        if (isset($params['collection'])){
            $userCollectionPost = UserCollection::model()->findByAttributes([
                'post_id' => $params['post_id'],
                'user_id' => $user->id
            ]);

            if ($userCollectionPost) {
                $userCollectionPost->collection_id = $params['collection'];
                $userCollectionPost->update();
            }
        }

        $this->redirect('/profile/favorites');
    }

    public function actionTestGiftSub()
    {
//        echo date('Y-m-d H:i:s');

        date_default_timezone_set('Europe/Vilnius');
        $currentDate = date('Y-m-d');
        $currentTime = date('H:i:00');

        file_put_contents(Yii::app()->runtimePath . '/custom.log', "Останнє оновлення: {$currentDate} {$currentTime}\n", FILE_APPEND);

        $criteria = new CDbCriteria();
        $criteria->condition = 'gift_date = :currentDate AND gift_time >= :currentTimeStart AND gift_time < :currentTimeEnd AND status_id = :statusId';
        $criteria->params = [
            ':currentDate' => $currentDate,
            ':currentTimeStart' => date('H:i:00', strtotime('-1 minute', strtotime($currentTime))),
            ':currentTimeEnd' => date('H:i:00', strtotime('+1 minute', strtotime($currentTime))),
            ':statusId' => UserSubscriptionGift::INACTIVE,
        ];

        $giftSubscriptions = UserSubscriptionGift::model()->findAll($criteria);

        if (!empty($giftSubscriptions)) {
            foreach ($giftSubscriptions as $subscription) {
                $subscription->status_id = UserSubscriptionGift::SEND_CLIENT; // Позначаємо як оброблену

                if ($subscription->save()) {
                    $template = EmailTemplate::getEmailTemplate(EmailTemplate::CLIENT_SUBSCRIPTION_GIFT);

                    $encryptedId = UserSubscriptionGift::encryptId($subscription->id);
                    $loginLink = 'http://34t.farbatest.com/activate-gift?token=' . urlencode($encryptedId);
                    $registerLink = 'http://34t.farbatest.com/registration';

                    $templateDescription = str_replace('@loginLink', "<a href='" . $loginLink . "'>ссылке</a>", $template->description);
                    $templateDescription = str_replace('@registerLink', "<a href='" . $registerLink . "'>ссылке</a>", $templateDescription);
                    $templateDescription = str_replace('@code', $subscription->code, $templateDescription);

                    $status = EmailService::sendEmail($subscription->gift_email, $template->subject . ' 🎁', $templateDescription);

                    if ($status) {
                        file_put_contents(Yii::app()->runtimePath . '/custom.log', 'Лист з подарованою підпискою відправлений: ' . $subscription->gift_email . '\n', FILE_APPEND);
                    } else {
                        file_put_contents(Yii::app()->runtimePath . '/custom.log', 'Помилка відправлення листа з подарованою підпискою : ' . $subscription->gift_email . '\n', FILE_APPEND);
                    }
                } else {
                    file_put_contents(Yii::app()->runtimePath . '/custom.log', "Помилка збереження: " . "\n", FILE_APPEND);
                }
            }
        } else {
            file_put_contents(Yii::app()->runtimePath . '/custom.log', "Немає підписок для відправлення\n", FILE_APPEND);
        }

        echo 1;
    }

    private function processGift($subscription)
    {
        SubscriptionComponent::sendClientSubscriptionGift($subscription);
    }

    public function actionTestUpdateSub()
    {
        try {
            $currentDate = date('Y-m-d H:i:s');

            // Отримуємо підписки, які потрібно активувати
            $subscriptionsToActivate = UserSubscription::model()->findAll(
                'date_start <= :current_date AND date_end >= :current_date AND is_active = :inactive',
                [
                    ':current_date' => $currentDate,
                    ':inactive' => UserSubscription::INACTIVE, // Тільки ті, що в очікуванні
                ]
            );

            foreach ($subscriptionsToActivate as $userSubscription) {
                // Активуємо підписку
                $userSubscription->is_active = UserSubscription::ACTIVE;
                if ($userSubscription->save()) {
                    // Знаходимо відповідний тип підписки
                    $subscription = Subscription::model()->findByAttributes(['id' => $userSubscription['subscription_id']]);
                    SubscriptionComponent::sendUserSubscriptionEmail($userSubscription, $subscription);
                }
            }

            // Деактивуємо підписки, якщо поточна дата вийшла за межі date_end
            $expiredSubscriptions = UserSubscription::model()->findAll(
                'date_end < :current_date AND is_active = :active',
                [
                    ':current_date' => $currentDate,
                    ':active' => UserSubscription::ACTIVE, // Тільки активні підписки
                ]
            );

            foreach ($expiredSubscriptions as $userSubscription) {
                $userSubscription->is_active = UserSubscription::EXPIRED;
                $userSubscription->save();
                // !!! Надсилаємо email про закінчення підписки
            }

            // Перевіряємо підписки, які ще не почалися, і змінюємо їх статус на INACTIVE
            $subscriptionsToPending = UserSubscription::model()->findAll(
                'date_start > :current_date AND is_active != :inactive',
                [
                    ':current_date' => $currentDate,
                    ':inactive' => UserSubscription::INACTIVE, // Тільки ті, що ще не почались і не в статусі "INACTIVE"
                ]
            );

            foreach ($subscriptionsToPending as $userSubscription) {
                $userSubscription->is_active = UserSubscription::INACTIVE;
                $userSubscription->save();
                // !!! Надсилаємо email користувачу про те, що підписка буде активована після попередньої
            }

            echo "OK!\n";
        } catch (\Exception $e) {
            Yii::log("Ошибка: " . $e->getMessage(), CLogger::LEVEL_ERROR);
        }
    }


}