<?php

class CookiesHelper extends CApplicationComponent
{
    public function setCMsg($name, $value, $options = [])
    {
        if (is_array($value)) {
            Yii::app()->request->cookies[$name] = new CHttpCookie($name, json_encode($value), $options);
        } else {
            Yii::app()->request->cookies[$name] = new CHttpCookie($name, $value, $options);
        }

        return true;
    }

    public function getCMsg($name)
    {
        if (!empty(Yii::app()->request->cookies[$name])) {
            $return = json_decode(Yii::app()->request->cookies[$name]);
            if (json_last_error() == JSON_ERROR_NONE && !is_string($return)) {
                return $return;
            } else {
                return Yii::app()->request->cookies[$name]->value;
            }
        } else {
            return false;
        }
    }

    public function getCMsgDate($name)
    {
        if (!empty(Yii::app()->request->cookies[$name])) {
            $return = json_decode(Yii::app()->request->cookies[$name]);
            if (json_last_error() == JSON_ERROR_NONE && !is_string($return)) {
                return $return;
            } else {
                return Yii::app()->request->cookies[$name];
            }
        } else {
            return false;
        }
    }

    public function updateCMsg($name, $value, $options = [])
    {
        if (!empty(Yii::app()->request->cookies[$name])) {
            $return = json_decode(Yii::app()->request->cookies[$name]);
            if (json_last_error() == JSON_ERROR_NONE && !is_string($return)) {
                array_push($return, $value);
                Yii::app()->request->cookies[$name] = new CHttpCookie($name, json_encode($return), $options);
                return true;
            } else {
                Yii::app()->request->cookies[$name] = new CHttpCookie($name, $value, $options);
                return true;
            }
        } else {
            return false;
        }
    }

    public function delCMsg($name = null)
    {
        unset(Yii::app()->request->cookies[$name]);
        return true;
    }
}
