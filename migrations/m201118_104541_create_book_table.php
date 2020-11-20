<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%book}}`.
 */
class m201118_104541_create_book_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%book}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string(250),
            'description' => $this->text(),
            'created_at' => $this->dateTime()->notNull()->defaultExpression('NOW()'),
            'updated_at' => $this->dateTime()->defaultExpression('NOW()')->append('ON UPDATE NOW()'),
            'author_id' => $this->integer()->null()
        ]);


    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%book}}');
    }
}
