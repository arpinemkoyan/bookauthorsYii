<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\BooksAuthors $model */

$this->title = 'Update Books Authors: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Books Authors', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="books-authors-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
