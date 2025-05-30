<?php

/**
 * @property int $status_id
 */
abstract class TravelActiveRecord extends CActiveRecord
{
    const NO = 0;
    const YES = 1;

    const STATUS_DISABLED = 0;
    const STATUS_ENABLED = 1;

    const PAGE_SIZE = 30;

    const IMAGES_PATH = 'media/posts';

    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            'CTimestampBehavior' => [
                'class' => 'zii.behaviors.CTimestampBehavior',
                'createAttribute' => 'created_at',
                'updateAttribute' => 'updated_at',
                'setUpdateOnCreate' => true,
            ],
            'CAdvancedArFindBehavior' => [
                'class' => 'application.behaviors.CAdvancedArFindBehavior',
            ],
            'CAdvancedArBehavior' => [
                'class' => 'application.behaviors.CAdvancedArBehavior',
            ],
        ];
    }

    /**
     * Scopes conditions
     * @return array
     */
    public function scopes()
    {
        $tableAlias = $this->getTableAlias();
        return [
            'enabled' => [
                'condition' => $tableAlias . '.status_id = ' . self::STATUS_ENABLED,
            ],
        ];
    }

    /**
     * @return array
     */
    public static function getStatusOptions()
    {
        return [
            self::STATUS_DISABLED => Yii::t('app', 'Disabled'),
            self::STATUS_ENABLED => Yii::t('app', 'Enabled'),
        ];
    }

    /**
     * @return array
     */
    public static function getYesNoOptions()
    {
        return [
            self::NO => 'Нет',
            self::YES => 'Да',
        ];
    }

    /**
     * @return array
     */
    public static function getAllowedStatusRange()
    {
        return array_keys(self::getStatusOptions());
    }

    /**
     * @param int $statusId
     * @return string
     */
    public function getStatusText($statusId = null)
    {
        if (!$statusId) {
            $statusId = $this->status_id;
        }
        $statusOptions = self::getStatusOptions();
        return isset($statusOptions[$statusId]) ? $statusOptions[$statusId] : '';
    }

    /**
     * @param string $imageField
     * @param bool $absolute
     * @return string
     */
    public function getImageUrl($imageField, $absolute = false)
    {
        if (!empty($this->$imageField)) {
            return 'https://34travel.me' . '/' . static::IMAGES_PATH . '/' . $this->$imageField;
        }
        return '';
    }

    /**
     * @param string $imageField
     * @return string
     */
    public function getImagePath($imageField)
    {
        if (!empty($this->$imageField)) {
            return Yii::getPathOfAlias('webroot') . '/' . static::IMAGES_PATH . '/' . $this->$imageField;
        }
        return '';
    }

    private static $items = [];

    /**
     * @param string $order
     * @param string $key
     * @param string $value
     * @return array
     */
    public static function getItemsList($order = 'title', $key = 'id', $value = 'title')
    {
        $items_key = md5(static::model()->tableName() . $order . $key . $value);
        if (!array_key_exists($items_key, self::$items)) {
            $result = Yii::app()->db->createCommand()
                ->select("$key, $value")
                ->from(static::model()->tableName())
                ->order($order)
                ->query();

            $array = [];
            foreach ($result as $row) {
                $array[$row[$key]] = $row[$value];
            }

            self::$items[$items_key] = $array;
        }
        return self::$items[$items_key];
    }

    /**
     * @param string $param
     * @return string
     */
    public function getGeoTargets($param = 'geo_target_codes')
    {
        $countries = Yii::app()->params['countries'];
        $result = [];
        foreach ($this->$param as $code) {
            if (isset($countries[$code])) {
                $result[] = $countries[$code];
            }
        }
        return implode(', ', $result);
    }
}
