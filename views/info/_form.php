<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
p2m\sbAdmin\assets\SBAdmin2Asset::register($this);
p2m\assets\TimelineAsset::register($this);
p2m\assets\MorrisAsset::register($this);

/* @var $this yii\web\View */
/* @var $model app\models\Info */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="info-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'company_name')->textInput(['maxlength' => true, 'placeholder'=>'ชื่อบริษัท']) ?>

    <?= $form->field($model, 'address')->textarea(['rows' => 6, 'placeholder'=>'ที่อยู่']) ?>

    <?= $form->field($model, 'phone')->textInput(['maxlength' => true, 'placeholder'=>'เบอร์ติดต่อ']) ?>

    <?php //$form->field($model, 'logo')->fileInput() ?>

    <div class="form-group">
        <?= Html::submitButton(' บันทึก ', ['class' => 'btn btn-success fa fa-save']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
