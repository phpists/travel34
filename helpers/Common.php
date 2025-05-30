<?php

class Common
{
    /**
     * @param string $url
     * @return string
     */
    public static function assetsTime($url)
    {
        if (strpos($url, 'http://') === 0 || strpos($url, 'https://') === 0 || strpos($url, '//') === 0) {
            return $url;
        }
        // try from web server root
        if (substr($url, 0, 1) == '/') {
            $path = $_SERVER['DOCUMENT_ROOT'] . $url;
            if (is_file($path)) {
                return $url . '?v=' . filemtime($path);
            }
        }
        $original_url = $url;
        // check site base url
        $base_url = Yii::app()->request->baseUrl;
        if (!empty($base_url) && strpos($url, $base_url) === 0) {
            $url = substr($url, strlen($base_url));
        }
        $path = Yii::getPathOfAlias('webroot') . '/' . ltrim($url, '/');
        if (is_file($path)) {
            return $original_url . '?v=' . filemtime($path);
        }
        return $original_url;
    }

    /**
     * Преобразует все URL в абсолютные
     * Пример для сайта с адресом "http://domain/siteroot/"
     * "//domain/siteroot/folder/file.zip" -> "http://domain/siteroot/folder/file.zip"
     * "siteroot/folder/file.zip" и "/siteroot/folder/file.zip" -> "http://domain/siteroot/folder/file.zip"
     * "folder/file.zip" и "/folder/file.zip" -> "http://domain/siteroot/folder/file.zip"
     * @param string $url
     * @return string
     */
    public static function fullUrl($url)
    {
        if (strpos($url, 'http://') === 0 || strpos($url, 'https://') === 0) {
            return $url;
        }
        if (strpos($url, '//') === 0) {
            return (Yii::app()->request->isSecureConnection ? 'https' : 'http') . $url;
        }
        $url = '/' . ltrim($url, '/');
        $base_url = Yii::app()->request->baseUrl;
        if (!empty($base_url) && strpos($url, $base_url) === 0) {
            return Yii::app()->request->hostInfo . $url;
        } else {
            return Yii::app()->request->getBaseUrl(true) . $url;
        }
    }

    /**
     * Поиск файла по относительному пути
     * Если найден, вернет абсолютный путь
     * @param string $path
     * @return bool|string
     */
    public static function findFile($path)
    {
        if (strpos($path, 'http://') === 0 || strpos($path, 'https://') === 0 || strpos($path, '//') === 0) {
            return false;
        }
        $path = '/' . ltrim(str_replace('\\', '/', $path), '/');
        $base_url = Yii::app()->request->baseUrl;
        if (!empty($base_url) && strpos($path, $base_url) === 0) {
            $path = mb_substr($path, mb_strlen($base_url));
        }
        $path = Yii::getPathOfAlias('webroot') . $path;
        return is_file($path) ? $path : false;
    }

    /**
     * @param string $style
     * @param string $url
     */
    public static function showBackground($style, $url)
    {
        /** @var CClientScript $cs */
        $cs = Yii::app()->clientScript;

        if (!empty($style)) {
            $cs->registerCss('body_bkg', 'body{height:auto;' . $style . '}');
        }
        if (!empty($url)) {
            $cs->registerCss('body_bkg_cursor', 'body{cursor:pointer}body div{cursor:auto}');
            $js = "$('body').on('click', function(e) { if (e.target != this) return; window.open('$url', '_blank'); });";
            $cs->registerScript('body_bkg_link', $js);
        }
    }

    /**
     * @param array $additional
     * @param bool $old
     * @return array
     */
    public static function getCKEditorOptions($additional = [], $old = false)
    {
        $options = [
            'customConfig' => Common::assetsTime('/themes/travel/ckeditor/config.js'),
            'contentsCss' => Common::assetsTime('/themes/travel/ckeditor/contents.css'),
            'stylesSet' => 'full_width:' . Common::assetsTime('/themes/travel/ckeditor/styles.js'),
            'templates' => 'templates',
            'templates_files' => [Common::assetsTime('/themes/travel/ckeditor/templates.js')],
            'templates_replaceContent' => 'js:false',
            'fullpage' => 'js:true',
            //'resize_maxWidth' => '1280',
            //'resize_minWidth' => '320',
            'filebrowserImageBrowseUrl' => Yii::app()->createUrl('/elfinder/editor', ['filter' => 'image']),
            'filebrowserBrowseUrl' => Yii::app()->createUrl('/elfinder/editor'),
        ];
        if ($old) {
            $options['customConfig'] = Common::assetsTime('/themes/travel/ckeditor_old/config.js');
            $options['contentsCss'] = Common::assetsTime('/themes/travel/ckeditor_old/contents.css');
            $options['stylesSet'] = 'full_width:' . Common::assetsTime('/themes/travel/ckeditor_old/styles.js');
            $options['templates_files'] = [Common::assetsTime('/themes/travel/ckeditor_old/templates.js')];
        }
        return CMap::mergeArray($options, $additional);
    }

    /**
     * @param array $additional
     * @return array
     */
    public static function getCKEditorSimpleOptions($additional = [])
    {
        $options = [
            'fullpage' => 'js:true',
            //'resize_maxWidth' => '1280',
            //'resize_minWidth' => '320',
            'filebrowserImageBrowseUrl' => Yii::app()->createUrl('/elfinder/editor', ['filter' => 'image']),
            'filebrowserBrowseUrl' => Yii::app()->createUrl('/elfinder/editor'),
        ];
        return CMap::mergeArray($options, $additional);
    }

    private static $sxGeo;

    /**
     * Код страны по IP
     * @param string $ip
     * @return string|bool
     */
    public static function getCountryCodeFromIP($ip)
    {
        if (self::$sxGeo === null) {
            self::$sxGeo = false;
            $sxGeo_dat = Yii::getPathOfAlias('application') . '/data/SxGeo.dat';
            if (is_file($sxGeo_dat)) {
                self::$sxGeo = new SxGeo($sxGeo_dat, SXGEO_BATCH);
            }
        }
        if (self::$sxGeo !== false) {
            $cc = self::$sxGeo->getCountry($ip);
            return mb_strtolower("{$cc}");
        }
        return false;
    }

    /**
     * Generate CSS from array
     * @param array $rules
     * @param int $indent
     * @return string
     */
    public static function generateCss($rules, $indent = 0)
    {
        $css = '';
        $prefix = str_repeat('  ', $indent);

        foreach ($rules as $key => $value) {
            if (is_array($value)) {
                $selector = $key;
                $properties = $value;

                $css .= $prefix . "$selector {\n";
                $css .= self::generateCss($properties, $indent + 1);
                $css .= $prefix . "}\n";
            } else {
                $property = $key;
                $css .= $prefix . "$property: $value;\n";
            }
        }
        return $css;
    }

    /**
     * @return array
     */
    public static function zenCatgories()
    {
        $array = [
            //'Авто',
            //'Война',
            'Дизайн',
            //'Дом',
            'Еда',
            //'Здоровье',
            //'Знаменитости',
            //'Игры',
            //'Кино',
            'Культура',
            //'Литература',
            //'Мода',
            //'Музыка',
            //'Наука',
            //'Общество',
            //'Политика',
            'Природа',
            //'Происшествия',
            //'Психология',
            'Путешествия',
            //'Спорт',
            //'Технологии',
            'Фотографии',
            //'Хобби',
            //'Экономика',
            //'Юмор',
        ];
        return array_combine($array, $array);
    }
}
