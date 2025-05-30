<?php

/**
 * Изменение размеров с обрезкой и без на лету
 * Ссылки на изображения относительно корня сайта
 *
 * Примеры:
 * echo CHtml::image(ResizeHelper::init()->image('uploads/pic.jpg')->crop(500, 500));
 * echo CHtml::image(ResizeHelper::init()->image('uploads/pic.jpg')->silhouette()->quality(95)->fit(500, 500));
 * echo CHtml::image(ResizeHelper::init()->image('uploads/pic.jpg')->fitWidth(500));
 * echo CHtml::image(ResizeHelper::init()->image('uploads/pic.jpg')->fitHeight(500));
 * echo CHtml::image(ResizeHelper::init()->image('uploads/pic.jpg')->background('ffcccc')->place(500, 500));
 */
class ResizeHelper
{
    /**
     * @var string Путь к папке сайта
     */
    private $webRoot;

    /**
     * @var string Ссылка на папку resized
     */
    private $baseFolderUrl;

    /**
     * @var string Путь к папке resized
     */
    private $baseFolderPath;

    /**
     * @var int JPEG качество генерируемых картиноу
     */
    private $quality;

    /**
     * @var string Относительная ссылка на оригинальную картинку
     */
    private $imageUrl;

    /**
     * @var string Путь к картинке по-умолчанию, если не найден оригинал.
     */
    private $defaultImagePath;

    /**
     * @var array Цвет основы
     */
    private $bg;

    /**
     * @var array mime-типы изображений
     */
    private $mimeTypes = ['image/gif', 'image/jpeg', 'image/png'];

    /**
     * @var resource
     */
    private $im;

    /**
     * @var string
     */
    private $newImageUrl;

    /**
     * @var string
     */
    private $newImagePath;

    /**
     * @var bool
     */
    private $preserveAlpha = false;

    /**
     * ResizeHelper::init()->image('uploads/image.jpg')->quality(70)->crop(100, 100);
     *
     * @return self
     */
    public static function init()
    {
        $className = __CLASS__;
        return new $className;
    }

    /**
     * __construct
     */
    public function __construct()
    {
        $this->webRoot = Yii::getPathOfAlias('webroot');
        $this->baseFolderUrl = Yii::app()->baseUrl . '/assets/resized';
        $this->baseFolderPath = Yii::getPathOfAlias('webroot.assets') . '/resized';
        $this->quality = 90;
        $this->defaultImagePath = __DIR__ . '/resize/no-image.png';
        $this->bg = ['r' => 255, 'g' => 255, 'b' => 255];
    }

    /**
     * Задать ссылку на картинку
     *
     * @param string $imageUrl
     *
     * @return $this
     */
    public function image($imageUrl)
    {
        $this->imageUrl = $imageUrl;
        return $this;
    }

    /**
     * Задать ссылку на папку resized
     *
     * @param string $url
     *
     * @return $this
     */
    public function baseFolderUrl($url)
    {
        $url = '/' . trim($url, '/');
        $this->baseFolderUrl = Yii::app()->baseUrl . $url;
        $this->baseFolderPath = $this->webRoot . $url;
        return $this;
    }

    /**
     * Задать качество JPEG
     *
     * @param int $quality
     *
     * @return $this
     */
    public function quality($quality)
    {
        $this->quality = (int)$quality;
        if ($this->quality > 100) {
            $this->quality = 100;
        }
        if ($this->quality < 1) {
            $this->quality = 1;
        }
        return $this;
    }

    /**
     * Задать картинку по-умолчанию
     *
     * @param string $image
     *
     * @return $this
     */
    public function defaultImagePath($image)
    {
        $this->defaultImagePath = $image;
        return $this;
    }

    /**
     * Отображать силуэт
     *
     * @return $this
     */
    public function silhouette()
    {
        $this->defaultImagePath = __DIR__ . '/resize/no-image-person.png';
        return $this;
    }

    /**
     * Задает цвет основы
     *
     * @param string $hex
     *
     * @return $this
     */
    public function background($hex)
    {
        $this->bg = $this->hex2rgb($hex);
        return $this;
    }

    /**
     * Включить сохранение альфа-слоя (для png)
     *
     * @return $this
     */
    public function preserveAlpha()
    {
        $this->preserveAlpha = true;
        return $this;
    }

    /**
     * Изменение размеров с обрезанием до нужных размеров
     *
     * @param int $width
     * @param int $height
     * @param bool $force_resize
     *
     * @return string Путь к сгенерированной картинке
     */
    public function crop($width, $height, $force_resize = false)
    {
        return $this->resize($width, $height, 'crop', $force_resize);
    }

    /**
     * Изменение размеров с вписыванием по ширине и высоте
     *
     * @param int $width
     * @param int $height
     * @param bool $force_resize
     *
     * @return string Путь к сгенерированной картинке
     */
    public function fit($width, $height, $force_resize = false)
    {
        return $this->resize($width, $height, 'fit', $force_resize);
    }

    /**
     * Изменить до нужной ширины
     *
     * @param int $width
     * @param bool $force_resize
     *
     * @return string
     */
    public function fitWidth($width, $force_resize = false)
    {
        return $this->resize($width, $width, 'fitw', $force_resize);
    }

    /**
     * Изменить до нужной высоты
     *
     * @param int $height
     * @param bool $force_resize
     *
     * @return string
     */
    public function fitHeight($height, $force_resize = false)
    {
        return $this->resize($height, $height, 'fith', $force_resize);
    }

    /**
     * картинка вмещается в заданные размеры и помещается на подложку этих размеров
     *
     * @param int $width
     * @param int $height
     * @param bool $force_resize
     *
     * @return string
     */
    public function place($width, $height, $force_resize = false)
    {
        return $this->resize($width, $height, 'place', $force_resize);
    }

    /**
     * Изменение размеров с вписыванием по ширине и/или высоте или с обрезанием до нужных размеров
     *
     * @param int $width Новая ширина
     * @param int $height Новая высота
     * @param string $method Метод изменения: crop, fit, fitw, fith или place
     * @param bool $force_resize Форсировать изменение размеров, если исходные и конечные размеры одинаковы
     *
     * @return string|bool Путь к сгенерированной картинке или false, если возникла ошибка
     */
    private function resize($width, $height, $method = 'crop', $force_resize = false)
    {
        $orig_image_url = $this->imageUrl;

        $width = (int)$width;
        $height = (int)$height;
        // если не задааны размеры - используем $defaultImagePath
        if ($width <= 0 || $height <= 0) {
            $full_path = $this->defaultImagePath;
        } else {
            // абсолютный путь к картинке
            $full_path = Common::findFile($this->imageUrl);
            // если картинки нет - используем $defaultImagePath
            if (empty($full_path) || !is_file($full_path)) {
                $full_path = $this->defaultImagePath;
            }
        }

        // если даже $defaultImagePath не найден, вернем оригинальный url
        if (!is_file($full_path)) {
            return false;
        }

        // получим mime-тип
        $mimeType = CFileHelper::getMimeType($full_path);
        if ($mimeType === null) {
            return false;
        }

        // не тот mime-тип
        if (!in_array($mimeType, $this->mimeTypes)) {
            return false;
        }

        // размеры исходного изображения
        $sizes = getimagesize($full_path);
        if (!$sizes) {
            return false;
        }
        $w = $sizes[0];
        $h = $sizes[1];
        if ($w == 0 || $h == 0) {
            return false;
        }

        // проверим размеры исходной картинки
        if (!$force_resize) {
            if (
                ($method == 'fitw' && $width == $w) ||
                ($method == 'fith' && $height == $h) ||
                ($method != 'fitw' && $method != 'fith' && $width == $w && $height == $h)
            ) {
                return $orig_image_url;
            }
        }

        $is_png = ($mimeType == 'image/png' && $this->preserveAlpha);

        // имя и путь к новой картинке
        $new_filename = md5($full_path . filesize($full_path)) . '.' . ($is_png ? 'png' : 'jpg');
        $_bg_color = $this->rgb2hex($this->bg);
        $_is_png = $is_png ? '1' : '0';
        $new_folder_p1 = md5("{$width}-{$height}-{$this->quality}-{$_bg_color}-{$method}-{$_is_png}");
        $new_folder_p2 = substr($new_filename, 0, 2);
        $new_folder_url = $this->baseFolderUrl . '/' . $new_folder_p1 . '/' . $new_folder_p2;
        $new_folder_path = $this->baseFolderPath . '/' . $new_folder_p1 . '/' . $new_folder_p2;

        // создадим папку
        if (!is_dir($new_folder_path)) {
            if (!mkdir($new_folder_path, 0755, true)) {
                return false;
            }
        }

        // новая ссылка и абсолютный путь
        $this->newImageUrl = $new_folder_url . '/' . $new_filename;
        $this->newImagePath = $new_folder_path . '/' . $new_filename;

        // если файл уже есть
        if (is_file($this->newImagePath)) {
            return $this->newImageUrl;
        }

        // создаем ресурс из исходной картинки
        $this->im = false;
        switch ($mimeType) {
            case 'image/gif':
                $this->im = imagecreatefromgif($full_path);
                break;
            case 'image/jpeg':
                $this->im = imagecreatefromjpeg($full_path);
                break;
            case 'image/png':
                $this->im = imagecreatefrompng($full_path);
                break;
            default :
                return $orig_image_url;
        }

        if ($this->im !== false) {

            $dst_x = 0;
            $dst_y = 0;
            $x = 0;
            $y = 0;

            // обрезать по ширине и высоте (hard crop)
            if ($method == 'crop') {
                $ratio = max($width / $w, $height / $h);
                $new_w = round($w * $ratio);
                $new_h = round($h * $ratio);
                $x = round(($w - $width / $ratio) / 2);
                $y = round(($h - $height / $ratio) / 2);
            } // вместить по ширине (высота может быть и меньше, и больше)
            elseif ($method == 'fitw') {
                $new_w = $width;
                $new_h = $new_w / $w * $h;
                // зададим новые размеры готовой картинки
                $width = $new_w;
                $height = $new_h;
            } // вместить по высоте (ширина может быть и меньше, и больше)
            elseif ($method == 'fith') {
                $new_h = $height;
                $new_w = $new_h * $w / $h;
                // зададим новые размеры готовой картинки
                $width = $new_w;
                $height = $new_h;
            } // вместить по ширине и высоте и разместить на обложке указанных размеров
            elseif ($method == 'place') {
                $ratio = min($width / $w, $height / $h);
                $new_w = round($w * $ratio);
                $new_h = round($h * $ratio);
                $dst_x = round(($width - $new_w) / 2);
                $dst_y = round(($height - $new_h) / 2);
            } // вместить по ширине и высоте - fit
            else {
                $ratio = min($width / $w, $height / $h);
                $new_w = round($w * $ratio);
                $new_h = round($h * $ratio);
                // зададим новые размеры готовой картинки
                $width = $new_w;
                $height = $new_h;
            }

            // создание и копирование
            $this->_saveImage($width, $height, $dst_x, $dst_y, $x, $y, $new_w, $new_h, $w, $h, $is_png);

            // новый путь
            if (is_file($this->newImagePath)) {
                return $this->newImageUrl;
            }
        }

        return false;
    }

    /**
     * Сохранение картинки.
     * Если задано сохранение альфа-канала и исхожная картинка PNG, будет сгенерирован новый PNG с прозрачностью.
     * Иначе картинка будет сохранена в JPEG.
     *
     * @param int $width Ширина подложки
     * @param int $height Высота подложки
     * @param int $dst_x Отступ X ужатой картинки на подложке
     * @param int $dst_y Отступ Y ужатой картинки на подложке
     * @param int $x Отступ X оригинальной картинки
     * @param int $y Отступ Y оригинальной картинки
     * @param int $new_w Ширина ужатой картинки
     * @param int $new_h Высота ужатой картинки
     * @param int $w Ширина участка для обрезки оригинальной картинки
     * @param int $h Высота участка для обрезки оригинальной картинки
     * @param bool $is_png Сохранить ли альфа-канал для PNG
     */
    private function _saveImage($width, $height, $dst_x, $dst_y, $x, $y, $new_w, $new_h, $w, $h, $is_png = false)
    {
        // создание и копирование
        $new_im = imagecreatetruecolor($width, $height);
        if ($is_png) {
            imagealphablending($new_im, false);
            imagesavealpha($new_im, true);
            $transparent = imagecolorallocatealpha($new_im, 255, 255, 255, 127);
            imagefilledrectangle($new_im, 0, 0, $width, $height, $transparent);
        } else {
            $bg_color = imagecolorallocate($new_im, $this->bg['r'], $this->bg['g'], $this->bg['b']);
            imagefill($new_im, 0, 0, $bg_color);
        }
        imagecopyresampled($new_im, $this->im, $dst_x, $dst_y, $x, $y, $new_w, $new_h, $w, $h);

        // сохранение
        if ($is_png) {
            imagepng($new_im, $this->newImagePath);
        } else {
            imagejpeg($new_im, $this->newImagePath, $this->quality);
        }

        imagedestroy($this->im);
        imagedestroy($new_im);
    }

    /**
     * Преобразует строку с HEX-цветом в массив RGB
     *
     * @param string $hex Например, 666666, 369, cf05ff, #63cf20, #f30
     *
     * @return array
     */
    private function hex2rgb($hex)
    {
        $hex = str_replace('#', '', $hex);
        if (!preg_match('/^[0-9a-f]+$/', $hex)) {
            return ['r' => 255, 'g' => 255, 'b' => 255];
        }

        if (strlen($hex) == 3) {
            $r = hexdec(substr($hex, 0, 1) . substr($hex, 0, 1));
            $g = hexdec(substr($hex, 1, 1) . substr($hex, 1, 1));
            $b = hexdec(substr($hex, 2, 1) . substr($hex, 2, 1));
        } else {
            $r = hexdec(substr($hex, 0, 2));
            $g = hexdec(substr($hex, 2, 2));
            $b = hexdec(substr($hex, 4, 2));
        }

        return ['r' => $r, 'g' => $g, 'b' => $b];
    }

    /**
     * Преобразует массив RGB в строку с HEX-цветом
     *
     * @param array $rgb
     *
     * @return string
     */
    private function rgb2hex($rgb)
    {
        $hex = str_pad(dechex($rgb['r']), 2, '0', STR_PAD_LEFT);
        $hex .= str_pad(dechex($rgb['g']), 2, '0', STR_PAD_LEFT);
        $hex .= str_pad(dechex($rgb['b']), 2, '0', STR_PAD_LEFT);

        return $hex;
    }
}