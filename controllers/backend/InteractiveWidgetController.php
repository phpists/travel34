<?php

class InteractiveWidgetController extends BackEndController
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
                'modelName' => 'InteractiveWidget',
            ],
        ];
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate()
    {
        $model = new InteractiveWidget();

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['InteractiveWidget'])) {
            $model->attributes = $_POST['InteractiveWidget'];
            if ($model->save()) {
                $this->redirect(['update', 'id' => $model->id]);
            }
        }

        $this->render('create', [
            'model' => $model,
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

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['InteractiveWidget'])) {
            $model->attributes = $_POST['InteractiveWidget'];
            if ($model->save()) {
                $this->redirect(['update', 'id' => $model->id]);
            }
        }

        $this->render('update', [
            'model' => $model,
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
            $this->loadModel($id)->delete();

            // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if (!isset($_GET['ajax'])) {
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : ['index']);
            }
        } else {
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
        }
    }

    /**
     * Manages all models.
     */
    public function actionIndex()
    {
        $model = new InteractiveWidget('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['InteractiveWidget'])) {
            $model->attributes = $_GET['InteractiveWidget'];
        }

        $this->render('index', [
            'model' => $model,
        ]);
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param int the ID of the model to be loaded
     * @return InteractiveWidget
     * @throws CHttpException
     */
    public function loadModel($id)
    {
        $model = InteractiveWidget::model()->findByPk($id);
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
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'interactive-widget-form') {
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

        $es = new TbEditableSaver('InteractiveWidget');
        $es->onBeforeUpdate = function ($event) {
            $event->sender->setAttribute('updated_at', date('Y-m-d H:i:s'));
        };
        $es->update();
    }

    /**
     * Добавление элемента
     * @param int $id
     */
    public function actionCreateResult($id)
    {
        $parent = $this->loadModel($id);

        $model = new InteractiveResult();
        $model->interactive_widget_id = $parent->id;

        if (isset($_POST['InteractiveResult'])) {
            $model->attributes = $_POST['InteractiveResult'];
            if ($model->save()) {
                $model->refresh();
                $this->renderPartial('_result', [
                    'model' => $model,
                ]);
                return;
            }
        }

        $this->renderPartial('_result_form', [
            'model' => $model,
        ], false, true);
    }

    /**
     * Редактирование элемента
     * @param int $id
     * @throws CHttpException
     */
    public function actionUpdateResult($id)
    {
        /** @var InteractiveResult $model */
        $model = InteractiveResult::model()->findByPk($id);
        if ($model === null) {
            throw new CHttpException(404, 'The requested page does not exist.');
        }

        if (isset($_POST['InteractiveResult'])) {
            $model->attributes = $_POST['InteractiveResult'];
            if ($model->save()) {
                $this->renderPartial('_result', [
                    'model' => $model,
                ]);
                return;
            }
        }

        $this->renderPartial('_result_form', [
            'model' => $model,
        ], false, true);
    }

    /**
     * Удаление элемента
     * @param int $id
     * @throws CHttpException
     */
    public function actionDeleteResult($id)
    {
        if (Yii::app()->request->isPostRequest) {
            /** @var InteractiveResult $model */
            $model = InteractiveResult::model()->findByPk($id);
            if ($model === null) {
                throw new CHttpException(404, 'The requested page does not exist.');
            }
            $model->delete();
        } else {
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
        }
    }
}
