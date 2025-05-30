<?php

class GtbPlaceController extends PlaceBaseController
{
    protected $model = 'GtbPlace';
    protected $langs = 'gtbLanguages';

    public function getViewPath()
    {
        return Yii::getPathOfAlias('application.views.backend.gtuPlace');
    }
}


