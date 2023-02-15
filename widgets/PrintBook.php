<?php

namespace app\widgets;

use Yii;
use yii\data\ArrayDataProvider;
use yii\grid\GridView;


class PrintBook extends \yii\bootstrap5\Widget
{
    public $model;


    public function run()
    {
        $dataProvider = new ArrayDataProvider([
                'allModels' => $this->model->books
        ]);

        return GridView::widget([
            'dataProvider' => $dataProvider,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

                'name',
            ]
        ]);

    }
}
