<?php

declare(strict_types=1);

class BlockAfterPostHelper
{
    /**
     * @return BlockAfterPost|null
     */
    public static function get()
    {
        $criteria = new CDbCriteria();

        $criteria->order = 'id DESC';
        $criteria->limit = 1;
        $blocks = BlockAfterPost::model()->findAll($criteria);

        if (empty($blocks)) {
            return null;
        }

        return array_shift($blocks); // get first block
    }
}