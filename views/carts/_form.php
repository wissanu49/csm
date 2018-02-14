<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use kartik\date\DatePicker;

p2m\sbAdmin\assets\SBAdmin2Asset::register($this);
p2m\assets\TimelineAsset::register($this);
p2m\assets\MorrisAsset::register($this);
/* @var $this yii\web\View */
/* @var $model app\models\Carts */
/* @var $form yii\widgets\ActiveForm */
?>


    <?php $form = ActiveForm::begin(); ?>

<div class="row">
    <div class="col-lg-6">

    <?= $form->field($model, 'id')->textInput() ?>

    <?= $form->field($model, 'amount')->textInput() ?>

    <?= $form->field($model, 'products_id')->textInput() ?>

    <?= $form->field($model, 'users_id')->textInput() ?>
    </div>
</div>
    <div class="form-group">
        <?= Html::submitButton(' บันทึก ', ['class' => 'btn btn-success fa fa-plus']) ?>
    </div>

    <?php ActiveForm::end(); ?>

