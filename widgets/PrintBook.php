<?php

namespace app\widgets;

use app\models\Book;
use app\models\BookAuthorSearch;
use Yii;
use yii\grid\GridView;


class PrintBook extends \yii\bootstrap5\Widget
{
    public $model;


    public function run()
    {
        $dataProvider = BookAuthorSearch::getDataprovider($this->model->id);

        return GridView::widget([
            'dataProvider' => $dataProvider,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                [
                    'attribute' => 'book',
                    'class' => 'yii\grid\DataColumn',
                    'value' => function ($data) {
                        return Book::findOne($data->book_id)->name;
                    },
                ],
            ]
        ]);

    }
}
