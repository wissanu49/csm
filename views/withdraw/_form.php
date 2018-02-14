<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

p2m\sbAdmin\assets\SBAdmin2Asset::register($this);
p2m\assets\TimelineAsset::register($this);
p2m\assets\MorrisAsset::register($this);
/* @var $this yii\web\View */
/* @var $model app\models\Withdraw */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="withdraw-form">

    <?php $form = ActiveForm::begin([
        'options' => [
                    'id' => 'withdraw',
                ]
    ]); ?>
    
    <?= $form->field($model, 'id')->hiddenInput()->label(FALSE) ?>

    
    
    <?= $form->field($model, 'date_withdraw')->textInput(['value' => date('Y-m-d'), 'readonly'=>true]) ?>

    <?= $form->field($model, 'deposits_id')->hiddenInput(['value' => $id])->label(FALSE) ?>
    <?php // $form->field($model, 'products_id')->hiddenInput(['value' => $id])->label(FALSE) ?>
    
    <?= $form->field($model, 'products_id')->dropDownList(ArrayHelper::map(app\models\Products::find()->all(), 'id','name'),  ['disabled'=>true]) ?>
    
    <?= $form->field($model, 'amount')->textInput(['value' => $amount->amount]) ?>

    <?= $form->field($model, 'users_id')->hiddenInput(['value' => Yii::$app->user->identity->id])->label(FALSE) ?>

    <div class="form-group">
        <?= Html::submitButton(' เพิ่ม ', ['class' => 'btn btn-success fa fa-plus']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
