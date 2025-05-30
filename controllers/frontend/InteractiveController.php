<?php

class InteractiveController extends FrontEndController
{
    /**
     * Результат интерактивов
     * @throws CHttpException
     */
    public function actionResult()
    {
        $id = (int)Yii::app()->request->getPost('widgetId');
        $url = trim(strip_tags(Yii::app()->request->getPost('pageUrl')));
        $name = trim(strip_tags(Yii::app()->request->getPost('name')));

        if (empty($url)) {
            throw new CHttpException(404, 'Result not found');
        }

        $name = trim(mb_substr($name, 0, 50));

        $iw = InteractiveWidget::model()->findByPk($id);
        if ($iw === null || ($iw->skip_step2 != 1 && empty($name))) {
            throw new CHttpException(404, 'Result not found');
        }

        $results = InteractiveResult::model()->findAllByAttributes(['interactive_widget_id' => $id]);
        if (empty($results)) {
            // fake results
            $result_1 = new InteractiveResult();
            $result_1->id = 100500;
            $result_1->interactive_widget_id = $id;
            $result_1->text = '<p>fake result</p>';
            $results[] = $result_1;
        }

        $rand_key = mt_rand(0, count($results) - 1);
        $model = $results[$rand_key];

        if ($iw->skip_step2 != 1) {
            $shareUrl = $url . ((strpos($url, '?') === false ? '?' : '&') . http_build_query(['name' => $name, 'result' => $model->id]));
        } else {
            $shareUrl = $url . ((strpos($url, '?') === false ? '?' : '&') . http_build_query(['result' => $model->id]));
        }

        $this->renderPartial('result', [
            'model' => $model,
            'name' => $name,
            'shareUrl' => $shareUrl,
        ]);
    }

    /**
     * Результат тестов
     * @throws CHttpException
     */
    public function actionTest()
    {
        $id = (int)Yii::app()->request->getPost('widgetId', 0);
        $user_id = Yii::app()->request->getPost('userId');
        $answers = (array)Yii::app()->request->getPost('answers', []);
        $wins = (array)Yii::app()->request->getPost('wins', []);

        $widgetModel = TestWidget::model()->findByPk($id);
        if ($widgetModel === null) {
            throw new CHttpException(404, 'Result not found');
        }

        $results = TestResult::model()->findAllByAttributes(['test_widget_id' => $id]);
        if (empty($results)) {
            throw new CHttpException(404, 'Result not found');
        }

        if ($widgetModel->type == TestWidget::TYPE_ONE) {
            $correct_count = 0;
            foreach ($answers as $q_id => $variant_id) {
                if (isset($wins[$q_id]) && $wins[$q_id] == $variant_id) {
                    $correct_count++;
                }
            }
            $percent = round(100 * $correct_count / count($answers));
            if ($percent == 100) {
                $result_type = TestResult::CORRECT_5;
            } elseif ($percent >= 80) {
                $result_type = TestResult::CORRECT_4;
            } elseif ($percent >= 50) {
                $result_type = TestResult::CORRECT_3;
            } elseif ($percent >= 30) {
                $result_type = TestResult::CORRECT_2;
            } else {
                $result_type = TestResult::CORRECT_1;
            }

            /** @var TestResult $model */
            $model = null;
            foreach ($results as $result) {
                if ($result->correct_count == $result_type) {
                    $model = $result;
                    break;
                }
            }

            /** @var TestResult $fallback_res */
            $fallback_res = null;
            if ($model === null) {
                foreach ($results as $result) {
                    if (($fallback_res === null || $fallback_res->correct_count < $result->correct_count) && $result->correct_count <= $result_type) {
                        $fallback_res = $result;
                    }
                }
                $model = $fallback_res;
            }
            if ($model === null) {
                foreach ($results as $result) {
                    $model = $result;
                    break;
                }
            }

        } else {

            $res_count = [];
            foreach ($results as $result) {
                $result_variants = (array)$result->variants;
                $res_count[$result->id] = 0;

                foreach ($result_variants as $q_id => $result_variant) {
                    if (isset($answers[$q_id]) && $answers[$q_id] == $result_variant) {
                        $res_count[$result->id]++;
                    }
                }
            }

            $res = [];

            arsort($res_count);
            foreach ($res_count as $r_id => $r_count) {
                $res[$r_count][] = $r_id;
            }
            $first_ids = reset($res);

            $rand_id = $first_ids[array_rand($first_ids)];

            /** @var TestResult $model */
            $model = null;
            foreach ($results as $result) {
                if ($result->id == $rand_id) {
                    $model = $result;
                    break;
                }
            }

            if ($model === null) {
                $rand_key = mt_rand(0, count($results) - 1);
                $model = $results[$rand_key];
            }
        }

        TestWidget::model()->updateCounters(['finish_count' => 1], 'id = :widgetId', [':widgetId' => $id]);

        $twuModel = TestWidgetUser::model()->findByAttributes(['test_widget_id' => $id, 'user_id' => $user_id]);
        if ($twuModel !== null) {
            $twuModel->test_result_id = $model->id;
            $twuModel->finished_at = time();
            $twuModel->save();
        }

        $this->renderPartial('test', [
            'widgetModel' => $widgetModel,
            'model' => $model,
        ]);
    }

    /**
     * Сохранение инфы о начале теста
     */
    public function actionStart()
    {
        $id = (int)Yii::app()->request->getPost('widgetId', 0);
        $user_id = Yii::app()->request->getPost('userId');

        $widgetModel = TestWidget::model()->findByPk($id);
        if ($widgetModel === null) {
            return;
        }

        TestWidget::model()->updateCounters(['start_count' => 1], 'id = :widgetId', [':widgetId' => $id]);

        if (!empty($user_id)) {
            $twuModel = TestWidgetUser::model()->findByAttributes(['test_widget_id' => $id, 'user_id' => $user_id]);
            if ($twuModel === null) {
                $ip = Yii::app()->request->getUserHostAddress();
                $user_agent = Yii::app()->request->getUserAgent();
                $result = new WhichBrowser\Parser($user_agent);
                $browser = str_replace(' Dev ', ' ', $result->toString());
                $country = Common::getCountryCodeFromIP($ip);

                $newModel = new TestWidgetUser();
                $newModel->user_id = $user_id;
                $newModel->test_widget_id = $id;
                $newModel->ip = mb_strtoupper($ip);
                $newModel->user_agent = $user_agent;
                $newModel->browser = $browser;
                $newModel->country = $country;
                $newModel->started_at = time();

                $newModel->save();
            }
        }
    }
}
