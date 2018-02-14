<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

p2m\sbAdmin\assets\SBAdmin2Asset::register($this);
p2m\assets\TimelineAsset::register($this);
p2m\assets\MorrisAsset::register($this);

/* @var $this yii\web\View */
/* @var $model app\models\Units */
/* @var $form yii\widgets\ActiveForm */
?>


<?php $form = ActiveForm::begin(); ?>
<div class="row">
    <div class="col-lg-6">

        <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
    </div>
</div>

<div class="form-group">
    <?= Html::submitButton('  บันทึก ', ['class' => 'btn btn-success fa fa-save']) ?>
</div>

<?php ActiveForm::end(); ?>

