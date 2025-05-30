<?php

/**
 * Parent controller for all frontend controllers
 */
class FrontEndController extends Controller
{
    public $layout = '//layouts/column1';

    public $menu = [];
    public $breadcrumbs = [];

    public $facebookKey = '';
    public $twitterKey = '';
    public $vkKey = '';

    public $pathInfo = '';

    public $topImage = '';
    public $topTitle = '';
    public $topLink = '';
    public $topHome = false;

    public $hideTopBanner = false;

    public $bannerSystems = [];

    public $style = []; // брендирование

    public $htmlClasses = [];
    public $bodyClasses = [];
    public $allClasses = [];

    public $oldPostStyles = false;

    /** @var string Страна для геотрагетинга */
    public $country = 'other';

    public $socialLinks = [
        'facebook' => [
            'url' => '',
            'class' => '',
            'title' => '',
        ],
    ];

    public $isNewStyledPost = false;

    public $roulette;

    public $interactive = false;
    public $interactiveTest = false;

    public $relapCode = false;

    private $_pageTitle;
    private $_metaDescription;
    private $_metaKeywords = '';

    private $_pageOgUrl;
    private $_pageOgImage;

    /**
     * @inheritdoc
     * @throws CException
     */
    public function init()
    {
        Yii::import('ext.hoauth.models.*');
        $socialConfig = UserOAuth::getConfig();
        $this->facebookKey = $socialConfig['providers']['Facebook']['keys']['id'];
        $this->twitterKey = $socialConfig['providers']['Twitter']['keys']['key'];
        $this->vkKey = $socialConfig['providers']['Vkontakte']['keys']['id'];

        /** @var GtbLocaleHttpRequest $request */
        $request = Yii::app()->request;
        $this->pathInfo = Yii::app()->createAbsoluteUrl($request->getPathInfo());

        $path = trim($request->getOriginalPathInfo(), '/');
        /** @var SeoTag $model */
        $model = SeoTag::model()->findByAttributes(['path' => $path]);
        if ($model !== null) {
            $this->_pageTitle = $model->title;
            $this->_metaDescription = $model->description;
            $this->_pageOgImage = $model->getImageUrl('image', true);
        }

        $this->country = Yii::app()->geo->updateContry();

        $country_from_get = Yii::app()->request->getQuery('country');
        if (!empty($country_from_get)) {
            $this->redirect(['/site/main']);
        }

        return parent::init();
    }

    /**
     * @return string
     */
    public function getPageTitle()
    {
        if (!empty($this->_pageTitle)) {
            return $this->_pageTitle;
        }
        return parent::getPageTitle();
    }

    /**
     * @return string
     */
    public function getMetaDescription()
    {
        if ($this->_metaDescription === null) {
            $this->_metaDescription = 'Гайды, истории, репортажи, лайфхаки, эксперименты, фотопроекты, новости и поводы для путешествий.';
        }
        return $this->_metaDescription;
    }

    /**
     * @param string $description
     */
    public function setMetaDescription($description)
    {
        $this->_metaDescription = $description;
    }

    /**
     * @return string
     */
    public function getMetaKeywords()
    {
        return $this->_metaKeywords;
    }

    /**
     * @param string $keywords
     */
    public function setMetaKeywords($keywords)
    {
        $this->_metaKeywords = $keywords;
    }

    /**
     * OG URL
     * @return string
     */
    public function getUrl()
    {
        if (empty($this->_pageOgUrl)) {
            $this->_pageOgUrl = Yii::app()->request->hostInfo . Yii::app()->request->requestUri;
        }
        return $this->_pageOgUrl;
    }

    /**
     * OG URL
     * @param string $url
     */
    public function setUrl($url)
    {
        $this->_pageOgUrl = Common::fullUrl($url);
    }

    /**
     * OG Image
     * @return string
     */
    public function getPageOgImage()
    {
        if (empty($this->_pageOgImage)) {
            $this->_pageOgImage = Yii::app()->request->hostInfo . Yii::app()->theme->baseUrl . '/images/travel_teaser.jpg';
        }
        return $this->_pageOgImage;
    }

    /**
     * OG Image
     * @param string $img
     */
    public function setPageOgImage($img)
    {
        $this->_pageOgImage = Common::fullUrl($img);
    }

    protected function renderJSON($data)
    {
        header('Content-type: application/json');
        echo CJSON::encode($data);

        foreach (Yii::app()->log->routes as $route) {
            if($route instanceof CWebLogRoute) {
                $route->enabled = false;
            }
        }
        Yii::app()->end();
    }
}
