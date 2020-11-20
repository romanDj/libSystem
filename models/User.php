<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

class User extends ActiveRecord implements IdentityInterface
{
    const SCENARIO_LOGIN = 'login';
    const SCENARIO_REGISTER = 'register';

    public function rules()
    {
        return [
            [['login', 'password', 'fio'], 'trim'],

            [['login', 'password'], 'required', 'on' => self::SCENARIO_LOGIN],
            [['login'], 'isReal', 'on' => self::SCENARIO_LOGIN],

            [['login', 'password', 'fio'], 'required', 'on' => self::SCENARIO_REGISTER],
            [['login'], 'unique', 'message' => 'Пользователь с таким логином уже есть в системе', 'on' => self::SCENARIO_REGISTER],
            [['fio'], 'string', 'max' => 100, 'on' => self::SCENARIO_REGISTER],

            [['login', 'password'], 'string', 'max' => 40],
        ];
    }

    public static function tableName()
    {
        return '{{user}}';
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'fio' => 'ФИО',
            'login' => 'Логин',
            'password' => 'Пароль'
        ];
    }

    public function fields()
    {
        return [
            "id",
            "fio",
            "login",
            "created_at",
            "updated_at"
        ];
    }

    public function isReal($attribute, $params)
    {
        $user = self::findOne(['login' => $this->login]);

        if (!$user || $user->password != $this->password)
            $this->addError('login', 'Неправильный логин или пароль');
    }

    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['access_token' => $token]);
    }

    public function getId()
    {
        return $this->id;
    }

    public function getAuthKey()
    {
        return $this->authKey;
    }

    public function validateAuthKey($authKey)
    {
        return $this->authKey === $authKey;
    }

    public function login()
    {
        if ($this->validate()) {
            $user = self::findOne(['login' => $this->login]);
            $user->access_token = Yii::$app->security->generateRandomString();
            $user->save(false);
            Yii::$app->response->statusText = 'Successful authorization';
            return [
                'status' => true,
                'token' => $user->access_token
            ];
        } else {
            Yii::$app->response->statusCode = 401;
            Yii::$app->response->statusText = 'Invalid authorization data';
            return [
                'status' => false,
                'errors' => $this->errors
            ];
        }
    }


    public function registration()
    {
        if ($this->validate()) {
            $this->save(false);
            Yii::$app->response->statusText = 'Successful registration';

            return [
                'status' => true
            ];
        } else {
            Yii::$app->response->statusCode = 401;
            Yii::$app->response->statusText = 'Invalid registration data';
            return [
                'status' => false,
                'errors' => $this->errors
            ];
        }
    }
}
