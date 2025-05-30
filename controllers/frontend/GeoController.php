<?php

class GeoController extends FrontEndController
{
    /**
     * This main action is needed to be refactored
     */
    public function actionIndex()
    {
        // cities and countries
        $criteria = new CDbCriteria();
        $criteria->order = 'title ASC';
        /** @var City[] $cities */
        $cities = City::model()->enabled()->findAll($criteria);
        /** @var Country[] $countries */
        $countries = Country::model()->enabled()->findAll($criteria);

        $lettersDict = [];
        $worldParts = City::model()->getWorldPartOptions();
        $worldPartsWithValues = [];
        foreach ($worldParts as $partKey => $partTitle) {
            $worldPartsWithValues[$partKey] = [
                'title' => $partTitle,
                'cities' => [],
                'countries' => [],
            ];
        }
        foreach ($countries as $item) {
            $title = $item->title;
            $titleTrimmed = trim($title);
            $itemFirstLetterRussian = mb_substr($titleTrimmed, 0, 1, 'UTF-8');
            $itemFirstLetter = Transliteration::slug($itemFirstLetterRussian);
            if (!array_key_exists($itemFirstLetter, $lettersDict)) {
                $lettersDict[$itemFirstLetter] = [
                    'title' => $itemFirstLetterRussian,
                    'countries' => [$item],
                    'cities' => [],
                ];
            } else {
                $lettersDict[$itemFirstLetter]['countries'][] = $item;
            }
            if (array_key_exists($item->world_part_id, $worldPartsWithValues)) {
                $worldPartsWithValues[$item->world_part_id]['countries'][] = $item;
            }
        }
        foreach ($cities as $item) {
            $title = $item->title;
            $titleTrimmed = trim($title);
            $itemFirstLetterRussian = mb_substr($titleTrimmed, 0, 1, 'UTF-8');
            $itemFirstLetter = Transliteration::slug($itemFirstLetterRussian);
            if (!array_key_exists($itemFirstLetter, $lettersDict)) {
                $lettersDict[$itemFirstLetter] = [
                    'title' => $itemFirstLetterRussian,
                    'countries' => [],
                    'cities' => [$item],
                ];
            } else {
                $lettersDict[$itemFirstLetter]['cities'][] = $item;
            }
            if (array_key_exists($item->world_part_id, $worldPartsWithValues)) {
                $worldPartsWithValues[$item->world_part_id]['cities'][] = $item;
            }
        }
        uasort($lettersDict, ['GeoController', '_sortValues']);

        $this->style = Style::getStyleByPageKey(Style::PAGE_KEY_ALL);

        $this->render('index', [
            'lettersDict' => $lettersDict,
            'worldParts' => $worldPartsWithValues,
            'lettersList' => array_keys($lettersDict),
        ]);
    }

    private static function _sortValues($a, $b)
    {
        if ($a['title'] == $b['title']) {
            return 0;
        }
        return ($a['title'] < $b['title']) ? -1 : 1;
    }

    public function actionView($url)
    {
        $data = $this->loadPosts($url);
        //$comment = $this->createComment($taxi);
        $this->render('view', [
            'tag' => $data['tag'],
            'materials' => $data['materials'],
        ]);
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param string $url
     * @return Post[] list
     * @throws CHttpException
     * @internal param int $id the ID of the model to be loaded
     */
    public function loadPosts($url)
    {
        $data = [];
        $model = Country::model()->findByAttributes(['url' => $url]);
        $attribute = 'countries.id';
        if ($model === null) {
            $model = City::model()->findByAttributes(['url' => $url]);
            $attribute = 'cities.id';
            if ($model === null) {
                throw new CHttpException(404, Yii::t('app', 'The requested page does not exist.'));
            }
        }
        $data['tag'] = $model['title'];

        $postTAlias = Post::model()->getTableAlias();

        // news
        $criteria = new GeoDbCriteria();
        $criteria->with = ['cities', 'author', 'countries'];
        $criteria->addCondition($attribute . ' = ' . $model->id);
        $criteria->order = $postTAlias . '. date DESC, ' . $postTAlias . '. created_at DESC';
        $newsPool = Post::model()->enabled()->news()->findAll($criteria);

        // local small top posts
        $criteria = new GeoDbCriteria();
        $criteria->with = ['cities', 'author', 'countries'];
        $criteria->addCondition($attribute . ' = ' . $model->id);
        $criteria->order = $postTAlias . '. date DESC, ' . $postTAlias . '. created_at DESC';
        $otherPostsPool = Post::model()->enabled()->not_news()->findAll($criteria);

        // current number of row we are adding posts to
        $currentRow = 0;
        $allPostsCount = count($newsPool) + count($otherPostsPool);
        $resultPostsList = [];

        while ($allPostsCount > 0) {

            switch ($currentRow % 2) {
                case 0:
                    if (!empty($newsPool)) {
                        $resultPostsList = $this->_appendRowSimplePosts($resultPostsList, $newsPool, 5, $allPostsCount,
                            true);
                        $resultPostsList = $this->_appendRowSimplePosts($resultPostsList, $otherPostsPool, 2,
                            $allPostsCount);
                    } else {
                        $resultPostsList = $this->_appendRowSimplePosts($resultPostsList, $otherPostsPool, 3,
                            $allPostsCount);
                    }
                    break;
                case 1:
                    //simple row without banners
                    $resultPostsList = $this->_appendRowSimplePosts($resultPostsList, $otherPostsPool, 3,
                        $allPostsCount);

                    break;
            }
            $currentRow++;
        }
        $data['materials'] = $resultPostsList;

        return $data;
    }

    private function _appendRowSimplePosts($resultPostsList, &$postsPool, $count, &$allPostsCount, $isNews = false)
    {
        $rowPosts = array_splice($postsPool, 0, $count);
        $allPostsCount -= count($rowPosts);
        if ($isNews) {
            $object = new stdClass();
            $object->type = 'news';
            $object->value = $rowPosts;
            $resultPostsList[] = $object;
        } else {
            foreach ($rowPosts as $post) {
                $resultPostsList[] = $post;
            }
        }
        return $resultPostsList;
    }
}
