<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\BookAuthor $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="books-authors-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'book_id')->textInput() ?>

    <?= $form->field($model, 'author_id')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
