<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%books_authors}}`.
 */
class m230214_071506_create_books_authors_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%books_authors}}', [
            'id' => $this->primaryKey() . ' AUTO_INCREMENT',
            'book_id' => $this->integer(),
            'author_id' => $this->integer()
        ]);
        $this->addForeignKey(
            'book_id',
            'books_authors',
            'book_id',
            'books',
            'id',
            'CASCADE');
        $this->addForeignKey(
            'author_id',
            'books_authors',
            'author_id',
            'authors',
            'id',
            'CASCADE');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%books_authors}}');
        $this->dropForeignKey(
            'book_id',
            'books'
        );
        $this->dropForeignKey(
            'author_id',
            'authors'
        );
    }
}
