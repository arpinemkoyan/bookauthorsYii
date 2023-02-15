<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "author".
 *
 * @property int $id
 * @property string|null $first_name
 * @property string|null $last_name
 *
 * @property BookAuthor[] $booksAuthors
 */
class Author extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%authors}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['first_name', 'last_name', 'nickname'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'first_name' => 'First Name',
            'last_name' => 'Last Name',
            'nickname' => 'Nickname'
        ];
    }

    /**
     * Gets query for [[BookAuthor]].
     *
     * @return \yii\db\ActiveQuery
     */
//    public function getBooks()
//    {
//        return $this->hasMany(Book::class, ['id' => 'book_id'])
//            ->via('booksAuthors');
//    }
    public function getBookAuthors()
    {
        return $this->hasMany(BookAuthor::class, ['author_id' => 'id']);
    }

    public function getBooks()
    {
        return $this->hasMany(Book::class, ['id' => 'book_id'])
            ->via('bookAuthors');
    }
}
