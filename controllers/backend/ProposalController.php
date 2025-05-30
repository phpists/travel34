<?php

class ProposalController extends BackEndController
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
                'modelName' => 'Proposal',
            ],
        ];
    }

    /**
     * Отправка заявок на email
     */
    public function actionSend()
    {
        $model = new SendProposalsForm();
        if (($value = Yii::app()->cache->get('proposal_email')) !== false) {
            $model->email = $value;
        }
        if (($value = Yii::app()->cache->get('proposal_subject')) !== false) {
            $model->subject = $value;
        }

        if (isset($_POST['SendProposalsForm'])) {
            $model->attributes = $_POST['SendProposalsForm'];

            /** @var Proposal[] $models */
            $models = Proposal::model()->findAllByAttributes(['processed' => 0, 'form_type' => $model->form_type]);
            if (count($models) == 0) {
                $model->addError('form_type', 'Заявок не найдено');
            } elseif ($model->sendEmail($models)) {
                Proposal::model()->updateAll(['processed' => 1, 'processed = :processed AND form_type = :form_type', [':processed' => 0, ':form_type' => $model->form_type]]);
                Yii::app()->cache->set('proposal_email', $model->email);
                Yii::app()->cache->set('proposal_subject', $model->subject);
                Yii::app()->user->setFlash('success', 'Заявки отправлены');
                $this->refresh();
            } else {
                $model->addError('email', 'Невозможно отправить письмо');
            }
        }

        $models = Proposal::model()->findAllByAttributes(['processed' => 0]);
        $types = Yii::app()->params['proposalFormTypes'];

        $types_count = [];
        foreach ($models as $one) {
            if (isset($types_count[$one->form_type])) {
                $types_count[$one->form_type] += 1;
            } else {
                $types_count[$one->form_type] = 1;
            }
        }

        $data = [];
        foreach ($types as $type => $type_title) {
            if (isset($types_count[$type])) {
                $data[$type] = $type_title . ' (' . $types_count[$type] . ')';
            }
        }

        $this->render('send', [
            'model' => $model,
            'data' => $data,
        ]);
    }

    /**
     * Displays a particular model.
     *
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id)
    {
        $this->render('view', [
            'model' => $this->loadModel($id),
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
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : ['index']);
        }
    }

    /**
     * Manages all models.
     */
    public function actionIndex()
    {
        $model = new Proposal('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Proposal'])) {
            $model->attributes = $_GET['Proposal'];
        }

        $this->render('index', [
            'model' => $model,
        ]);
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Proposal the loaded model
     * @throws CHttpException
     */
    public function loadModel($id)
    {
        $model = Proposal::model()->findByPk($id);
        if ($model === null) {
            throw new CHttpException(404, 'The requested page does not exist.');
        }
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param Proposal $model the model to be validated
     */
    protected function performAjaxValidation($model)
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'proposal-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
}
