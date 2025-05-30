<?php

class GtuController extends FrontEndController
{
    public $layout = 'gtu';

    public $relatedPosts;
    public $additionalPosts;

    public $isViewPage = false;

    public function actions()
    {
        return [
            'captcha' => [
                'class' => 'CCaptchaAction',
                'backColor' => 0xFFFFFF,
            ],
        ];
    }

    public function actionIndex()
    {
        $counters = [
            'excluded' => '',
            'other' => 0,
            'top' => 0,
        ];
        $result = GtuPost::getPostsList($counters, Yii::app()->params['rowsPerGtuPage'], true, true);

        if ($result['supertop_post'] !== null) {
            /** @var GtuPost $post */
            $post = $result['supertop_post'];
            $this->topImage = !empty($post->image_home_supertop) ? $post->getImageUrl('image_home_supertop') : $post->getImageUrl('image_supertop');
            $this->topTitle = $post->title;
            $this->topLink = $post->getUrl(); // . '#post-text';
            $this->topHome = true;
            unset($result['supertop_post']);
        }

        if (Yii::app()->language == 'en') {
            $page_key = Style::PAGE_KEY_GTU_MAIN_EN;
        } elseif (Yii::app()->language == 'ru') {
            $page_key = Style::PAGE_KEY_GTU_MAIN_RU;
        } else {
            $page_key = Style::PAGE_KEY_GTU_MAIN;
        }
        $this->style = Style::getStyleByPageKey($page_key);

        $this->render('index', $result);
    }

    /**
     * More posts on homepage
     */
    public function actionMore()
    {
        $counters = [
            'excluded' => Yii::app()->request->getParam('excluded', 0),
            'other' => Yii::app()->request->getParam('otherCount', 0),
            'top' => Yii::app()->request->getParam('topCount', 0),
        ];
        $result = GtuPost::getPostsList($counters, Yii::app()->params['rowsPerGtuPage'], false, true);
        $this->renderPartial('_posts', $result);
    }

    /**
     * @param string $url
     * @throws CHttpException
     */
    public function actionRubric($url)
    {
        /** @var GtuRubric $model */
        $model = GtuRubric::model()->enabled()->findByAttributes(['url' => $url]);
        if ($model === null) {
            throw new CHttpException(404, Yii::t('app', 'The requested page does not exist.'));
        }

        $criteria = new CDbCriteria();
        $criteria->with = ['gtuRubric'];
        $criteria->addCondition('t.gtu_rubric_id = :gtu_rubric_id');
        $criteria->params = [':gtu_rubric_id' => $model->id];
        $criteria->scopes = ['enabled', 'sorted', 'currentLanguage'];

        $dataProvider = new CActiveDataProvider(GtuPost::model(), [
            'criteria' => $criteria,
            'pagination' => [
                'pageSize' => Yii::app()->params['gtuPostsPerPage'],
                'pageVar' => 'page',
            ],
        ]);

        if (Yii::app()->language == 'en') {
            $page_key = Style::PAGE_KEY_GTU_RUBRIC_EN;
        } elseif (Yii::app()->language == 'ru') {
            $page_key = Style::PAGE_KEY_GTU_RUBRIC_RU;
        } else {
            $page_key = Style::PAGE_KEY_GTU_RUBRIC;
        }
        $this->style = Style::getStyleByPageKey($page_key, $model->id);

        $this->render('rubric', [
            'model' => $model,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * to do page
     */
    public function actionTodo()
    {
        $models = GtuRubric::model()->enabled()->findAllByAttributes(['in_todo_list' => 1]);
        $ids = [];
        foreach ($models as $model) {
            $ids[] = $model->id;
        }

        $criteria = new CDbCriteria();
        $criteria->with = ['gtuRubric'];
        $criteria->addInCondition('gtu_rubric_id', $ids);
        $criteria->scopes = ['enabled', 'sorted', 'currentLanguage'];

        $dataProvider = new CActiveDataProvider(GtuPost::model(), [
            'criteria' => $criteria,
            'pagination' => [
                'pageSize' => Yii::app()->params['gtuPostsPerPage'],
                'pageVar' => 'page',
            ],
        ]);

        if (Yii::app()->language == 'en') {
            $page_key = Style::PAGE_KEY_GTU_TODO_EN;
        } elseif (Yii::app()->language == 'ru') {
            $page_key = Style::PAGE_KEY_GTU_TODO_RU;
        } else {
            $page_key = Style::PAGE_KEY_GTU_TODO;
        }
        $this->style = Style::getStyleByPageKey($page_key);

        $this->render('todo', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a particular model.
     * @param string $url url of the page
     * @throws CHttpException
     */
    public function actionView($url)
    {
        /** @var WebUser $user */
        $user = Yii::app()->user;
        $isAdmin = !empty($user) && $user->isAdmin();
        $isAdvertiser = !empty($user) && $user->isAdvertiser();
        if ($isAdmin || $isAdvertiser) {
            /** @var GtuPost $post */
            $post = GtuPost::model()->currentLanguage()->findByAttributes(['url' => $url]);
        } else {
            /** @var GtuPost $post */
            $post = GtuPost::model()->statusEnabled()->currentLanguage()->findByAttributes(['url' => $url]);
        }
        if ($post === null) {
            throw new CHttpException(404, Yii::t('app', 'The requested page does not exist.'));
        }

        if ($post->hide_banners == 1) {
            $this->hideTopBanner = true;
        }

        /*
         * Increment views.
         * @TODO: IP address checking is needed.
         */
        if (Yii::app()->request->getParam('get_only_views_count', 0) == 1) {
            echo $post->views_count;
            exit;
        }
        /** @var CookiesHelper $cookiesHelper */
        $cookiesHelper = Yii::app()->cookiesHelper;
        if ($post->isEnabled() && !$cookiesHelper->getCMsg('view_gtu_post_' . $post->id)) {
            $post->views_count += 1;
            $post->save();
            $options = ['expire' => time() + 3600 * 12];
            $cookiesHelper->setCMsg('view_gtu_post_' . $post->id, 'y', $options);
        }

        /*if ((int)$post->is_supertop == 1 && !empty($post->image_supertop)) {
            // Supertop
            $this->topImage = $post->getImageUrl('image_supertop');
            $this->topTitle = $post->title;
            $this->topLink = '#post-text';
        }*/

        if ($post->hide_styles != 1) {
            $this->style = Style::getStyleByPageKey(Style::PAGE_KEY_GTU_POST, $post->id);
        }

        $this->relatedPosts = $post->getRelatedPostsList(4);

        $counters = [
            'excluded' => "$post->id",
            'other' => 0,
            'top' => 0,
        ];
        $this->additionalPosts = GtuPost::getPostsList($counters, Yii::app()->params['rowsPerGtuPostPage']);

        //$this->relapCode = true;

        $postBanner = null;
        if ($post->hide_banners != 1) {
            $postBanner = Banner::getByPlace(Banner::PLACE_AFTER_POST);
        }

        $this->render('view', [
            'model' => $post,
            'postBanner' => $postBanner,
        ]);
    }

    /**
     * Еще посты
     */
    public function actionMoreAdditional()
    {
        $counters = [
            'excluded' => Yii::app()->request->getParam('excluded', ''),
            'other' => Yii::app()->request->getParam('otherCount', 0),
            'top' => Yii::app()->request->getParam('topCount', 0),
        ];
        $additionalPosts = GtuPost::getPostsList($counters, Yii::app()->params['rowsPerGtuPostPage'], false);

        $this->renderPartial('_additional_posts', $additionalPosts);
    }

    /**
     * Places Map Page
     */
    public function actionMap() {
        $this->style = Style::getStyleByPageKey(Style::PAGE_KEY_GTU_MAP);

        $this->render('/map/map', [
            'url' => $this->createUrl('/gtu/places'),
            'lat' => 49.260038,
            'lng' => 31.352247
        ]);
    }

    /**
     * @param string $type
     */
    public function actionPlaces($type = '') {
        header('Content-type: application/json');
        echo CJSON::encode(GtuPlace::getPlacesForMap($type));
    }
}
