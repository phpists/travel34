<?php


class CookieController extends FrontEndController
{
    public function actionSetCookie()
    {
        if (!Yii::app()->request->isPostRequest) {
            throw new CHttpException(400, 'Invalid request');
        }

        $cookies = Yii::app()->request->cookies;

        // Обов'язковий cookie
        $cookie = new CHttpCookie('cookies_performance', '1');
        $cookie->expire = time() + 3600 * 24 * 365;
        $cookies['cookies_performance'] = $cookie;

        // Аналітика
        if (isset($_POST['analytics'])) {
            $cookie = new CHttpCookie('cookies_analytics', '1');
            $cookie->expire = time() + 3600 * 24 * 365;
            $cookies['cookies_analytics'] = $cookie;
        }

        // Маркетинг
        if (isset($_POST['marketing'])) {
            $cookie = new CHttpCookie('cookies_marketing', '1');
            $cookie->expire = time() + 3600 * 24 * 365;
            $cookies['cookies_marketing'] = $cookie;
        }

        $cookie = new CHttpCookie('user_agree', '1');
        $cookie->expire = time() + 3600 * 24 * 365;
        $cookies['user_agree'] = $cookie;

        return $this->renderJSON([
            'status' => 'true',
        ]);
    }
}