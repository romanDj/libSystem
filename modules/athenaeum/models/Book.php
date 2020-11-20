<?php

namespace app\modules\athenaeum\models;

use Yii;
use yii\db\ActiveRecord;

class Book extends ActiveRecord
{
    public static function tableName()
    {
        return '{{book}}';
    }

    public function rules()
    {
        return [
            [['title', 'description'], 'required'],
            [['title', 'description'], 'trim'],
            ['author_id', 'integer'],
            ['author_id', 'isExist']
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Название',
            'description' => 'Описание',
        ];
    }

    public function isExist($attribute, $params)
    {
        $author = Author::findOne(['id' => $this->author_id]);

        if (!$author)
            $this->addError('author', 'Неверный id автора');
    }

    public function fields()
    {
        return [
            'id',
            'title',
            'description',
            'author_id',
            'created_at',
            'updated_at'
        ];
    }

    public function extraFields()
    {
        return [
            'author'=> function () {
                return $this->author;
            }
        ];
    }

    public function getAuthor(){
        return $this->hasOne(Author::className(), ['id' => 'author_id']);
    }
}