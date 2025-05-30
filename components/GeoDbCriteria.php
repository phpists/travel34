<?php

class GeoDbCriteria extends CDbCriteria
{
    /**
     * @inheritdoc
     */
    public function __construct($data = [])
    {
        parent::__construct($data);

        // Геотаргетинг
        $cc = Yii::app()->geo->country;
        $criteria2 = new CDbCriteria();
        $criteria2->addCondition("geo_target = ''", 'OR');
        $criteria2->addCondition("geo_target IS NULL", 'OR');
        $criteria2->compare("geo_target", $cc, true, 'OR');
        $this->mergeWith($criteria2);
    }
}
