<?php

/**
 * Class UploadFileBehavior
 */
class UploadFileBehavior extends CActiveRecordBehavior
{
    /**
     * @var string название атрибута, хранящего в себе имя файла и файл
     */
    public $attrName = 'image';
    /**
     * @var string название атрибута, указывающего на удаление
     */
    public $attrDelete = null;
    /**
     * @var string типы файлов, которые можно загружать (нужно для валидации)
     */
    public $fileTypes = 'jpg,jpeg,gif,png';
    /**
     * @var string макс. размер файлов (null - без ограничений)
     */
    public $maxSize = null;
    /**
     * @var string папка от корня сайта, куда загружать файлы (без слэшей в начале и конце). по умолчанию 'uploads/models/' . date('Y/m')
     */
    public $savePath = null;
    /**
     * @var int width of the image
     */
    public $width;
    /**
     * @var int height of the image
     */
    public $height;
    /**
     * @var string image dimension error message
     */
    public $dimensionError;
    /**
     * @var string Старое значение
     */
    public $oldValue;
    /**
     * @var bool Value of `attributeDelete`
     */
    protected $deleteFile = false;

    /**
     * Attaches the behavior object to the component.
     * @param CActiveRecord $owner the component that this behavior is to be attached to.
     * @throws CException
     */
    public function attach($owner)
    {
        parent::attach($owner);

        if ($this->savePath === null) {
            throw new CException("You must specify 'savePath' param.");
        }

        // добавляем валидатор файла
        $fileValidator = CValidator::createValidator('file', $owner, $this->attrName, array(
            'types' => $this->fileTypes,
            'allowEmpty' => true,
            'maxSize' => $this->maxSize,
        ));
        $owner->validatorList->add($fileValidator);

        // добавляем валидатор удаления файла
        if (!empty($this->attrDelete)) {
            $deleteValidator = CValidator::createValidator('boolean', $owner, $this->attrDelete);
            $owner->validatorList->add($deleteValidator);
        }
    }

    /**
     * @inheritdoc
     */
    public function canGetProperty($name)
    {
        if ($this->attrDelete !== null && $name === $this->attrDelete) {
            return true;
        }
        return parent::canGetProperty($name);
    }

    /**
     * @inheritdoc
     */
    public function canSetProperty($name)
    {
        if ($this->attrDelete !== null && $name === $this->attrDelete) {
            return true;
        }
        return parent::canSetProperty($name);
    }

    /**
     * @inheritdoc
     */
    public function __get($name)
    {
        if ($this->attrDelete !== null && $name === $this->attrDelete) {
            return $this->deleteFile;
        } else {
            return parent::__get($name);
        }
    }

    /**
     * @inheritdoc
     */
    public function __set($name, $value)
    {
        if ($this->attrDelete !== null && $name === $this->attrDelete) {
            $this->deleteFile = $value;
        } else {
            parent::__set($name, $value);
        }
    }

    /**
     * @param CEvent $event
     */
    public function afterFind($event)
    {
        $this->oldValue = $this->owner->getAttribute($this->attrName);
    }

    /**
     * @param CEvent $event event parameter
     */
    public function afterValidate($event)
    {
        if (isset($this->width, $this->height) && $this->width > 0 && $this->height > 0) {
            $uploadedFile = CUploadedFile::getInstance($this->owner, $this->attrName);
            if ($uploadedFile !== null) {
                $data = file_exists($uploadedFile->tempName) ? getimagesize($uploadedFile->tempName) : false;
                if ($data !== false && $data[0] != $this->width && $data[1] != $this->height) {
                    $message = $this->dimensionError ? $this->dimensionError : Yii::t('app', 'Image dimension should be {w}x{h}', array('{w}' => $this->width, '{h}' => $this->height));
                    $this->owner->addError($this->attrName, $message);
                }
            }
        }
    }

    /**
     * Перед сохранением сохраняем файл
     * @param CModelEvent $event
     * @return bool
     */
    public function beforeSave($event)
    {
        // если есть атрибут {attrDelete} и он равен 1, то удалим старый файл
        if ($this->deleteFile) {
            $this->deleteFile();
            $this->oldValue = null;
            $this->owner->setAttribute($this->attrName, null);
        }

        // коль загружен новый файл
        $uploadedFile = CUploadedFile::getInstance($this->owner, $this->attrName);
        if ($uploadedFile !== null) {
            // удалим старый файл
            $this->deleteFile();
            $this->owner->setAttribute($this->attrName, null);

            // имя файла
            $filename = uniqid() . '-' . Transliteration::file($uploadedFile->name, false);

            // путь к папке с изображениями
            $folder = Yii::getPathOfAlias('webroot') . '/' . trim($this->savePath, '\\/');
            if (!is_dir($folder)) {
                CFileHelper::createDirectory($folder, 0755, true);
            }

            // зададим имя файла при успешном сохранении
            if ($uploadedFile->saveAs($folder . '/' . $filename)) {
                $this->owner->setAttribute($this->attrName, $filename);
            }
        } else {
            $this->owner->setAttribute($this->attrName, $this->oldValue);
        }
        return true;
    }

    /**
     * Перед удвлением модели удалить файл
     * @param CEvent $event
     */
    public function beforeDelete($event)
    {
        $this->deleteFile();
    }

    /**
     * Удаление файла
     */
    protected function deleteFile()
    {
        $folder = Yii::getPathOfAlias('webroot') . '/' . trim($this->savePath, '\\/');
        $filepath = $folder . '/' . $this->oldValue;
        if (is_file($filepath)) {
            unlink($filepath);
        }
    }
}