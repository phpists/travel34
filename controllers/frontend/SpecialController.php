<?php

class SpecialController extends FrontEndController
{
    /**
     * Списочек спецпроектиков
     */
    public function actionIndex()
    {
        // w/o models
        $all_ids = Yii::app()->db->createCommand()
            ->from('tr_post')
            ->where('special_id IS NOT NULL AND special_id <> 0 AND status_id = :status_id',
                [':status_id' => Post::STATUS_ENABLED])
            ->select('special_id')
            ->order('date DESC, created_at DESC')
            ->queryColumn();
        $ids = [];
        foreach ($all_ids as $one) {
            if (isset($ids[$one])) {
                continue;
            }
            $ids[$one] = true;
        }

        $sprjTAlias = SpecialProject::model()->getTableAlias();

        $criteria = new CDbCriteria();
        //$criteria->with = array('posts');
        $criteria->order = $sprjTAlias . '.title ASC';
        $criteria->index = 'id';
        $projects_all = SpecialProject::model()->enabled()->findAll($criteria);

        $projects = [];
        foreach ($ids as $rid => $one) {
            if (isset($projects_all[$rid])) {
                $projects[] = $projects_all[$rid];
            }
        }
        unset($projects_all);

        $this->style = Style::getStyleByPageKey(Style::PAGE_KEY_SPECIALS);

        $this->render('index', [
            'projects' => $projects,
        ]);
    }

    /**
     * Списочек постиков в выбранном спецпроектике
     * @param string $name имечко спецпроектика
     * @throws CHttpException
     */
    public function actionView($name)
    {
        /** @var SpecialProject $model */
        $model = SpecialProject::model()->enabled()->findByAttributes(['url' => $name]);
        if ($model === null) {
            throw new CHttpException(404, Yii::t('app', 'The requested page does not exist.'));
        }

        $postTAlias = Post::model()->getTableAlias();

        // posts
        $criteria = new GeoDbCriteria();
        $criteria->with = ['rubric'];
        $criteria->addCondition('special_id = ' . (int)$model->id);
        $criteria->order = $postTAlias . '. date DESC, ' . $postTAlias . '. created_at DESC';

        $dataProvider = new CActiveDataProvider(Post::model()->enabled(), [
            'criteria' => $criteria,
            'pagination' => [
                'pageSize' => Yii::app()->params['postsPerPage'],
                'pageVar' => 'page',
            ],
        ]);

        $this->style = Style::getStyleByPageKey(Style::PAGE_KEY_SPECIAL, $model->id);

        $this->render('view', [
            'model' => $model,
            'dataProvider' => $dataProvider,
        ]);
    }
}
