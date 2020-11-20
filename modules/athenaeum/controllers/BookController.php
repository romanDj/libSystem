<?php

namespace app\modules\athenaeum\controllers;

use yii\web\Response;

class BookController extends \yii\rest\ActiveController
{
    public $modelClass = 'app\modules\athenaeum\models\Book';
}
