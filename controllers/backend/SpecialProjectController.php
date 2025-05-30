<?php

class SpecialProjectController extends BackEndController
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
                'modelName' => 'SpecialProject',
            ],
        ];
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate()
    {
        $model = new SpecialProject;

        if (isset($_POST['SpecialProject'])) {
            $model->attributes = $_POST['SpecialProject'];

            // set position
            if (empty($model->position) || $model->position == '0') {
                /** @var SpecialProject $last */
                $last = SpecialProject::model()->find([
                    'order' => 'position DESC',
                    'limit' => 1,
                ]);
                if ($last !== null) {
                    $model->position = $last->position + 10;
                }
            }

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
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id)
    {
        $model = $this->loadModel($id);

        if (isset($_POST['SpecialProject'])) {
            $model->attributes = $_POST['SpecialProject'];

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
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id)
    {
        $this->loadModel($id)->delete();

        // update posts
        Post::model()->updateAll(['special_id' => 0], 'special_id = :special_id', [':special_id' => $id]);

        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax'])) {
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : ['index']);
        }
    }

    /**
     * Lists all models.
     */
    public function actionIndex()
    {
        $model = new SpecialProject('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['SpecialProject'])) {
            $model->attributes = $_GET['SpecialProject'];
        }

        $this->render('index', [
            'model' => $model,
        ]);
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return SpecialProject the loaded model
     * @throws CHttpException
     */
    public function loadModel($id)
    {
        $model = SpecialProject::model()->findByPk($id);
        if ($model === null) {
            throw new CHttpException(404, 'The requested page does not exist.');
        }
        return $model;
    }
}
