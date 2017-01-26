<?php

namespace api\modules\v1\controllers;

use api\config\ApiCode;
use api\forms\LoginForm;
use api\forms\RegisterUserForm;
use common\exceptions\BetterHttpException;
use common\models\User;
use yii\base\InvalidConfigException;
use yii\rest\Controller;
use yii\web\HttpException;

/**
 * Class AuthController
 * @package api\modules\v1\controllers
 * @author Haqqi <me@haqqi.net>
 */
class AuthController extends Controller
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['authenticator']['except'] = [
          'login',
          'forgot-password',
          'reset-password',
          'register'
        ];

        return $behaviors;
    }

    protected function verbs()
    {
        return [
          'login'           => ['post'],
          'logout'          => ['post'],
          'forgot-password' => ['post'],
          'reset-password'  => ['get', 'post'],
          'register'        => ['post'],
          'change-password' => ['post']
        ];
    }

    public function actionRegister()
    {
        try {
            // registration primary form. no need to login!!
            $userForm = new RegisterUserForm(\Yii::$app->request->headers->get('X-Device-identifier'));
        } catch (InvalidConfigException $e) {
            throw new HttpException(400, $e->getMessage(), ApiCode::DEVICE_IDENTIFIER_NOT_FOUND);
        }

        $userForm->load(\Yii::$app->request->post(), 'User');

        if ($userForm->validate()) {

            $user = $userForm->register();

            return [
              'name'    => 'Success',
              'message' => 'Registration as User of ' . $user->username . ' success.',
              'code'    => ApiCode::REGISTER_SUCCESS,
              'status'  => 200,
              'data'    => $user->toArray([
                'username',
                'email',
              ])
            ];
        }

        throw new BetterHttpException(400, 'Registration failed.', [
          'User' => $userForm->getErrors()
        ], ApiCode::REGISTER_FAILED);
    }

    public function actionLogin()
    {
        try {
            $loginForm = new LoginForm(\Yii::$app->request->headers->get('X-Device-identifier'));
        } catch (InvalidConfigException $e) {
            throw new HttpException(400, $e->getMessage(), ApiCode::DEVICE_IDENTIFIER_NOT_FOUND);
        }

        $loginWithEmail = true;

        if ($loginWithEmail) {
            $loginForm->setScenario(LoginForm::SCENARIO_SUBMIT_LOGIN_EMAIL);
        } else {
            $loginForm->setScenario(LoginForm::SCENARIO_SUBMIT_LOGIN_USERNAME);
        }

        $loginForm->load(\Yii::$app->request->post(), 'User');
        /*
             * Try to login
             */
        if ($loginForm->login()) {
            /**
             * @var $user User
             */
            $user = \Yii::$app->user->getIdentity();

            return [
              'name'    => 'Success',
              'message' => 'Login with email ' . $user->email . ' success',
              'code'    => ApiCode::LOGIN_SUCCESS,
              'status'  => 200,
              'data'    => $user->toArray([
                  // main fields
                  'hashId',
                  'username',
                  'email'
              ], [
                  // extra fields
                  'activeDevice'
              ])
            ];
        } else {
            throw new BetterHttpException(401, 'Login Failed', ['User' => $loginForm->getErrors()],
              ApiCode::LOGIN_FAILED);
        }

    }

    public function actionForgotPassword()
    {
        return [];
    }

    /**
     * @param $resetPasswordToken
     *
     * This method accept GET and POST method. If it is GET, this
     * will return the status of token, wheter it is true or false.
     *
     * @return array
     */
    public function actionResetPassword($resetPasswordToken)
    {
        return [];
    }

    public function actionChangePassword()
    {
        return [];
    }

    public function actionLogout()
    {
        return [];
    }
}