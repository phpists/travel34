<?php

class GuideController extends FrontEndController
{
    /**
     * Guides list
     */
    public function actionIndex()
    {
        $model = new HasIdeaForm();
        if (isset($_POST['HasIdeaForm'])) {
            $model->attributes = $_POST['HasIdeaForm'];
            if ($model->validate()) {
                if (!empty($model->subject)) {
                    throw new CHttpException(500, 'Wrong Request');
                }
                if ($model->sendEmail()) {
                    echo json_encode(['status' => 'ok']);
                } else {
                    echo json_encode(['status' => 'error']);
                }
            } else {
                echo json_encode(['status' => 'error', 'errors' => $model->errors]);
            }
            Yii::app()->end();
        }

        $postTAlias = Post::model()->getTableAlias();

        $new_ids = Yii::app()->db->createCommand()
            ->select('id')
            ->from('tr_post')
            ->andWhere('status_id = :status_id', [':status_id' => Post::STATUS_ENABLED])
            ->andWhere('type_id = :type_guide OR type_id = :type_miniguide',
                [':type_guide' => Post::TYPE_GUIDE, ':type_miniguide' => Post::TYPE_MINIGUIDE])
            ->order('date DESC, created_at DESC')
            ->limit(Yii::app()->params['newGuidesCount'])
            ->queryColumn();

        $criteria2 = new GeoDbCriteria();
        //$criteria2->with = array('cities');
        $criteria2->select = ['id', 'url', 'title', 'type_id'];
        $criteria2->order = $postTAlias . '.title ASC';
        /** @var Post[] $names_models */
        $names_models = Post::model()->enabled()->guides()->findAll($criteria2);

        /** @var Post[] $names_indexed */
        $names_indexed = [];
        $sorted_ids = [];
        foreach ($names_models as $one) {
            $sorted_ids[$one->id] = $one->title;
            $names_indexed[$one->id] = $one;
        }
        asort($sorted_ids);

        $names = [];
        foreach ($sorted_ids as $one_id => $one_title) {
            if (!isset($names_indexed[$one_id])) {
                continue;
            }
            $names[] = [
                'url' => $names_indexed[$one_id]->getUrl(),
                'title' => $one_title,
                'type_id' => $names_indexed[$one_id]->type_id,
                'is_new' => in_array($one_id, $new_ids),
            ];
        }

        $criteria = new GeoDbCriteria();
        $criteria->order = $postTAlias . '.date DESC, ' . $postTAlias . '.created_at DESC';

        $dataProvider = new CActiveDataProvider(Post::model()->enabled()->guides(), [
            'criteria' => $criteria,
            'pagination' => [
                'pageSize' => Yii::app()->params['guidesPerPage'],
                'pageVar' => 'page',
            ],
        ]);

        $this->style = Style::getStyleByPageKey(Style::PAGE_KEY_GUIDES);

        // random background
        $guidesImage = '';
        $dir = Yii::getPathOfAlias('webroot') . '/media/upload/images/guides-bg';
        if (is_dir($dir)) {
            $files = glob($dir . '/*.{jpg,jpeg,png,gif}', GLOB_BRACE);
            $total_files = count($files);
            if ($total_files > 0) {
                $guidesImage = Yii::app()->request->baseUrl . '/media/upload/images/guides-bg/' . basename($files[array_rand($files)]);
            }
        }

        $this->render('index', [
            'model' => $model,
            'dataProvider' => $dataProvider,
            'names' => $names,
            'guidesImage' => $guidesImage,
        ]);
    }
}