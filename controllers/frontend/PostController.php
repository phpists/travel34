<?php

class PostController extends FrontEndController
{
    /**
     * @var string
     */
    public $layout = '//layouts/column1';

    public function actions()
    {
        return [
            'captcha' => [
                'class' => 'CCaptchaAction',
                'backColor' => 0xFFFFFF,
            ],
        ];
    }

    /**
     * Displays a particular model.
     * @param string $url url of the page
     */
    public function actionView($url)
    {
        $post = $this->loadModel($url);
        if ($post->is_gtb_post == 1 && !empty($post->gtb_post_id)) {
            $url = GtbPost::getUrlById($post->gtb_post_id);
            if ($url) {
                $this->redirect($url);
            }
        }
        if ($post->is_gtu_post == 1 && !empty($post->gtu_post_id)) {
            $url = GtuPost::getUrlById($post->gtu_post_id);
            if ($url) {
                $this->redirect($url);
            }
        }

        if ($post->hide_banners == 1) {
            $this->hideTopBanner = true;
        }

        /*
         * Increment views.
         * @TODO: IP address checking is needed.
         */
        if (Yii::app()->getRequest()->getParam('get_only_comments_count', 0) == 1) {
            echo $post->comments_count;
            exit;
        }
        if (Yii::app()->getRequest()->getParam('get_only_views_count', 0) == 1) {
            echo $post->views_count;
            exit;
        }
        /** @var CookiesHelper $cookiesHelper */
        $cookiesHelper = Yii::app()->cookiesHelper;
        if ($post->isEnabled() && !$cookiesHelper->getCMsg('view_post_' . $post->id)) {
            $post->views_count += 1;
            $post->save();
            $options = ['expire' => time() + 3600 * 12];
            $cookiesHelper->setCMsg('view_post_' . $post->id, 'y', $options);
        }

        $newsBanner = null;
        $postBanner = null;
        if ($post->hide_banners != 1) {
            $newsBanner = Banner::getByPlace(Banner::PLACE_NEWS_VERTICAL);
            $postBanner = Banner::getByPlace(Banner::PLACE_AFTER_POST);
        }

        if ($post->is_big_top == 1 && !empty($post->image_top)) {
            // Supertop
            $this->topImage = $post->getImageUrl('image_top');
            $this->topTitle = $post->title;
            $this->topLink = '#post-text';
        } elseif ($post->hide_styles != 1) {
            $this->style = Style::getStyleByPageKey(Style::PAGE_KEY_POST, $post->id);
        }

        $relatedPosts = [];
        $additionalPosts = [];
        if (!$post->isNews()) {
            $relatedPosts = $post->getRelatedPostsList(Yii::app()->params['relatedPostsCount']);
            $counters = [
                'other' => 0,
                'smallTop' => 0,
            ];
            $additionalPosts = Post::model()->getPostsList($counters, Yii::app()->params['rowsPerPostPage'], $post->id);
        }

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

        $this->render($post->is_new ? 'view' : 'view_old', [
            'model' => $post,
            'newsBanner' => $newsBanner,
            'additionalPosts' => $additionalPosts,
            'subscribeImage' => $subscribeImage,
            'relatedPosts' => $relatedPosts,
            'postBanner' => $postBanner,
        ]);
    }

    /**
     * Еще посты
     */
    public function actionMore()
    {
        $counters = [
            'other' => Yii::app()->request->getParam('otherCount', 0),
            'smallTop' => Yii::app()->request->getParam('smallTopCount', 0),
        ];
        $postID = Yii::app()->request->getParam('postID', 0);
        if (!empty($postID)) {
            $result = Post::model()->getPostsList($counters, Yii::app()->params['rowsPerPostPage'], $postID);
            $result['postID'] = $postID;
            $this->renderPartial('_posts', $result);
        }
    }

    /**
     * @param string $url
     * @return Post the loaded model
     * @throws CHttpException
     */
    public function loadModel(string $url)
    {
        /** @var WebUser $user */
        $user = Yii::app()->user;
        $isAdmin = !empty($user) && $user->isAdmin();
        $isAdvertiser = !empty($user) && $user->isAdvertiser();
        if ($isAdmin || $isAdvertiser) {
            /** @var Post $model */
            $model = Post::model()->findByAttributes(['url' => $url]);
        } else {
            /** @var Post $model */
            $model = Post::model()->statusEnabled()->findByAttributes(['url' => $url]);
        }
        if ($model === null) {
            throw new CHttpException(404, Yii::t('app', 'The requested page does not exist.'));
        }
        return $model;
    }

    public function loadModelForShow()
    {

    }
}
