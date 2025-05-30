<?php

class NewsController extends FrontEndController
{
    /**
     * This main action is needed to be refactored
     */
    public function actionIndex()
    {
        $criteria = new GeoDbCriteria();
        $criteria->scopes = ['enabled', 'news'];

        $dataProvider = new CActiveDataProvider(Post::model(), [
            'criteria' => $criteria,
            'pagination' => [
                'pageSize' => Yii::app()->params['newsPerPage'],
                'pageVar' => 'page',
            ],
        ]);

        /* @var $models Post[] */
        $models = $dataProvider->getData();
        $pagination = $dataProvider->getPagination();

        $newsBanner = Banner::getByPlace(Banner::PLACE_NEWS_VERTICAL);

        $this->style = Style::getStyleByPageKey(Style::PAGE_KEY_ALL);

        $this->render('index', [
            'models' => $models,
            'pagination' => $pagination,
            'newsBanner' => $newsBanner,
        ]);
    }
}
