<?php

/**
 * @property integer $id
 * @property string $name
 * @property string $description
 * @property string $title_paywall
 * @property string $description_paywall
 */
class Setting extends TravelActiveRecord
{
    /**
     * @return string
     */
    public function tableName()
    {
        return '{{setting}}';
    }

    public function behaviors()
    {
        return [
            'CAdvancedArFindBehavior' => [
                'class' => 'application.behaviors.CAdvancedArFindBehavior',
            ],
            'CAdvancedArBehavior' => [
                'class' => 'application.behaviors.CAdvancedArBehavior',
            ],
        ];
    }

    public function scopes()
    {
        return [];
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            ['name', 'default'],
            ['description', 'safe'],
            ['title_paywall', 'default'],
            ['description_paywall', 'safe'],
            ['title, description, title_paywall, description_paywall', 'safe', 'on' => 'search'],
        ];
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Id',
            'name' => 'Название',
            'description' => 'Значение',
            'title_paywall' => 'Заголовок Paywall',
            'description_paywall' => 'Описание Paywall',
        ];
    }

    /**
     * @return CActiveDataProvider
     */
    public function search()
    {
        $criteria = new CDbCriteria();

        $criteria->compare('id', $this->id);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('description', $this->description, true);
        $criteria->compare('title_paywall', $this->title_paywall, true);
        $criteria->compare('description_paywall', $this->description_paywall, true);

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
     * @return SeoTag
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public static function getPaywallTitles($post)
    {
        $titlePaywall = 'Получи доступ к материалам и десяткам фирменных гайдов 34travel!';
        $descriptionPaywall = 'Гайды 34travel – это авторские путеводители, которые
                    облегчают планирование путешествий. Внутри – классические достопримечательности и альтернативная
                    арт-сцена, заведения с отличным вайбом и laptop-friendly кофейни, шоурумы локальных брендов,
                    самые веселые бары и советы, которые помогут стать в городе своим(-ей).';

        try {
            $setting = Setting::model()->findByAttributes(['name' => 'paywall']);

            if (isset($post->title_paywall) && $post->description_paywall){
                $titlePaywall =  $post->title_paywall;
                $descriptionPaywall = $post->description_paywall;
            } else {
                $titlePaywall =  $setting->title_paywall;
                $descriptionPaywall = $setting->description_paywall;
            }

            return [
                'title' => strip_tags($titlePaywall),
                'description' => strip_tags($descriptionPaywall)
            ];
        } catch (\Exception $e) {
            return [
                'title' => strip_tags($titlePaywall),
                'description' => strip_tags($descriptionPaywall)
            ];
        }
    }
}