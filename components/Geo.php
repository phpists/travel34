<?php

class Geo extends CApplicationComponent
{
    /**
     * @var string
     */
    public $country = 'other';

    /**
     * @return string
     */
    public function updateContry()
    {
//        $country_from_get = Yii::app()->request->getQuery('country');
//        if (!empty($country_from_get) && isset(Yii::app()->params['displayCountries'][$country_from_get])) {
//            $this->country = $country_from_get;
//        } else {
//            $country = Yii::app()->request->cookies->contains('country') ? Yii::app()->request->cookies['country']->value : '';
//            if (!empty($country) && isset(Yii::app()->params['displayCountries'][$country])) {
//                $this->country = $country;
//            } else {
//                // get from ip
//                $country = Common::getCountryCodeFromIP(Yii::app()->request->userHostAddress);
//                if (!empty($country) && isset(Yii::app()->params['displayCountries'][$country])) {
//                    $this->country = $country;
//                }
//            }
//        }

        Yii::app()->request->cookies['country'] = new CHttpCookie('country', $this->country, ['expire' => time() + 31536000]); // 1 year

        return $this->country;
    }
}
