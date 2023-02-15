<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\BookAuthor $model */

$this->title = 'Create Book Author';
$this->params['breadcrumbs'][] = ['label' => 'Book Author', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="books-authors-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
