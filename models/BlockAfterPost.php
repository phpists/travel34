<?php

declare(strict_types=1);

/**
 * @property int $id
 * @property string $title
 * @property string $text
 * @property string $image
 * @property string $button_url
 * @property string $button_text
 * @property string $background_color
 * @property string $button_color
 * @property string $button_hover_color
 * @property string $button_text_color
 * @property string $text_color
 */
class BlockAfterPost extends TravelActiveRecord
{
    /**
     * @inheritDoc
     */
    public function tableName(): string
    {
        return '{{block_after_post}}';
    }

    /**
     * @inheritDoc
     */
    public function behaviors(): array
    {
        return [
            'CAdvancedArFindBehavior' => [
                'class' => 'application.behaviors.CAdvancedArFindBehavior',
            ],
            'CAdvancedArBehavior' => [
                'class' => 'application.behaviors.CAdvancedArBehavior',
            ],
            'uploadImage' => [
                'class' => 'application.behaviors.UploadFileBehavior',
                'attrName' => 'image',
                'savePath' => self::IMAGES_PATH,
                'fileTypes' => 'svg',
            ],
        ];
    }

    /**
     * @inheritDoc
     */
    public function rules(): array
    {
        return [
            ['title, button_text', 'length', 'max' => 255],
            ['button_url', 'length', 'max' => 2048],
            [
                'button_url',
                'match',
                'pattern' =>
                    '/^https?:\/\/(?:www\.)?[-a-zA-Z0-9@:%._\+~#=]{1,256}\.[a-zA-Z0-9()]{1,6}\b(?:[-a-zA-Z0-9()@:%_\+.~#?&\/=]*)$/',
                'message' => 'Введите валидный url, например: https://example.com/my-link.'
            ],
            ['text', 'safe'],
            ['id, title, button_text, button_url, image', 'safe', 'on' => 'search'],
            ['button_color, background_color, text_color, button_text_color, button_hover_color', 'safe'],
        ];
    }

    /**
     * @inheritDoc
     */
    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'button_url' => 'URL',
            'button_text' => 'Текст кнопки',
            'title' => Yii::t('app', 'Title'),
            'image' => 'Картинка (SVG)',
            'text' => 'Текст',
            'button_color' => 'Цвет кнопки (фон)',
            'button_hover_color' => 'Цвет кнопки (фон) при наведении',
            'button_text_color' => 'Цвет кнопки (текст)',
            'background_color' => 'Цвет фона',
            'text_color' => 'Цвет текста',
        ];
    }

    /**
     * @return CActiveDataProvider
     */
    public function search(): CActiveDataProvider
    {
        $criteria = new CDbCriteria();

        $criteria->compare('id', $this->id);
        $criteria->compare('button_url', $this->button_url, true);
        $criteria->compare('button_text', $this->button_text, true);
        $criteria->compare('text', $this->text, true);
        $criteria->compare('title', $this->title, true);
        $criteria->compare('image', $this->image, true);

        return new CActiveDataProvider($this, [
            'criteria' => $criteria,
            'pagination' => [
                'pageSize' => self::PAGE_SIZE,
            ],
            'sort' => [
                'defaultOrder' => 'id ASC',
            ],
        ]);
    }

    /**
     * @param string $className
     * @return static
     */
    public static function model($className = __CLASS__): BlockAfterPost
    {
        return parent::model($className);
    }
}