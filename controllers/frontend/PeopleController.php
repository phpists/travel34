<?php

class PeopleController extends FrontEndController
{
    /**
     * This main action is needed to be refactored
     */
    public function actionIndex()
    {
        $postTAlias = Post::model()->getTableAlias();

        $criteria = new GeoDbCriteria();
        $criteria->with = ['rubric'];
        $criteria->order = $postTAlias . '.date DESC, ' . $postTAlias . '.created_at DESC';

        $dataProvider = new CActiveDataProvider(Post::model()->enabled()->materials(), [
            'criteria' => $criteria,
            'pagination' => [
                'pageSize' => Yii::app()->params['postsPerPage'],
                'pageVar' => 'page',
            ],
        ]);

        $this->style = Style::getStyleByPageKey(Style::PAGE_KEY_ALL);

        $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }
}