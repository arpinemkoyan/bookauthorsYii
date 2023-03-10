<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Book $model */
/** @var app\models\Author $authors */

$this->title = 'Update Book: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Book', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="books-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'authors' => $authors
    ]) ?>

</div>
