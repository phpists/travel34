<?php

declare(strict_types=1);

class BlockAfterPostController extends BackEndController
{
    /**
     * @inheritDoc
     */
    public function filters(): array
    {
        return [
            'accessControl', // perform access control for CRUD operations
            'postOnly + delete', // we only allow deletion via POST request
        ];
    }

    /**
     * @inheritDoc
     */
    public function actions(): array
    {
        return [
            'toggle' => [
                'class' => 'bootstrap.actions.TbToggleAction',
                'modelName' => 'BlockAfterPost',
            ],
        ];
    }

    /**
     * @return void
     */
    public function actionIndex()
    {
        $model = new BlockAfterPost('search');
        $model->unsetAttributes();  // clear any default values

        if (isset($_GET['BlockAfterPost'])) {
            $model->attributes = $_GET['BlockAfterPost'];
        }

        $this->render('index', [
            'model' => $model,
        ]);
    }

    /**
     * @return void
     */
    public function actionCreate()
    {
        $model = new BlockAfterPost();

        if (isset($_POST['BlockAfterPost'])) {
            $model->attributes = $_POST['BlockAfterPost'];

            if ($model->save()) {
                $this->redirect(['update', 'id' => $model->id]);
            } else {
                var_dump($model->getErrors());
                exit;
            }
        }

        $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * @param string $id
     * @return void
     * @throws CHttpException
     */
    public function actionUpdate(string $id)
    {
        $model = $this->loadModel($id);

        if (isset($_POST['BlockAfterPost'])) {
            $model->attributes = $_POST['BlockAfterPost'];

            if ($model->save()) {
                $this->redirect(['update', 'id' => $model->id]);
            }
        }

        $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * @param string $id
     * @return void
     * @throws CDbException
     * @throws CHttpException
     */
    public function actionDelete(string $id)
    {
        $this->loadModel($id)->delete();

        if (!isset($_GET['ajax'])) {
            $this->redirect($_POST['returnUrl'] ?? ['index']);
        }
    }

    /**
     * @param string $id
     * @return array|BlockAfterPost|CActiveRecord|mixed
     * @throws CHttpException
     */
    protected function loadModel(string $id)
    {
        $model = BlockAfterPost::model()->findByPk($id);

        if ($model === null) {
            throw new CHttpException(404, 'The requested page does not exist.');
        }

        return $model;
    }
}