<?php

class BlocksHelper
{
    /** @var array blocks */
    private static $blocks = [];

    /**
     * @param string $name
     * @return string
     */
    public static function get($name)
    {
        if (!preg_match('/^[a-z0-9_]+$/', $name)) {
            return '';
        }

        if (!array_key_exists($name, self::$blocks)) {
            $model = Block::model()->enabled()->find([
                'select' => 'content',
                'condition' => 'name = :name',
                'params' => [':name' => $name],
            ]);
            $value = $model !== null ? $model->content : '';
            self::$blocks[$name] = $value;
        } else {
            $value = self::$blocks[$name];
        }

        return $value;
    }
}
