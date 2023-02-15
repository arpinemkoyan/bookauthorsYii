<?php

use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Book $model */
/** @var app\models\Author $authors */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="books-form">
    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'authorIds')->widget(Select2::class, [
        'name' => 'authors[]',
        'data' => ArrayHelper::map($authors, 'id', 'nickname'),
        'language' => 'en',
        'options' => [
            'multiple' => true, 'placeholder' => 'Select auhors ...',
            'value' => ArrayHelper::map($model->authors, 'id', 'id'),
        ],
        'pluginOptions' => [
            'allowClear' => true,
        ],
    ])
    ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
