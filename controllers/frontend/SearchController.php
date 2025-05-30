<?php

class SearchController extends FrontEndController
{
    public function actionResults()
    {
        $search_limit = 10;

        $term = Yii::app()->request->getParam('text');
        $page = (int)Yii::app()->request->getParam('page');

        if ($page < 1) {
            $page = 1;
        }

        $results = [];
        $total = 0;
        $pagination = null;
        $words = [];

        $offset = $search_limit * ($page - 1);

        $term = trim($term);

        if (!empty($term)) {

            $words = SearchHelper::cleanText($term);
            $words = SearchHelper::splitWords($words);
            $words = SearchHelper::getWordsBases($words);

            $sphinx = new SphinxClient();
            $sphinx->SetServer('localhost', 9312);
            $sphinx->SetMatchMode(SPH_MATCH_ANY);
            $sphinx->SetSortMode(SPH_SORT_RELEVANCE);
            $sphinx->SetFieldWeights(['title' => 100, 'text' => 10]);
            $sphinx->SetLimits($offset, $search_limit);
            $sphinx->SetArrayResult(true);

            $result = $sphinx->Query($term);

            $total = 0;

            if ($result !== false && !empty($result['matches'])) {
                $total = (int)$result['total'];
                if ($total > 0) {
                    $ids = [];
                    $results = [];
                    foreach ($result['matches'] as $k => $match) {
                        $ids[$match['attrs']['type_num']][$k] = $match['id'];
                        $results[$k] = null;
                    }
                    if (isset($ids['1'])) {
                        $temp_results = Yii::app()->db->createCommand()
                            ->from('{{post}}')
                            ->where(['in', 'id', $ids['1']])
                            ->andWhere('status_id = :status_id', [':status_id' => Post::STATUS_ENABLED])
                            ->select('id, url, title, text')
                            ->queryAll();
                        $_results = [];
                        foreach ($temp_results as $item) {
                            $_results[$item['id']] = $item;
                            $_results[$item['id']]['gtb'] = false;
                            $_results[$item['id']]['gtu'] = false;
                        }
                        foreach ($ids['1'] as $k => $id) {
                            if (isset($_results[$id])) {
                                $results[$k] = $_results[$id];
                            }
                        }
                        unset($temp_results, $_results);
                    }
                    if (isset($ids['2'])) {
                        $temp_results = Yii::app()->db->createCommand()
                            ->from('{{gtb_post}}')
                            ->where(['in', 'id', $ids['2']])
                            ->andWhere('status_id = :status_id', [':status_id' => GtbPost::STATUS_ENABLED])
                            ->select('id, url, title, text, language')
                            ->queryAll();
                        $_results = [];
                        foreach ($temp_results as $item) {
                            $_results[$item['id']] = $item;
                            $_results[$item['id']]['gtb'] = true;
                        }
                        foreach ($ids['2'] as $k => $id) {
                            if (isset($_results[$id])) {
                                $results[$k] = $_results[$id];
                            }
                        }
                        unset($temp_results, $_results);
                    }

                    if (isset($ids['3'])) {
                        $temp_results = Yii::app()->db->createCommand()
                            ->from('{{gtu_post}}')
                            ->where(['in', 'id', $ids['3']])
                            ->andWhere('status_id = :status_id', [':status_id' => GtuPost::STATUS_ENABLED])
                            ->select('id, url, title, text, language')
                            ->queryAll();
                        $_results = [];
                        foreach ($temp_results as $item) {
                            $_results[$item['id']] = $item;
                            $_results[$item['id']]['gtu'] = true;
                        }
                        foreach ($ids['3'] as $k => $id) {
                            if (isset($_results[$id])) {
                                $results[$k] = $_results[$id];
                            }
                        }
                        unset($temp_results, $_results);
                    }

                    unset($ids);
                    $results = array_replace($result['matches'], $results);
                }
            }

            $pagination = new CPagination($total);
            $pagination->pageSize = $search_limit;
        }

        $banner = Banner::getByPlace(Banner::PLACE_SEARCH_VERTICAL);

        $this->style = Style::getStyleByPageKey(Style::PAGE_KEY_ALL);

        $this->render('results', [
            'results' => $results,
            'term' => $term,
            'total' => $total,
            'pagination' => $pagination,
            'words' => $words,
            'banner' => $banner,
        ]);
    }
}
