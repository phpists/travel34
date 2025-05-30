<?php

class TestResultController extends BackEndController
{
    /**
     * @return array action filters
     */
    public function filters()
    {
        return [
            'accessControl', // perform access control for CRUD operations
            'postOnly + delete', // we only allow deletion via POST request
        ];
    }

    /**
     * @return array
     */
    public function actions()
    {
        return [
            'toggle' => [
                'class' => 'bootstrap.actions.TbToggleAction',
                'modelName' => 'TestResult',
            ],
        ];
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @param int $parent
     */
    public function actionCreate($parent)
    {
        $parent_model = $this->loadTestWidgetModel($parent);

        $model = new TestResult();
        $model->test_widget_id = $parent_model->id;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['TestResult'])) {
            $model->attributes = $_POST['TestResult'];
            if ($model->save()) {
                $this->redirect(['update', 'id' => $model->id]);
            }
        }

        $this->render('create', [
            'model' => $model,
            'parent_model' => $parent_model,
        ]);
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id the ID of the model to be updated
     */
    public function actionUpdate($id)
    {
        $model = $this->loadModel($id);

        $parent = $model->test_widget_id;
        $parent_model = $this->loadTestWidgetModel($parent);

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['TestResult'])) {
            $model->attributes = $_POST['TestResult'];
            if ($model->save()) {
                $this->redirect(['update', 'id' => $model->id]);
            }
        }

        $this->render('update', [
            'model' => $model,
            'parent_model' => $parent_model,
        ]);
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id the ID of the model to be deleted
     * @throws CHttpException
     */
    public function actionDelete($id)
    {
        if (Yii::app()->request->isPostRequest) {
            // we only allow deletion via POST request
            $model = $this->loadModel($id);
            $parent = $model->test_widget_id;
            $model->delete();

            // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if (!isset($_GET['ajax'])) {
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : ['index', 'parent' => $parent]);
            }
        } else {
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
        }
    }

    /**
     * Manages all models.
     * @param int $parent
     */
    public function actionIndex($parent)
    {
        $parent_model = $this->loadTestWidgetModel($parent);

        $model = new TestResult('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['TestResult'])) {
            $model->attributes = $_GET['TestResult'];
        }

        $this->render('index', [
            'model' => $model,
            'parent_model' => $parent_model,
        ]);
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param int the ID of the model to be loaded
     * @return TestResult|null
     * @throws CHttpException
     */
    public function loadModel($id)
    {
        $model = TestResult::model()->findByPk($id);
        if ($model === null) {
            throw new CHttpException(404, 'The requested page does not exist.');
        }
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model)
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'test-result-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    /**
     * Editable saver function
     */
    public function actionEditableSaver()
    {
        Yii::import('bootstrap.widgets.TbEditableSaver');

        $es = new TbEditableSaver('TestResult');
        $es->onBeforeUpdate = function ($event) {
            $event->sender->setAttribute('updated_at', date('Y-m-d H:i:s'));
        };
        $es->update();
    }

    /**
     * @param int
     * @return TestWidget|null
     * @throws CHttpException
     */
    public function loadTestWidgetModel($id)
    {
        $model = TestWidget::model()->findByPk($id);
        if ($model === null) {
            throw new CHttpException(404, 'The requested page does not exist.');
        }
        return $model;
    }
}
