<?php


class PromoCodeGiftController extends BackEndController
{
    /**
     * @return array
     */
    public function filters()
    {
        return [
            'accessControl',
            'postOnly + delete',
        ];
    }

    public function actions()
    {
        return [
            'toggle' => [
                'class' => 'bootstrap.actions.TbToggleAction',
                'modelName' => 'UserSubscriptionGift',
            ],
        ];
    }

    /**
     * Lists all models.
     */
    public function actionIndex()
    {
        $model = new UserSubscriptionGift('search');
        $model->unsetAttributes();
        if (isset($_GET['UserSubscriptionGift'])) {
            $model->attributes = $_GET['UserSubscriptionGift'];
        }

        $this->render('index', [
            'model' => $model,
        ]);
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate()
    {
        $model = new UserSubscriptionGift();

        if (isset($_POST['UserSubscriptionGift'])) {
            $form = $_POST['UserSubscriptionGift'];
            $form['number_activations'] = 1;
            $form['available_activations'] = 0;
            $form['date_create'] = date('Y-m-d H:i:s');

            if (empty($form['user_email'])) {
                $form['user_email'] = 'Admin';
            }

            if (empty($form['code'])) {
                $form['code'] = $model->generatePromocode();
            }

            if (empty($form['expiry_date'])){
                $form['expiry_date'] = UserSubscriptionGift::addYearToToday();
            }


            $model->attributes = $form;

            if ($model->save()) {
                $this->redirect(['index']);
            }
        }

        $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionUpdate($id)
    {
        $model = $this->loadModel($id);

        if (isset($_POST['UserSubscriptionGift'])) {
            $form = $_POST['UserSubscriptionGift'];
            $model->attributes = $form;

            if ($model->save()) {
                $this->redirect(['update', 'id' => $model->id]);
            }
        }

        $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionDelete($id)
    {
        $this->loadModel($id)->delete();

        if (!isset($_GET['ajax'])) {
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : ['index']);
        }
    }

    public function actionPause($id)
    {
        $promoCodeGift = $this->loadModel($id);

        if ($promoCodeGift){
            $promoCodeGift->status_id =  $promoCodeGift->status_id == UserSubscriptionGift::ACTIVE ? UserSubscriptionGift::SUSPENDED : UserSubscriptionGift::ACTIVE;
            $promoCodeGift->update();
        }

        if (!isset($_GET['ajax'])) {
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : ['index']);
        }
    }

    public function actionRestore($id)
    {
        $promoCodeGift = $this->loadModel($id);

        if ($promoCodeGift){
            $promoCodeGift->status_id =  $promoCodeGift->status_id == UserSubscriptionGift::ACTIVE ? UserSubscriptionGift::SUSPENDED : UserSubscriptionGift::ACTIVE;
            $promoCodeGift->update();
        }

        if (!isset($_GET['ajax'])) {
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : ['index']);
        }
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Comment the loaded model
     * @throws CHttpException
     */
    public function loadModel($id)
    {
        $model = UserSubscriptionGift::model()->findByPk($id);
        if ($model === null) {
            throw new CHttpException(404, 'The requested page does not exist.');
        }
        return $model;
    }
}