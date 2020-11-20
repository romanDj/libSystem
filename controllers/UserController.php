<?php

namespace app\controllers;

use app\models\User;
use Yii;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\Cors;
use yii\rest\ActiveController;
use yii\rest\Controller;

class UserController extends ActiveController
{
    public $modelClass = 'app\models\User';
    public $enableCsrfValidation = false;


    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['corsFilter'] = [
            'class' => Cors::className(),
            'cors' => [
                'Origin' => ['*'],
                'Access-Control-Request-Method' => ['GET', 'OPTIONS', 'PATCH', 'POST', 'PUT', 'DELETE'],
                'Access-Control-Request-Headers' => ['Authorization', 'Content-Type'],
                'Access-Control-Max-Age' => 3600
            ]
        ];
        $behaviors['authenticator'] = [
            'class' => HttpBearerAuth::className(),
            'only' => ['profile', 'profile-delete']
        ];
        return $behaviors;
    }

    public function actions()
    {
        $actions = parent::actions();

        unset($actions['index']);
        unset($actions['view']);
        unset($actions['create']);
        unset($actions['update']);
        unset($actions['delete']);

        return $actions;
    }


    public function actionLogin()
    {
        $user = new User();
        $user->load(Yii::$app->request->post(), '');
        $user->scenario = User::SCENARIO_LOGIN;
        return $user->login();
    }

    public function actionRegister()
    {
        $user = new User();
        $user->load(Yii::$app->request->post(), '');
        $user->scenario = User::SCENARIO_REGISTER;
        return $user->registration();
    }

    public function actionProfile()
    {
        return Yii::$app->user->identity;
    }

    public function actionProfileDelete()
    {
        return ['message' => 'удаление профиля'];
    }

}
