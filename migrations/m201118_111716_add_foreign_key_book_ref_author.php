<?php

use yii\db\Migration;

/**
 * Class m201118_111716_add_foreign_key_book_ref_author
 */
class m201118_111716_add_foreign_key_book_ref_author extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createIndex(
            'idx-book-author',
            'book',
            'author_id');
        $this->addForeignKey(
            'fx-author',
            'book',
            'author_id',
            'author',
            'id',
            'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fx-author','book');
        $this->dropIndex('idx-book-author', 'book');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m201118_111716_add_foreign_key_book_ref_author cannot be reverted.\n";

        return false;
    }
    */
}
