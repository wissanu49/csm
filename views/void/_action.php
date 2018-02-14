<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Void */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="void-form">

    <?php $form = ActiveForm::begin(); ?>

     <?= $form->field($model, 'id')->hiddenInput()->label(false) ?>
    
    <?= $form->field($model, 'type')->dropDownList(['dep' => 'ใบฝากสินค้า', 'rec' => 'ใบเสร็จรับเงิน/เบิกสินค้า' ], ['prompt' => 'ประเภทรายการ', 'disabled'=>true]) ?>

    <?= $form->field($model, 'void_id')->textInput(['maxlength' => true, 'readonly'=>'readonly']) ?>

    <?= $form->field($model, 'status')->dropDownList(['approve' => 'อนุมัติ', 'reject' => 'ยกเลิก', ], ['prompt' => '']) ?>

    <?php // $form->field($model, 'date_request')->textInput() ?>

    <?php // $form->field($model, 'date_action')->textInput() ?>

    <?= $form->field($model, 'comment')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?php if($model->status == "request"){ ?>
        <?= Html::submitButton(' บันทึก ', ['class' => 'btn btn-success fa fa-save']) ?>
        <?php } ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
