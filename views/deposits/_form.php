<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Customers;
use kartik\select2\Select2;
use kartik\date\DatePicker;

p2m\sbAdmin\assets\SBAdmin2Asset::register($this);
p2m\assets\TimelineAsset::register($this);
p2m\assets\MorrisAsset::register($this);
/* @var $this yii\web\View */
/* @var $model app\models\Deposits */
/* @var $form yii\widgets\ActiveForm */

?>

    <?php $form = ActiveForm::begin(); ?>
<div class="row">
    <div class="col-lg-6">
         
    <?= $form->field($model, 'id')->textInput(['value' => $runningcode, 'readonly' => true]) ?>

   <?= $form->field($model, 'customers_id')->widget(Select2::classname(), [
    'data' => ArrayHelper::map(Customers::find()->all(),'id','fullname'),
    'language' => 'th',
    'options' => ['placeholder' => 'ค้นหาลูกค้า ...'],
    'pluginOptions' => [
        'allowClear' => true
    ],
]);?>
    <?php // Html::activeHiddenInput($model, 'customers_id') ?>
    
    <?= $form->field($model, 'deposit_date')->widget(DatePicker::classname(), [
	'name' => 'deposit_date', 
	'value' => date('Y-m-d'),
	'options' => ['placeholder' => 'วันที่ ...'],
	'pluginOptions' => [
		'format' => 'yyyy-mm-dd',
		'todayHighlight' => true
	]
]); ?>
    
    <?= $form->field($model, 'deposit_date')->textInput(['value'=>date('Y-m-d'), 'readonly'=>TRUE]) ?>

    <?= $form->field($model, 'users_id')->textInput() ?>

<?= $form->field($model, 'comment')->textInput(['maxlength' => true]) ?>
    </div>
</div>
    <div class="form-group">
<?= Html::submitButton(' บันทึก ', ['class' => 'btn btn-success fa fa-plus']) ?>
    </div>

<?php ActiveForm::end(); ?>

