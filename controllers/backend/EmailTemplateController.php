<?php


class EmailTemplateController extends BackEndController
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
                'modelName' => 'EmailTemplate',
            ],
        ];
    }

    /**
     * Lists all models.
     */
    public function actionIndex()
    {
        $model = new EmailTemplate('search');
        $model->unsetAttributes();
        if (isset($_GET['EmailTemplate'])) {
            $model->attributes = $_GET['EmailTemplate'];
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
        $model = new EmailTemplate();

        if (isset($_POST['EmailTemplate'])) {
            $model->attributes = $_POST['EmailTemplate'];

            if ($model->save()) {
                $this->redirect(['index']);
            }
        }

        $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id)
    {
        $model = $this->loadModel($id);

        if (isset($_POST['EmailTemplate'])) {
            $model->attributes = $_POST['EmailTemplate'];

            if ($model->save()) {
                $this->redirect(['update', 'id' => $model->id]);
            }
        }

        $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return EmailTemplate the loaded model
     * @throws CHttpException
     */
    public function loadModel($id)
    {
        $model = EmailTemplate::model()->findByPk($id);
        if ($model === null) {
            throw new CHttpException(404, 'The requested page does not exist.');
        }
        return $model;
    }


}