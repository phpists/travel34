<?php

class SiteController extends FrontEndController
{
    /**
     * @return array
     */
    public function actions()
    {
        return [
            'oauth' => [
                'class' => 'ext.hoauth.HOAuthAction',
                'model' => 'User',
                'attributes' => [
                    'email' => 'email',
                    'username' => 'displayName',
                    'identifier' => 'identifier',
                    'profile_url' => 'profileURL',
                    'profile_img' => 'photoURL',
                ],
            ],
            'sitemapxml' => [
                'class' => 'ext.sitemap.ESitemapXMLAction',
                'classConfig' => [],
                'importListMethod' => 'getBaseSitePageList',
            ],
        ];
    }

    /**
     * Provide the static site pages which are not database generated
     *
     * Each array element represents a page and should be an array of
     * 'loc', 'frequency' and 'priority' keys
     *
     * @return array[]
     */
    public function getBaseSitePageList()
    {
        $list = [
            [
                'loc' => Yii::app()->getBaseUrl(true) . '/',
                'frequency' => 'daily',
                'priority' => '1',
                'lastmod' => Post::getLastPostDate(),
            ],
            [
                'loc' => Yii::app()->createAbsoluteUrl('news/index'),
                'frequency' => 'daily',
                'priority' => '0.5',
                'lastmod' => Post::getLastNewsDate(),
            ],
            [
                'loc' => Yii::app()->createAbsoluteUrl('geo/index'),
                'frequency' => 'daily',
                'priority' => '0.5',
            ],
            [
                'loc' => Yii::app()->createAbsoluteUrl('people/index'),
                'frequency' => 'daily',
                'priority' => '0.5',
            ],
            [
                'loc' => Yii::app()->createAbsoluteUrl('rubric/index'),
                'frequency' => 'daily',
                'priority' => '0.5',
            ],
            [
                'loc' => Yii::app()->createAbsoluteUrl('gtb/index'),
                'frequency' => 'daily',
                'priority' => '0.5',
                'lastmod' => GtbPost::getLastPostDate(),
            ],
            [
                'loc' => Yii::app()->createAbsoluteUrl('gtb/index', ['language' => 'en']),
                'frequency' => 'daily',
                'priority' => '0.5',
                'lastmod' => GtbPost::getLastPostDate('en'),
            ],
        ];

        // Rubric
        $result = Yii::app()->db->createCommand()
            ->select('url')
            ->from(Rubric::model()->tableName())
            ->where('status_id = :status_id', [':status_id' => Rubric::STATUS_ENABLED])
            ->order('id')
            ->query();
        foreach ($result as $row) {
            $list[] = [
                'loc' => Yii::app()->getBaseUrl(true) . '/rubrics/' . $row['url'],
                'frequency' => 'daily',
                'priority' => '0.5',
                'lastmod' => '',
            ];
        }

        // Post
        $result = Yii::app()->db->createCommand()
            ->select('url, date')
            ->from(Post::model()->tableName())
            ->where('status_id = :status_id AND is_gtb_post != 1 AND date <= NOW()', [':status_id' => Post::STATUS_ENABLED])
            ->order('date DESC, id DESC')
            ->query();
        foreach ($result as $row) {
            $list[] = [
                'loc' => Yii::app()->getBaseUrl(true) . '/post/' . $row['url'],
                'frequency' => 'yearly',
                'priority' => '0.8',
                'lastmod' => $row['date'],
            ];
        }

        // GtbRubric RU & EN
        $result = Yii::app()->db->createCommand()
            ->select('url')
            ->from(GtbRubric::model()->tableName())
            ->where('status_id = :status_id', [':status_id' => GtbRubric::STATUS_ENABLED])
            ->order('id')
            ->query();
        foreach ($result as $row) {
            $list[] = [
                'loc' => Yii::app()->getBaseUrl(true) . '/gotobelarus/rubric/' . $row['url'],
                'frequency' => 'daily',
                'priority' => '0.5',
                'lastmod' => '',
            ];
            $list[] = [
                'loc' => Yii::app()->getBaseUrl(true) . '/gotobelarus/en/rubric/' . $row['url'],
                'frequency' => 'daily',
                'priority' => '0.5',
                'lastmod' => '',
            ];
        }

        // GtbPost RU
        $result = Yii::app()->db->createCommand()
            ->select('url, date')
            ->from(GtbPost::model()->tableName())
            ->where('language = :language AND status_id = :status_id AND date <= NOW()', [':language' => 'ru', ':status_id' => GtbPost::STATUS_ENABLED])
            ->order('date DESC, id DESC')
            ->query();
        foreach ($result as $row) {
            $list[] = [
                'loc' => Yii::app()->getBaseUrl(true) . '/gotobelarus/post/' . $row['url'],
                'frequency' => 'yearly',
                'priority' => '0.8',
                'lastmod' => $row['date'],
            ];
        }

        // GtbPost EN
        $result = Yii::app()->db->createCommand()
            ->select('url, date')
            ->from(GtbPost::model()->tableName())
            ->where('language = :language AND status_id = :status_id AND date <= NOW()', [':language' => 'en', ':status_id' => GtbPost::STATUS_ENABLED])
            ->order('date DESC, id DESC')
            ->query();
        foreach ($result as $row) {
            $list[] = [
                'loc' => Yii::app()->getBaseUrl(true) . '/gotobelarus/en/post/' . $row['url'],
                'frequency' => 'yearly',
                'priority' => '0.8',
                'lastmod' => $row['date'],
            ];
        }

        return $list;
    }

    /**
     * Index page
     */
    public function actionIndex()
    {
        $this->layout = '//layouts/bulk';
        $this->render('view');
    }

    /**
     * Homepage
     */
    public function actionMain()
    {
        // count how much posts of each type were actually shown
        $counters = [
            'excluded' => '',
            'news' => 0,
            'other' => 0,
            'smallTop' => 0,
        ];

        $data = Post::getHomePostsList($counters, Yii::app()->params['rowsPerHomePage']);

        $this->style = Style::getStyleByPageKey(Style::PAGE_KEY_MAIN);

        if (isset($data['megaTopPost'])) {
            /** @var Post $megaTopPost */
            $megaTopPost = $data['megaTopPost'];
            $this->topImage = $megaTopPost->getImageUrl('image_top');
            $this->topTitle = $megaTopPost->title;
            $this->topLink = $megaTopPost->getUrl() . '#post-text';
            $this->topHome = true;
            unset($data['megaTopPost']);
        }

        $this->render('main', $data);
    }

    /**
     * More posts on homepage
     */
    public function actionMore()
    {
        $counters = [
            'excluded' => Yii::app()->request->getParam('excluded', 0),
            'news' => Yii::app()->request->getParam('newsCount', 0),
            'other' => Yii::app()->request->getParam('otherCount', 0),
            'smallTop' => Yii::app()->request->getParam('smallTopCount', 0),
        ];
        $result = Post::getHomePostsList($counters, Yii::app()->params['rowsPerHomePage'], false);
        $this->renderPartial('_posts', $result);
    }

    /**
     * Registers new user from Social logon, collects username and email if needed
     *
     * @param User $user current user model
     * @param \Hybridauth\User\Profile $profile
     * @param string $provider
     * @param array $attributes Map model attributes to attributes of user's social profile
     * @param array $availableAtts Hybridauth attributes
     * @return CActiveRecord
     * @throws Exception
     */
    public function hoauthProcessUser($user, $profile, $provider, $attributes, $availableAtts)
    {
        foreach ($attributes as $model_attr => $hoauth_attr) {
            if (in_array($hoauth_attr, $availableAtts)) {
                if ($hoauth_attr == 'displayName' && (!empty($profile->firstName) || !empty($profile->lastName))) {
                    $att = trim($profile->firstName . ' ' . $profile->lastName);
                } else {
                    $att = $profile->$hoauth_attr;
                }
                if (!empty($att)) {
                    // use custom avatar url
                    if ($model_attr == 'profile_img' && $provider == 'Twitter') {
                        $user->$model_attr = 'https://twitter.com/' . $profile->displayName . '/profile_image?size=bigger';
                    } else {
                        $user->$model_attr = $att;
                    }
                }
            } else {
                $user->$model_attr = $hoauth_attr;
            }
        }
        if ($user->isNewRecord) {
            $user->provider = $provider;
            $user->password = $provider;
        }
        if (!$user->save()) {
            throw new Exception("Error, while saving User model:\n\n" . var_export($user->errors, true));
        }

        return $user;
    }

    /**
     * Текстовая страница
     * @param string $url
     * @throws CHttpException
     */
    public function actionPage($url)
    {
        /** @var Page $model */
        $model = Page::model()->findByAttributes(['url' => $url]);

        $isAdmin = !empty(Yii::app()->user) && Yii::app()->user->isAdmin();
        if ($model === null || !($model->status_id == Post::STATUS_ENABLED || $isAdmin)) {
            throw new CHttpException(404, Yii::t('app', 'The requested page does not exist.'));
        }

        $this->style = Style::getStyleByPageKey(Style::PAGE_KEY_PAGE, $model->id);

        $this->render('page', [
            'model' => $model,
        ]);
    }

    public function actionGrammar()
    {
        $url = Yii::app()->request->getPost('url');
        $text = Yii::app()->request->getPost('text');
        $comment = Yii::app()->request->getPost('comment');

        if (empty($url) || empty($text)) {
            echo json_encode(['status' => 'error']);
            Yii::app()->end();
        }

        $mailer = new YiiMailer();
        $mailer->setView('grammar');
        $mailer->setFrom(Yii::app()->params['senderEmail']);
        $mailer->setTo(Yii::app()->params['adminEmail']);
        $mailer->setSubject(sprintf('[%s] Ошибка на сайте', Yii::app()->name));
        $mailer->setData([
            'url' => $url,
            'text' => $text,
            'comment' => $comment,
        ]);
        if ($mailer->send()) {
            echo json_encode(['status' => 'ok']);
        } else {
            echo json_encode(['status' => 'error']);
        }

        Yii::app()->end();
    }

    /**
     * Proposal Form
     */
    public function actionProposal()
    {
        $model = new ProposalForm();

        if (isset($_POST['ProposalForm']) && Yii::app()->request->isAjaxRequest) {
            $model->attributes = $_POST['ProposalForm'];
            //$model->form_type = 'roulette';
            usleep(200000);
            if ($model->validate()) {
                $result = $model->saveData();
                echo json_encode([
                    'success' => $result,
                ]);
            } else {
                echo json_encode([
                    'success' => false,
                    'errors' => $model->errors,
                ]);
            }
        }

        Yii::app()->end();
    }

    public function actionPosts()
    {
        $result = Yii::app()->db->createCommand()
            ->select('id, url, title, is_gtb_post, gtb_post_id')
            ->from(Post::model()->tableName())
            ->order('created_at DESC')
            ->andWhere('type_id != :type', [':type' => Post::TYPE_NEWS])
            ->limit(300)
            ->query();

        $array = [];
        foreach ($result as $row) {
            $array[$this->getPostUrl($row)] = $row['title'];
        }

        header('Content-type: application/json; encode=UTF-8');
        echo json_encode($array, JSON_UNESCAPED_UNICODE);
        Yii::app()->end();
    }

    protected function getPostUrl($row)
    {
        if ($row['is_gtb_post'] == '1' && !empty($row['gtb_post_id'])) {
            $url = GtbPost::getUrlById($row['gtb_post_id']);
            if ($url) {
                return $url;
            }
        }
        if (!empty($row['url'])) {
            return Yii::app()->getBaseUrl(true) . '/post/' . $row['url'];
        }
        return '#';
    }

    /**
     * Превью теста в админке
     * @param int $id
     */
    public function actionPreviewTest($id)
    {
        $this->render('previewTest', ['id' => $id]);
    }

    /**
     * Превью интерактива в админке
     * @param int $id
     */
    public function actionPreviewInteractive($id)
    {
        $this->render('previewInteractive', ['id' => $id]);
    }

    /**
     * Check mail sending
     * /site/testMail?to=email@example.com
     * @param string $to
     * @throws CHttpException
     */
    public function actionTestMail($to)
    {
        if (!filter_var($to, FILTER_VALIDATE_EMAIL)) {
            throw new CHttpException(500, sprintf('"%s" is wrong email.', $to));
        }
        if (!Yii::app()->user->isAdmin()) {
            throw new CHttpException(500, 'You must be logged in as admin.');
        }
        $mailer = new YiiMailer();
        $mailer->SMTPDebug = 3;
        $mailer->setView('test');
        $mailer->setFrom(Yii::app()->params['senderEmail']);
        $mailer->setTo($to);
        $mailer->setSubject(sprintf('[%s] Тестовое письмо', Yii::app()->name));
        $mailer->setData([
            'date' => date('r'),
        ]);
        if ($mailer->send()) {
            echo '<h1>Good!</h1>';
        } else {
            echo '<h1>Error!</h1>';
        }
    }
}
