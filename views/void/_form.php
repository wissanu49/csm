<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Void */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="void-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'type')->dropDownList([ 'dep' => 'ใบฝากสินค้า', 'rec' => 'ใบเสร็จรับเงิน/เบิกสินค้า', ], ['prompt' => 'ประเภทรายการ']) ?>

    <?= $form->field($model, 'void_id')->textInput(['maxlength' => true]) ?>

    <?php // $form->field($model, 'status')->dropDownList([ 'request' => 'Request', 'approve' => 'Approve', 'reject' => 'Reject', ], ['prompt' => '']) ?>

    <?php // $form->field($model, 'date_request')->textInput() ?>

    <?php // $form->field($model, 'date_action')->textInput() ?>

    <?= $form->field($model, 'comment')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton(' บันทึก ', ['class' => 'btn btn-success fa fa-save']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
