<?php

namespace app\modules\athenaeum\models;

use Yii;
use yii\db\ActiveRecord;

class Author extends ActiveRecord
{
    public static function tableName()
    {
        return '{{author}}';
    }

    public function rules()
    {
        return [
            [['fio', 'description'], 'required'],
            [['fio', 'description'], 'trim'],
            [['fio'], 'string', 'max' => 100],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'fio' => 'ФИО',
            'description' => 'Описание',
        ];
    }

    public function fields()
    {
        return [
            'id',
            'fio',
            'description',
        ];
    }

    public function extraFields()
    {
        return [
            'books' => function(){
                return $this->books;
            }
        ];
    }

    public function getBooks(){
        return $this->hasMany(Book::className(), ['author_id' => 'id']);
    }
}