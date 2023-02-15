<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\BooksAuthors $model */

$this->title = 'Create Books Authors';
$this->params['breadcrumbs'][] = ['label' => 'Books Authors', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="books-authors-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>