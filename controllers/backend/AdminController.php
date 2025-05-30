<?php

class AdminController extends BackEndController
{
    /**
     * Displays the login page
     */
    public function actionLogin()
    {
        $this->layout = '//layouts/column1';

        $model = new LoginForm();

        // if it is ajax validation request
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'login-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }

        // collect user input data
        if (isset($_POST['LoginForm'])) {
            $model->attributes = $_POST['LoginForm'];
            // validate user input and redirect to the previous page if valid
            if ($model->validate() && $model->login()) {
                $this->redirect(['post/index']);
            }
        }
        // display the login form
        $this->render('login', ['model' => $model]);
    }

    /**
     * Logs out the current user and redirect to homepage.
     */
    public function actionLogout()
    {
        Yii::app()->user->logout();
        $this->redirect(Yii::app()->homeUrl);
    }

    /**
     * @throws \CHttpException
     */
    public function actionPassword()
    {
        /** @var $user User */
        $user = User::model()->findByPk(Yii::app()->user->id);
        if ($user === null) {
            throw new CHttpException(500, Yii::t('error', 'User Not Found.'));
        }

        $form = new ChangePasswordForm();

        if (isset($_POST['ChangePasswordForm'])) {
            $form->setAttributes($_POST['ChangePasswordForm']);

            if ($form->validate()) {
                if (!CPasswordHelper::verifyPassword($form->pwd_current, $user->password)) {
                    $form->addError('pwd_current', Yii::t('app', 'Wrong Current Password.'));
                    $form->emptyAttributes();
                } elseif ($form->savePassword($user)) {
                    Yii::app()->user->setFlash('success', Yii::t('app', 'Password changed successfully.'));
                    $this->redirect(['password']);
                } else {
                    throw new CHttpException(500, Yii::t('error', 'Database Error.'));
                }
            }
        }

        $this->render('password', ['model' => $form]);
    }

    /**
     * Clear system cache and assets
     */
    public function actionClearCache()
    {
        // clear assets
        $assets_path = Yii::getPathOfAlias('webroot.assets');
        if ($assets_path) {
            if ($handle = opendir($assets_path)) {
                while (($file = readdir($handle)) !== false) {
                    if (strpos($file, '.') === 0) {
                        continue;
                    }
                    $path = $assets_path . DIRECTORY_SEPARATOR . $file;
                    if (is_dir($path)) {
                        CFileHelper::removeDirectory($path);
                    } else {
                        unlink($path);
                    }
                }
                closedir($handle);
            }
        }

        $runtime = Yii::getPathOfAlias('application.runtime');
        $cache_filename = 'rss.xml';
        if (is_file($runtime . '/' . $cache_filename)) {
            @unlink(($runtime . '/' . $cache_filename));
        }
        $cache_filename = 'yandex.news.xml';
        if (is_file($runtime . '/' . $cache_filename)) {
            @unlink(($runtime . '/' . $cache_filename));
        }

        Yii::app()->cache->flush();
        $this->redirect(['post/index']);
    }

    /*public function actionCopyPlaces()
    {
        $places = GtbPlace::model()->currentLanguage()->findAll();
        $count = 0;
        foreach ($places as $place) {
            $new = new GtbPlace();
            $new->title = $place->title;
            $new->language = 'be';
            $new->status_id = $place->status_id;
            $new->description = $place->description;
            $new->lat = $place->lat;
            $new->lng = $place->lng;
            $new->type = $place->type;
            $new->images = $place->images;
            $new->related_posts_ids = $place->related_posts_ids;
            $new->related_posts_gtu_ids = $place->related_posts_gtu_ids;
            $new->related_posts_gtb_ids = $place->related_posts_gtb_ids;
            if ($new->save()) $count++;
        }
        var_dump($count . ' copied');die();
    }*/
}
