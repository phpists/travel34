<?php

class GtbPostController extends BackEndController
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

    public function actions()
    {
        return [
            'toggle' => [
                'class' => 'bootstrap.actions.TbToggleAction',
                'modelName' => 'GtbPost',
            ],
        ];
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate()
    {
        $model = new GtbPost;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['GtbPost'])) {
            $model->attributes = $_POST['GtbPost'];
            $rewriteUrl = false;
            $url = Transliteration::slug($model->title);
            $postWithSameUrl = GtbPost::model()->findByAttributes(['url' => $url]);
            if (!empty($postWithSameUrl)) {
                $rewriteUrl = true;
            }
            $model->url = $url;

            if ($model->save()) {
                if ($rewriteUrl) {
                    $model->url = $url . '-' . $model->id;
                    $model->save();
                }

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

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['GtbPost'])) {
            // empty by default
            $model->related_posts_ids = [];

            $model->attributes = $_POST['GtbPost'];

            $postWithSameUrl = GtbPost::model()->find('url = :post_url AND id != :post_id', [':post_url' => $model->url, ':post_id' => $model->id]);
            if (!empty($postWithSameUrl)) {
                $model->addError('url', 'Уже есть такая ссылка');
            } elseif ($model->save()) {
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

        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax'])) {
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : ['admin']);
        }
    }

    /**
     * Lists all models.
     */
    public function actionIndex()
    {
        $model = new GtbPost('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['GtbPost'])) {
            $model->attributes = $_GET['GtbPost'];
        }

        $this->render('index', [
            'model' => $model,
        ]);
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return GtbPost the loaded model
     * @throws CHttpException
     */
    public function loadModel($id)
    {
        $model = GtbPost::model()->findByPk($id);
        if ($model === null) {
            throw new CHttpException(404, 'The requested page does not exist.');
        }
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param GtbPost $model the model to be validated
     */
    protected function performAjaxValidation($model)
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'gtb-post-form') {
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

        $es = new TbEditableSaver('GtbPost');
        $es->onBeforeUpdate = function ($event) {
            $event->sender->setAttribute('updated_at', date('Y-m-d H:i:s'));
        };
        $es->update();
    }

    /**
     * Добавление элемента
     * @param int $id
     */
    public function actionCreateStyle($id)
    {
        $parent = $this->loadModel($id);

        $model = new Style();
        $model->status_id = Style::YES;
        $model->title = $parent->title;
        $model->page_keys = [Style::PAGE_KEY_GTB_POST];
        $model->item_ids = [$parent->id];

        if (isset($_POST['Style'])) {
            $model->attributes = $_POST['Style'];
            if ($model->save()) {
                $model->refresh();
                $this->renderPartial('_style', [
                    'model' => $model,
                ]);
                return;
            }
        }

        $this->renderPartial('_style_form', [
            'model' => $model,
        ]);
    }

    /**
     * Редактирование элемента
     * @param int $id
     * @throws CHttpException
     */
    public function actionUpdateStyle($id)
    {
        /** @var Style $model */
        $model = Style::model()->findByPk($id);
        if ($model === null) {
            throw new CHttpException(404, 'The requested page does not exist.');
        }

        if (isset($_POST['Style'])) {
            $model->attributes = $_POST['Style'];
            if ($model->save()) {
                $this->renderPartial('_style', [
                    'model' => $model,
                ]);
                return;
            }
        }

        $this->renderPartial('_style_form', [
            'model' => $model,
        ]);
    }

    /**
     * Удаление элемента
     * @param int $id
     * @throws CHttpException
     */
    public function actionDeleteStyle($id)
    {
        if (Yii::app()->request->isPostRequest) {
            /** @var Style $model */
            $model = Style::model()->findByPk($id);
            if ($model === null) {
                throw new CHttpException(404, 'The requested page does not exist.');
            }
            $model->delete();
        } else {
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
        }
    }
}
