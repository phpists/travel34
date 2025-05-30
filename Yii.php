<?php

/**
 * {@inheritdoc}
 * Only for autocomplete. Based on Yii 2 solution
 * @see https://github.com/samdark/yii2-cookbook/blob/master/book/ide-autocompletion.md
 */
class Yii extends YiiBase
{
    /**
     * @return BaseApplication|WebApplication|ConsoleApplication|CApplication
     */
    public static function app()
    {
        return parent::app();
    }
}

/**
 * Class BaseApplication
 * Used for properties that are identical for both WebApplication and ConsoleApplication
 *
 * @property CHttpSession $session
 */
abstract class BaseApplication extends CApplication
{
}

/**
 * Class WebApplication
 * Include only Web application related components here
 *
 * @property WebUser $user
 */
class WebApplication extends CWebApplication
{
}

/**
 * Class ConsoleApplication
 * Include only Console application related components here
 */
class ConsoleApplication extends CConsoleApplication
{
}
