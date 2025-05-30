<?php


class PromoCodeController extends BackEndController
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
                'modelName' => 'PromoCode',
            ],
        ];
    }

    /**
     * Lists all models.
     */
    public function actionIndex()
    {
        $model = new PromoCode('search');
        $model->unsetAttributes();
        if (isset($_GET['PromoCode'])) {
            $model->attributes = $_GET['PromoCode'];
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
        $model = new PromoCode();

        if (isset($_POST['PromoCode'])) {
            $form = $_POST['PromoCode'];
            $form['type_id'] = json_encode($form['type_id']);
            $form['available_activations'] = $form['number_activations'];
            $form['date_create'] = date('Y-m-d H:i:s');

            if (empty($form['promo_code'])) {
                $form['promo_code'] = $model->generatePromocode();
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

        if (isset($_POST['PromoCode'])) {
            $form = $_POST['PromoCode'];
            $form['type_id'] = json_encode($form['type_id']);
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
        $promoCode = $this->loadModel($id);

        if ($promoCode){
            $promoCode->status_id = PromoCode::SUSPENDED;
            $promoCode->update();
        }

        if (!isset($_GET['ajax'])) {
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : ['index']);
        }
    }

    public function actionRestore($id)
    {
        $promoCode = $this->loadModel($id);

        if ($promoCode){
            $promoCode->status_id = PromoCode::ACTIVE;
            $promoCode->update();
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
        $model = PromoCode::model()->findByPk($id);
        if ($model === null) {
            throw new CHttpException(404, 'The requested page does not exist.');
        }
        return $model;
    }
}