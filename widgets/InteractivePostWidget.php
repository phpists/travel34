<?php

class InteractivePostWidget extends CWidget
{
    public $modelId;

    public function run()
    {
        if ($this->modelId > 0) {
            $model = InteractiveWidget::model()->findByAttributes(['id' => $this->modelId]);
            if ($model !== null) {
                $results = $model->interactiveResults;
                if (!empty($results)) {

                    $result = (int)Yii::app()->request->getQuery('result');

                    if ($model->skip_step2 != 1) {
                        $name = trim(strip_tags(Yii::app()->request->getQuery('name')));
                        $name = trim(mb_substr($name, 0, 50));
                    } else {
                        $name = '';
                    }

                    $resultModel = null;
                    if ($result > 0) {
                        foreach ($results as $interactiveResult) {
                            if ($interactiveResult->id == $result) {
                                $resultModel = $interactiveResult;
                            }
                        }
                    }

                    Yii::app()->controller->interactive = true;
                    self::generateCss($model);

                    $url = Yii::app()->request->getBaseUrl(true) . '/' . Yii::app()->request->pathInfo;

                    if ($resultModel !== null) {
                        Yii::app()->controller->setPageTitle(str_replace(["\r\n", "\n", "\r"], ' ', $model->title));

                        if ($model->skip_step2 != 1) {
                            $shareUrl = $url . ((strpos($url, '?') === false ? '?' : '&') . http_build_query(['name' => $name, 'result' => $resultModel->id]));
                        } else {
                            $shareUrl = $url . ((strpos($url, '?') === false ? '?' : '&') . http_build_query(['result' => $resultModel->id]));
                        }
                    } else {
                        $name = '';
                        $shareUrl = '';
                    }


                    $this->render('interactivePost', [
                        'model' => $model,
                        'name' => $name,
                        'resultModel' => $resultModel,
                        'url' => $url,
                        'shareUrl' => $shareUrl,
                    ]);
                }
            }
        }
    }

    /**
     * @param InteractiveWidget $model
     */
    protected function generateCss($model)
    {
        $css = [
            '.iw-' . $model->id . ' .interactive-inner' => ['position' => 'relative'],
            '.iw-' . $model->id . ' .interactive-inner .sub-bg' => ['height' => '100% !important'],
            '.interactive-box.iw-' . $model->id . ':not(.step2) .step2-title' => ['display' => 'none'],
            '.interactive-box.iw-' . $model->id . '.step2 .step1-title, .interactive-box.iw-' . $model->id . '.has-result .step1-title' => ['display' => 'none'],
        ];

        if ($model->has_border == 1) {
            $border_color = !empty($model->border_color) ? $model->border_color : '000';
            $css['.interactive-box.iw-' . $model->id]['border'] = '10px solid #' . $border_color;
        }
        if (!empty($model->background_color)) {
            $css['.interactive-box.iw-' . $model->id]['background-color'] = '#' . $model->background_color;
        }
        if (!empty($model->background_image)) {
            $css['.interactive-box.iw-' . $model->id]['background-image'] = 'url("' . $model->getImageUrl('background_image') . '")';
            $css['.interactive-box.iw-' . $model->id]['background-repeat'] = 'no-repeat';
            $css['.interactive-box.iw-' . $model->id]['background-position'] = '50% 0';
        }
        if (!empty($model->step3_background_color)) {
            $css['.interactive-box.has-result.iw-' . $model->id]['background-color'] = '#' . $model->step3_background_color;
        }
        if (!empty($model->step3_background_image)) {
            $css['.interactive-box.has-result.iw-' . $model->id]['background-image'] = 'url("' . $model->getImageUrl('step3_background_image') . '")';
            $css['.interactive-box.has-result.iw-' . $model->id]['background-repeat'] = 'no-repeat';
            $css['.interactive-box.has-result.iw-' . $model->id]['background-position'] = '50% 0';
        }

        if (!empty($model->image)) {
            $css['.iw-' . $model->id . ' .sub-bg'] = [
                'background-image' => 'url("' . $model->getImageUrl('image') . '")',
                'background-position' => 'center',
                'background-repeat' => 'no-repeat',
                'background-size' => 'contain',
            ];
        }

        if (!empty($model->step1_title_color)) {
            $css['.iw-' . $model->id . ' .title.step1-title']['color'] = '#' . $model->step1_title_color . ' !important';
        }
        if ($model->step1_title_has_border == 1) {
            $border_color = !empty($model->step1_title_border_color) ? $model->step1_title_border_color : '000';
            $css['.iw-' . $model->id . ' .title.step1-title > span']['border-bottom'] = '7px solid #' . $border_color . ' !important';
        }
        if (!empty($model->step2_title_color)) {
            $css['.iw-' . $model->id . ' .title.step2-title']['color'] = '#' . $model->step2_title_color . ' !important';
        }
        if ($model->step2_title_has_border == 1) {
            $border_color = !empty($model->step2_title_border_color) ? $model->step2_title_border_color : '000';
            $css['.iw-' . $model->id . ' .title.step2-title > span']['border-bottom'] = '7px solid #' . $border_color . ' !important';
        }
        if (!empty($model->step3_title_color)) {
            $css['.iw-' . $model->id . ' .name-title']['color'] = '#' . $model->step3_title_color . ' !important';
        }
        if ($model->step3_title_has_border == 1) {
            $border_color = !empty($model->step3_title_border_color) ? $model->step3_title_border_color : '000';
            $css['.iw-' . $model->id . ' .name-title > span']['border-bottom'] = '7px solid #' . $border_color . ' !important';
        }

        if (!empty($model->step2_text_color)) {
            $css['.iw-' . $model->id . ' .enter-name-box label']['color'] = '#' . $model->step2_text_color;
        }
        if (!empty($model->step3_text_color)) {
            $css['.iw-' . $model->id . ' .interactive-result p']['color'] = '#' . $model->step3_text_color;
        }

        $border_color = !empty($model->step1_button_border_color) ? $model->step1_button_border_color : '000';
        $css['.iw-' . $model->id . ' .btn.js-start-interactive']['border'] = '3px solid #' . $border_color;
        $border_color = !empty($model->step2_button_border_color) ? $model->step2_button_border_color : '000';
        $css['.iw-' . $model->id . ' .btn.js-show-result']['border'] = '3px solid #' . $border_color;
        $border_color = !empty($model->step3_button_border_color) ? $model->step3_button_border_color : '000';
        $css['.iw-' . $model->id . ' .btn.js-update-result, .iw-' . $model->id . ' .btn.js-reload-interactive']['border'] = '3px solid #' . $border_color;

        if (!empty($model->step1_button_color)) {
            $css['.iw-' . $model->id . ' .btn.js-start-interactive']['background'] = '#' . $model->step1_button_color;
        }
        if (!empty($model->step2_button_color)) {
            $css['.iw-' . $model->id . ' .btn.js-show-result']['background'] = '#' . $model->step2_button_color;
        }
        if (!empty($model->step3_button_color)) {
            $css['.iw-' . $model->id . ' .btn.js-update-result, .iw-' . $model->id . ' .btn.js-reload-interactive']['background'] = '#' . $model->step3_button_color;
        }

        if (!empty($model->step1_button_hover_color)) {
            $css['.iw-' . $model->id . ' .btn.js-start-interactive:hover']['background'] = '#' . $model->step1_button_hover_color . ' !important';
        }
        if (!empty($model->step2_button_hover_color)) {
            $css['.iw-' . $model->id . ' .btn.js-show-result:hover']['background'] = '#' . $model->step2_button_hover_color . ' !important';
        }
        if (!empty($model->step3_button_hover_color)) {
            $css['.iw-' . $model->id . ' .btn.js-update-result:hover, .iw-' . $model->id . ' .btn.js-reload-interactive:hover']['background'] = '#' . $model->step3_button_hover_color . ' !important';
        }

        if (!empty($model->step1_button_shadow_color)) {
            $css['.iw-' . $model->id . ' .btn.js-start-interactive']['box-shadow'] = '4px 4px 0 0 #' . $model->step1_button_shadow_color;
        }
        if (!empty($model->step2_button_shadow_color)) {
            $css['.iw-' . $model->id . ' .btn.js-show-result']['box-shadow'] = '4px 4px 0 0 #' . $model->step2_button_shadow_color;
        }
        if (!empty($model->step3_button_shadow_color)) {
            $css['.iw-' . $model->id . ' .btn.js-update-result, .iw-' . $model->id . ' .btn.js-reload-interactive']['box-shadow'] = '4px 4px 0 0 #' . $model->step3_button_shadow_color;
        }

        if (!empty($model->step1_button_hover_shadow_color)) {
            $css['.iw-' . $model->id . ' .btn.js-start-interactive:hover']['box-shadow'] = '4px 4px 0 0 #' . $model->step1_button_hover_shadow_color . ' !important';
        }
        if (!empty($model->step2_button_hover_shadow_color)) {
            $css['.iw-' . $model->id . ' .btn.js-show-result:hover']['box-shadow'] = '4px 4px 0 0 #' . $model->step2_button_hover_shadow_color . ' !important';
        }
        if (!empty($model->step3_button_hover_shadow_color)) {
            $css['.iw-' . $model->id . ' .btn.js-update-result:hover, .iw-' . $model->id . ' .btn.js-reload-interactive:hover']['box-shadow'] = '4px 4px 0 0 #' . $model->step3_button_hover_shadow_color . ' !important';
        }

        $css = Common::generateCss($css);

        /** @var CClientScript $cs */
        $cs = Yii::app()->clientScript;
        $cs->registerCss('interactive-custom-css-' . $model->id, $css);
    }
}
