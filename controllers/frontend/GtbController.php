<?php

class GtbController extends FrontEndController
{
    public $layout = 'gtb';

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
        $result = GtbPost::getHomePostsList($counters, Yii::app()->params['rowsPerGtbPage']);

        if ($result['supertop_post'] !== null) {
            /** @var GtbPost $post */
            $post = $result['supertop_post'];
            $this->topImage = !empty($post->image_home_supertop) ? $post->getImageUrl('image_home_supertop') : $post->getImageUrl('image_supertop');
            $this->topTitle = $post->title;
            $this->topLink = $post->getUrl(); // . '#post-text';
            $this->topHome = true;
            unset($result['supertop_post']);
        }

        $this->style = Style::getStyleByPageKey(Yii::app()->language == 'en' ? Style::PAGE_KEY_GTB_MAIN_EN : Style::PAGE_KEY_GTB_MAIN);

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
        $result = GtbPost::getHomePostsList($counters, Yii::app()->params['rowsPerGtbPage'], false);
        $this->renderPartial('_posts', $result);
    }

    /**
     * @param string $url
     * @throws CHttpException
     */
    public function actionRubric($url)
    {
        /** @var GtbRubric $model */
        $model = GtbRubric::model()->enabled()->findByAttributes(['url' => $url]);
        if ($model === null) {
            throw new CHttpException(404, Yii::t('app', 'The requested page does not exist.'));
        }

        $postTAlias = GtbPost::model()->getTableAlias();

        $criteria = new CDbCriteria();
        $criteria->with = ['gtbRubric'];
        $criteria->addCondition('gtb_rubric_id = ' . $model->id);
        $criteria->order = $postTAlias . '.date DESC, ' . $postTAlias . '.created_at DESC';

        $dataProvider = new CActiveDataProvider(GtbPost::model()->enabled()->currentLanguage(), [
            'criteria' => $criteria,
            'pagination' => [
                'pageSize' => Yii::app()->params['gtbPostsPerPage'],
                'pageVar' => 'page',
            ],
        ]);

        $this->style = Style::getStyleByPageKey(Yii::app()->language == 'en' ? Style::PAGE_KEY_GTB_RUBRIC_EN : Style::PAGE_KEY_GTB_RUBRIC, $model->id);

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
        $models = GtbRubric::model()->enabled()->findAllByAttributes(['in_todo_list' => 1]);
        $ids = [];
        foreach ($models as $model) {
            $ids[] = $model->id;
        }

        $postTAlias = GtbPost::model()->getTableAlias();

        $criteria = new CDbCriteria();
        $criteria->with = ['gtbRubric'];
        $criteria->addInCondition('gtb_rubric_id', $ids);
        $criteria->order = $postTAlias . '.date DESC, ' . $postTAlias . '.created_at DESC';

        $dataProvider = new CActiveDataProvider(GtbPost::model()->enabled()->currentLanguage(), [
            'criteria' => $criteria,
            'pagination' => [
                'pageSize' => Yii::app()->params['gtbPostsPerPage'],
                'pageVar' => 'page',
            ],
        ]);

        $this->style = Style::getStyleByPageKey(Yii::app()->language == 'en' ? Style::PAGE_KEY_GTB_TODO_EN : Style::PAGE_KEY_GTB_TODO);

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
            /** @var GtbPost $post */
            $post = GtbPost::model()->currentLanguage()->findByAttributes(['url' => $url]);
        } else {
            /** @var GtbPost $post */
            $post = GtbPost::model()->statusEnabled()->currentLanguage()->findByAttributes(['url' => $url]);
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
        if (Yii::app()->request->getParam('get_only_comments_count', 0) == 1) {
            echo $post->comments_count;
            exit;
        }
        if (Yii::app()->request->getParam('get_only_views_count', 0) == 1) {
            echo $post->views_count;
            exit;
        }
        /** @var CookiesHelper $cookiesHelper */
        $cookiesHelper = Yii::app()->cookiesHelper;
        if ($post->isEnabled() && !$cookiesHelper->getCMsg('view_gtb_post_' . $post->id)) {
            $post->views_count += 1;
            $post->save();
            $options = ['expire' => time() + 3600 * 12];
            $cookiesHelper->setCMsg('view_gtb_post_' . $post->id, 'y', $options);
        }

        /*if ((int)$post->is_supertop == 1 && !empty($post->image_supertop)) {
            // Supertop
            $this->topImage = $post->getImageUrl('image_supertop');
            $this->topTitle = $post->title;
            $this->topLink = '#post-text';
        }*/

        if ($post->hide_styles != 1) {
            $this->style = Style::getStyleByPageKey(Style::PAGE_KEY_GTB_POST, $post->id);
        }

        $relatedPosts = $post->getRelatedPostsList(Yii::app()->params['relatedPostsCount']);

        $counters = [
            'other' => 0,
            'top' => 0,
        ];
        $additionalPosts = GtbPost::getAdditionalPostsList($counters, Yii::app()->params['rowsPerPostPage'], $post->id);

        // random background
        $subscribeImage = '';
        $dir = Yii::getPathOfAlias('webroot') . '/media/upload/images/subscribe-bg';
        if (is_dir($dir)) {
            $files = glob($dir . '/*.{jpg,jpeg,png,gif}', GLOB_BRACE);
            $total_files = count($files);
            if ($total_files > 0) {
                $subscribeImage = Yii::app()->request->baseUrl . '/media/upload/images/subscribe-bg/' . basename($files[array_rand($files)]);
            }
        }

        //$this->relapCode = true;

        $postBanner = null;
        if ($post->hide_banners != 1) {
            $postBanner = Banner::getByPlace(Banner::PLACE_AFTER_POST);
        }

        $this->render('view', [
            'model' => $post,
            'relatedPosts' => $relatedPosts,
            'additionalPosts' => $additionalPosts,
            'subscribeImage' => $subscribeImage,
            'postBanner' => $postBanner,
        ]);
    }

    /**
     * Places Map Page
     */
    public function actionMap() {
        $this->style = Style::getStyleByPageKey(Style::PAGE_KEY_GTB_MAP);

        $this->render('/map/map', [
            'url' => $this->createUrl('/gtb/places'),
            'lat' => 53.8843,
            'lng' => 27.3132
        ]);
    }

    /**
     * Еще посты
     */
    public function actionMoreAdditional()
    {
        $counters = [
            'other' => Yii::app()->request->getParam('otherCount', 0),
            'top' => Yii::app()->request->getParam('topCount', 0),
        ];
        $post_id = Yii::app()->request->getParam('postId', 0);
        if (!empty($post_id)) {
            $additionalPosts = GtbPost::getAdditionalPostsList($counters, Yii::app()->params['rowsPerPostPage'], $post_id);
            $this->renderPartial('_additional_posts', $additionalPosts);
        }
    }

    /**
     * @param string $type
     */
    public function actionPlaces($type = '') {
        header('Content-type: application/json');
        echo CJSON::encode(GtbPlace::getPlacesForMap($type));
    }
}
