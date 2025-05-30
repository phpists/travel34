<?php

class LatestNews extends CWidget
{
    public $skipId;

    public function run()
    {
        $criteria = new GeoDbCriteria();
        $criteria->scopes = ['enabled', 'news'];
        $criteria->limit = 9;
        if ($this->skipId) {
            $criteria->addNotInCondition('t.id', [$this->skipId]);
        }

        $models = Post::model()->findAll($criteria);

        $this->render('latestNews', [
            'models' => $models,
        ]);
    }
}
