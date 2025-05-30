<?php

class TestPostWidget extends CWidget
{
    public $modelId;

    public function run()
    {
        if ($this->modelId > 0) {
            $model = TestWidget::model()->findByAttributes(['id' => $this->modelId]);
            if ($model !== null) {
                $results = $model->testResults;
                if (!empty($results)) {
                    $questions = TestQuestion::model()->sorted()->findAllByAttributes(['test_widget_id' => $model->id]);

                    $question_ids = [];
                    foreach ($questions as $question) {
                        $question_ids[] = $question->id;
                    }
                    $variants = TestVariant::model()->sorted()->findAllByAttributes(['test_question_id' => $question_ids]);
                    $questionsVariants = [];
                    foreach ($variants as $variant) {
                        $questionsVariants[$variant->test_question_id][] = $variant;
                    }

                    Yii::app()->controller->interactiveTest = true;
                    self::generateCss($model);

                    $this->render('testPost', [
                        'model' => $model,
                        'questions' => $questions,
                        'questionsVariants' => $questionsVariants,
                    ]);
                }
            }
        }
    }

    /**
     * @param TestWidget $model
     */
    protected function generateCss($model)
    {
        $css = [
            '.itw-' . $model->id . ' .interactive-test' => ['overflow' => 'hidden'],
            '.itw-' . $model->id . ' .top-branding img, .itw-' . $model->id . ' .bottom-branding img' => ['display' => 'block'],
            '.itw-' . $model->id . ' .has-images .test-radio-item img' => ['display' => 'block'],
        ];

        if ($model->type == TestWidget::TYPE_ONE) {
            $correct_answer_color = $model->correct_answer_color ?: '45b173';
            $wrong_answer_color = $model->wrong_answer_color ?: 'ff561b';

            $css['.itw-' . $model->id . ' .test-answer .true p span'] = ['color' => '#fff', 'background-color' => '#' . $correct_answer_color];
            $css['.itw-' . $model->id . ' .test-answer .false p:first-child span'] = ['color' => '#fff', 'background-color' => '#' . $wrong_answer_color];
            $css['.itw-' . $model->id . ' .test-answer .false p:last-child span'] = ['color' => '#' . $correct_answer_color, 'background-color' => '#fff'];
            $css['.itw-' . $model->id . ' .test-radio-item input[type="radio"]:checked + label .checked-bg'] = ['background-color' => '#' . $wrong_answer_color];
            $css['.itw-' . $model->id . ' .test-radio-item input[type="radio"][data-boolean="true"] + label .checked-bg'] = ['background-color' => '#' . $correct_answer_color . ' !important'];
        }

        if ($model->has_border == 1) {
            $border_color = !empty($model->border_color) ? $model->border_color : '000';
            $css['.interactive-test-box.itw-' . $model->id]['border'] = '10px solid #' . $border_color;
            if (!empty($model->step2_border_color)) {
                $css['.interactive-test-box.itw-middle-step.itw-' . $model->id]['border-color'] = '#' . $model->step2_border_color;
            }
            if (!empty($model->step3_border_color)) {
                $css['.interactive-test-box.itw-final-step.itw-' . $model->id]['border-color'] = '#' . $model->step3_border_color;
            }
        }

        // фон первого шага
        if (!empty($model->background_color)) {
            $css['.interactive-test-box:not(.itw-middle-step):not(.itw-final-step).itw-' . $model->id]['background-color'] = '#' . $model->background_color;
        }
        if (!empty($model->background_image)) {
            $css['.interactive-test-box:not(.itw-middle-step):not(.itw-final-step).itw-' . $model->id]['background-image'] = 'url("' . $model->getImageUrl('background_image') . '")';
            $css['.interactive-test-box:not(.itw-middle-step):not(.itw-final-step).itw-' . $model->id]['background-repeat'] = 'no-repeat';
            $css['.interactive-test-box:not(.itw-middle-step):not(.itw-final-step).itw-' . $model->id]['background-position'] = '50% 0';
        }

        // фон шагов с вопросами
        if (!empty($model->step2_background_color)) {
            $css['.interactive-test-box.itw-middle-step.itw-' . $model->id]['background-color'] = '#' . $model->step2_background_color;
        }
        if (!empty($model->step2_background_image)) {
            $css['.interactive-test-box.itw-middle-step.itw-' . $model->id]['background-image'] = 'url("' . $model->getImageUrl('step2_background_image') . '")';
            $css['.interactive-test-box.itw-middle-step.itw-' . $model->id]['background-repeat'] = 'no-repeat';
            $css['.interactive-test-box.itw-middle-step.itw-' . $model->id]['background-position'] = '50% 0';
        }

        // фон финального шага
        if (!empty($model->step3_background_color)) {
            $css['.interactive-test-box.itw-final-step.itw-' . $model->id]['background-color'] = '#' . $model->step3_background_color;
        }
        if (!empty($model->step3_background_image)) {
            $css['.interactive-test-box.itw-final-step.itw-' . $model->id]['background-image'] = 'url("' . $model->getImageUrl('step3_background_image') . '")';
            $css['.interactive-test-box.itw-final-step.itw-' . $model->id]['background-repeat'] = 'no-repeat';
            $css['.interactive-test-box.itw-final-step.itw-' . $model->id]['background-position'] = '50% 0';
        }

        // цвет текста первого шага
        if (!empty($model->step1_text_color)) {
            $css['.itw-' . $model->id . ' .start-step p:not(.test-title)']['color'] = '#' . $model->step1_text_color . ' !important';
        }
        // цвет текста шагов с вопросами
        if (!empty($model->step2_text_color)) {
            $css['.itw-' . $model->id . ' .middle-step p:not(.test-title)']['color'] = '#' . $model->step2_text_color . ' !important';
        }
        // цвет текста шагов с вопросами
        if (!empty($model->step2_variants_text_color)) {
            $css['.itw-' . $model->id . ' .middle-step .test-radio-item label']['color'] = '#' . $model->step2_variants_text_color . ' !important';
            $css['.itw-' . $model->id . ' .middle-step .test-radio-item label a']['color'] = 'inherit !important';
        }
        // цвет текста финального шага
        if (!empty($model->step3_text_color)) {
            $css['.itw-' . $model->id . ' .final-step p:not(.test-title)']['color'] = '#' . $model->step3_text_color . ' !important';
        }
        // выравнивание текста результата
        $css['.itw-' . $model->id . ' .final-step p:not(.test-title)']['text-align'] = 'left';

        // заголовок первого шага
        if (!empty($model->step1_title_color)) {
            $css['.itw-' . $model->id . ' .start-step .test-title']['color'] = '#' . $model->step1_title_color . ' !important';
        }
        if ($model->step1_title_has_border == 1) {
            $border_color = !empty($model->step1_title_border_color) ? $model->step1_title_border_color : '000';
            $css['.itw-' . $model->id . ' .start-step .test-title > span']['border-bottom'] = '7px solid #' . $border_color . ' !important';
        }

        // заголовок шагов с вопросами
        if (!empty($model->step2_title_color)) {
            $css['.itw-' . $model->id . ' .middle-step .test-title']['color'] = '#' . $model->step2_title_color . ' !important';
        }
        if ($model->step2_title_has_border == 1) {
            $border_color = !empty($model->step2_title_border_color) ? $model->step2_title_border_color : '000';
            $css['.itw-' . $model->id . ' .middle-step .test-title > span']['border-bottom'] = '7px solid #' . $border_color . ' !important';
        }

        // заголовок финального шага
        if (!empty($model->step3_title_color)) {
            $css['.itw-' . $model->id . ' .final-step .test-title']['color'] = '#' . $model->step3_title_color . ' !important';
        }
        if ($model->step3_title_has_border == 1) {
            $border_color = !empty($model->step3_title_border_color) ? $model->step3_title_border_color : '000';
            $css['.itw-' . $model->id . ' .final-step .test-title > span']['border-bottom'] = '7px solid #' . $border_color . ' !important';
        }

        // граница кнопок
        $border_color = !empty($model->step1_button_border_color) ? $model->step1_button_border_color : '000';
        $css['.itw-' . $model->id . ' .start-step .buttons-box .btn']['border'] = '3px solid #' . $border_color;
        $border_color = !empty($model->step2_button_border_color) ? $model->step2_button_border_color : '000';
        $css['.itw-' . $model->id . ' .middle-step .buttons-box .btn']['border'] = '3px solid #' . $border_color;
        $border_color = !empty($model->step3_button_border_color) ? $model->step3_button_border_color : '000';
        $css['.itw-' . $model->id . ' .final-step .buttons-box .btn']['border'] = '3px solid #' . $border_color;

        // цвет текста кнопок
        if (!empty($model->step1_button_text_color)) {
            $css['.itw-' . $model->id . ' .start-step .buttons-box .btn']['color'] = '#' . $model->step1_button_text_color;
        }
        if (!empty($model->step2_button_text_color)) {
            $css['.itw-' . $model->id . ' .middle-step .buttons-box .btn']['color'] = '#' . $model->step2_button_text_color;
        }
        if (!empty($model->step3_button_text_color)) {
            $css['.itw-' . $model->id . ' .final-step .buttons-box .btn']['color'] = '#' . $model->step3_button_text_color;
        }

        // фоновый цвет кнопок
        if (!empty($model->step1_button_color)) {
            $css['.itw-' . $model->id . ' .start-step .buttons-box .btn']['background'] = '#' . $model->step1_button_color;
        }
        if (!empty($model->step2_button_color)) {
            $css['.itw-' . $model->id . ' .middle-step .buttons-box .btn']['background'] = '#' . $model->step2_button_color;
        }
        if (!empty($model->step3_button_color)) {
            $css['.itw-' . $model->id . ' .final-step .buttons-box .btn']['background'] = '#' . $model->step3_button_color;
        }

        // фоновый цвет кнопок при наведении
        if (!empty($model->step1_button_hover_color)) {
            $css['.itw-' . $model->id . ' .start-step .buttons-box .btn:hover']['background'] = '#' . $model->step1_button_hover_color . ' !important';
        }
        if (!empty($model->step2_button_hover_color)) {
            $css['.itw-' . $model->id . ' .middle-step .buttons-box .btn:hover']['background'] = '#' . $model->step2_button_hover_color . ' !important';
        }
        if (!empty($model->step3_button_hover_color)) {
            $css['.itw-' . $model->id . ' .final-step .buttons-box .btn:hover']['background'] = '#' . $model->step3_button_hover_color . ' !important';
        }

        // цвет тени кнопок
        if (!empty($model->step1_button_shadow_color)) {
            $css['.itw-' . $model->id . ' .start-step .buttons-box .btn']['box-shadow'] = '4px 4px 0 0 #' . $model->step1_button_shadow_color;
        }
        if (!empty($model->step2_button_shadow_color)) {
            $css['.itw-' . $model->id . ' .middle-step .buttons-box .btn']['box-shadow'] = '4px 4px 0 0 #' . $model->step2_button_shadow_color;
        }
        if (!empty($model->step3_button_shadow_color)) {
            $css['.itw-' . $model->id . ' .final-step .buttons-box .btn']['box-shadow'] = '4px 4px 0 0 #' . $model->step3_button_shadow_color;
        }

        // цвет тени кнопок при наведении
        if (!empty($model->step1_button_hover_shadow_color)) {
            $css['.itw-' . $model->id . ' .start-step .buttons-box .btn:hover']['box-shadow'] = '4px 4px 0 0 #' . $model->step1_button_hover_shadow_color . ' !important';
        }
        if (!empty($model->step2_button_hover_shadow_color)) {
            $css['.itw-' . $model->id . ' .middle-step .buttons-box .btn:hover']['box-shadow'] = '4px 4px 0 0 #' . $model->step2_button_hover_shadow_color . ' !important';
        }
        if (!empty($model->step3_button_hover_shadow_color)) {
            $css['.itw-' . $model->id . ' .final-step .buttons-box .btn:hover']['box-shadow'] = '4px 4px 0 0 #' . $model->step3_button_hover_shadow_color . ' !important';
        }

        $css = Common::generateCss($css);

        /** @var CClientScript $cs */
        $cs = Yii::app()->clientScript;
        $cs->registerCss('itw-custom-css-' . $model->id, $css);
    }
}
