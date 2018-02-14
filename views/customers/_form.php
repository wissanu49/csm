<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
/* @var $this yii\web\View */
/* @var $model app\models\Customers */
/* @var $form yii\widgets\ActiveForm */
?>


    
    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="col-lg-6">
             <?= $form->field($model, 'fullname')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'address')->textarea(['rows' => 6]) ?>
            <?= $form->field($model, 'phone')->textInput(['maxlength' => true]) ?>
        </div>
        
    </div>    
    <div class="form-group">
            <?= Html::submitButton('  บันทึก ', ['class' => 'btn btn-success fa fa-save']) ?>
        </div>
    <?php ActiveForm::end(); ?>


