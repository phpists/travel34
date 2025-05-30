<?php


class LoginController extends FrontEndController
{
    public function actionLogin()
    {
        if (Yii::app()->userComponent->isAuthenticated()) {
            $this->redirect('/');
            return;
        }

        if (Yii::app()->request->isPostRequest) {
            $email = $_POST['email'];
            $password = $_POST['password'];

            $loginResult = Yii::app()->userComponent->login($email, $password);

            if ($loginResult['status']) {
                $returnUrl = SubscriptionComponent::getSubscriptionCookieValue('post_url');

                if (isset($returnUrl)) {
                    SubscriptionComponent::updateSubscriptionCookie('post_url', null);
                } else {
                    $returnUrl = Yii::app()->user->returnUrl ? Yii::app()->user->returnUrl : '/';
                }

                $this->redirect($returnUrl);
                return;
            } else {
                Yii::app()->user->setFlash($loginResult['input'], $loginResult['message']);
            }
        }

        $this->render('login');
    }



    public function actionLoginWithGoogle()
    {
        $clientId = Yii::app()->params['google']['clientId'];
        $redirectUri = urlencode(Yii::app()->createAbsoluteUrl('login/oauth2callback'));
        $scope = urlencode('email');
        $state = Yii::app()->request->getCsrfToken();

        $authUrl = "https://accounts.google.com/o/oauth2/auth?response_type=code&client_id={$clientId}&redirect_uri={$redirectUri}&scope={$scope}&state={$state}";

        $this->redirect($authUrl);
    }

    public function actionLoginWithGoogleSubscription()
    {
        $clientId = Yii::app()->params['google']['clientId'];
        $redirectUri = urlencode(Yii::app()->createAbsoluteUrl('login/oauth2callbackSubscription'));
        $scope = urlencode('email');
        $state = Yii::app()->request->getCsrfToken();

        $authUrl = "https://accounts.google.com/o/oauth2/auth?response_type=code&client_id={$clientId}&redirect_uri={$redirectUri}&scope={$scope}&state={$state}";

        $this->redirect($authUrl);
    }

    public function actionLoginWithGoogleSubscriptionF2()
    {
        $clientId = Yii::app()->params['google']['clientId'];
        $redirectUri = urlencode(Yii::app()->createAbsoluteUrl('login/oauth2callbackSubscriptionF2'));
        $scope = urlencode('email');
        $state = Yii::app()->request->getCsrfToken();

        $authUrl = "https://accounts.google.com/o/oauth2/auth?response_type=code&client_id={$clientId}&redirect_uri={$redirectUri}&scope={$scope}&state={$state}";

        $this->redirect($authUrl);
    }

    public function actionOauth2callback()
    {
        $returnUrl = SubscriptionComponent::getSubscriptionCookieValue('post_url');

        if (isset($returnUrl)){
            SubscriptionComponent::updateSubscriptionCookie('post_url', null);
        } else {
            $returnUrl = '/';
        }

        $this->socialLogin($returnUrl);
    }

    public function actionOauth2callbackSubscription()
    {
        $this->socialLogin('/subscription/f1/step-three');
    }

    public function actionOauth2callbackSubscriptionF2()
    {
        $this->socialLogin('/subscription/f2/step-three');
    }

    public function socialLogin($redirectAfterLogin = '/')
    {
        if (isset($_GET['code'])) {
            $code = $_GET['code'];
            $clientId = Yii::app()->params['google']['clientId'];
            $clientSecret = Yii::app()->params['google']['clientSecret'];

            $action = Yii::app()->controller->action->id;
            $redirectUri = Yii::app()->createAbsoluteUrl("login/{$action}");

            $tokenUrl = "https://oauth2.googleapis.com/token";
            $postData = [
                'code' => $code,
                'client_id' => $clientId,
                'client_secret' => $clientSecret,
                'redirect_uri' => $redirectUri,
                'grant_type' => 'authorization_code',
            ];

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $tokenUrl);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postData));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/x-www-form-urlencoded']);

            $response = curl_exec($ch);
            curl_close($ch);

            $tokenData = json_decode($response, true);

            if (isset($tokenData['access_token'])) {
                $accessToken = $tokenData['access_token'];
                $userInfoUrl = "https://www.googleapis.com/oauth2/v1/userinfo?access_token={$accessToken}";

                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $userInfoUrl);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

                $userInfoResponse = curl_exec($ch);
                curl_close($ch);

                $userInfo = json_decode($userInfoResponse, true);

                $user = User::model()->findByAttributes(['email' => $userInfo['email']]);
                if ($user === null) {
                    $user = new User();
                    $user->email = $userInfo['email'];
                    $user->username = 'Unknown';
                    $user->password = $user->hashPassword(123);
                    $user->last_login_time = date('Y-m-d H:i:s');
                    $user->role = User::ROLE_USER;
                    $user->is_verification = User::VERIFICATION;
                    $user->is_social = User::SOCIAL;
                    $user->save();

                    $redirectAfterLogin = $this->createUrl('/login/register-finish');
                }

                Yii::app()->session['user_id'] = $user->id;
                Yii::app()->session['user_email'] = $user->email;
                Yii::app()->session->remove('email');

                $this->redirect($redirectAfterLogin);
            } else {
                throw new CHttpException(400, 'Invalid request.');
            }
        } else {
            $this->redirect(Yii::app()->homeUrl);
        }
    }

    public function actionLogout()
    {
        Yii::app()->userComponent->logout();
        $this->redirect(Yii::app()->homeUrl);
    }

    public function actionIHaveAccount()
    {
        $postUrl = Yii::app()->request->getUrlReferrer();
        SubscriptionComponent::updateSubscriptionCookie('post_url', $postUrl);

        $this->redirect('/login');
    }

    public function actionRegisterFinish()
    {
        $this->render('register_finish');
    }
}