<?php
namespace app\modules\foo\controllers;

use yii\web\Response;

class DefaultController extends \yii\rest\Controller
{
    public $layout = false;
    public $enableCsrfValidation = false;

    public function actionIndex()
    {
        //\Yii::$app->response->format = Response::FORMAT_HTML;
        //return $this->render('index');
        return [
            'message' => 'hi'
        ];
    }

    public function actionView(){
        \Yii::$app->response->format = Response::FORMAT_JSON;
        return [
            'message' => 'hi'
        ];
    }
}
