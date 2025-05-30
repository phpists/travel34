<?php

class AuthorsController extends FrontEndController
{
    public function actionView($name)
    {
        /** @var Author $author */
        $author = Author::model()->findByAttributes(['title' => $name]);
        if ($author === null) {
            throw new CHttpException(404, 'Автор не найден');
        }

        $postTAlias = Post::model()->getTableAlias();

        $criteria = new GeoDbCriteria();
        $criteria->with = ['rubric'];
        $criteria->addCondition('author_id = ' . (int)$author->id);
        $criteria->order = $postTAlias . '. date DESC, ' . $postTAlias . '. created_at DESC';

        $dataProvider = new CActiveDataProvider(Post::model()->enabled(), [
            'criteria' => $criteria,
            'pagination' => [
                'pageSize' => Yii::app()->params['postsPerPage'],
                'pageVar' => 'page',
            ],
        ]);

        $this->style = Style::getStyleByPageKey(Style::PAGE_KEY_ALL);

        $this->render('view', [
            'author' => $author,
            'dataProvider' => $dataProvider,
        ]);
    }
}
