<?php

/**
 * This is the model class for table "{{gtu_place}}".
 *
 * The followings are the available columns in table '{{gtu_place}}':
 * @property integer $id
 * @property integer $author_id
 * @property string $related_posts
 * @property string $related_posts_gtu
 * @property string $related_posts_gtb
 * @property integer $status_id
 * @property float $lat
 * @property float $lng
 * @property string $type
 * @property string $description
 * @property string $created_at
 * @property string $updated_at
 *
 * @method GtuPlace enabled()
 */
class GtuPlace extends BasePlace
{

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return '{{gtu_place}}';
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return GtuPost the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     * @param string $type
     * @param null $class
     * @return array
     */
    public static function getPlacesForMap($type = '', $class = null) {
        return parent::getPlacesForMap($type, get_class(self::model()));
    }
}
