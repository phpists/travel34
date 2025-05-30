<?php

class RubricController extends FrontEndController
{
    /**
     * This main action is needed to be refactored
     */
    public function actionIndex()
    {
        // w/o models
        $all_ids = Yii::app()->db->createCommand()
            ->from('tr_post')
            ->where('rubric_id IS NOT NULL AND rubric_id <> 0 AND status_id = :status_id',
                [':status_id' => Post::STATUS_ENABLED])
            ->select('rubric_id')
            ->order('date DESC, created_at DESC')
            ->queryColumn();
        $ids = [];
        foreach ($all_ids as $one) {
            if (isset($ids[$one])) {
                continue;
            }
            $ids[$one] = true;
        }

        $rubricTAlias = Rubric::model()->getTableAlias();

        $criteria = new CDbCriteria();
        //$criteria->with = array('posts');
        $criteria->order = $rubricTAlias . '.title ASC';
        $criteria->index = 'id';
        $rubrics_all = Rubric::model()->enabled()->findAll($criteria);

        $rubrics = [];
        foreach ($ids as $rid => $one) {
            if (isset($rubrics_all[$rid])) {
                $rubrics[] = $rubrics_all[$rid];
            }
        }
        unset($rubrics_all);

        $this->style = Style::getStyleByPageKey(Style::PAGE_KEY_ALL);

        $this->render('index', [
            'rubrics' => $rubrics,
        ]);
    }

    /**
     * @param string $url
     * @throws CHttpException
     */
    public function actionView($url)
    {
        /** @var Rubric $model */
        $model = Rubric::model()->findByAttributes(['url' => $url]);
        if ($model === null) {
            throw new CHttpException(404, Yii::t('app', 'The requested page does not exist.'));
        }

        $postTAlias = Post::model()->getTableAlias();

        $criteria = new GeoDbCriteria();
        $criteria->with = ['rubric'];
        $criteria->addCondition('rubric_id = ' . (int)$model->id);
        $criteria->order = $postTAlias . '.date DESC, ' . $postTAlias . '.created_at DESC';

        $dataProvider = new CActiveDataProvider(Post::model()->enabled()->not_news(), [
            'criteria' => $criteria,
            'pagination' => [
                'pageSize' => Yii::app()->params['postsPerPage'],
                'pageVar' => 'page',
            ],
        ]);

        $this->style = Style::getStyleByPageKey(Style::PAGE_KEY_RUBRIC, $model->id);

        $this->render('view', [
            'model' => $model,
            'dataProvider' => $dataProvider,
        ]);
    }
}
