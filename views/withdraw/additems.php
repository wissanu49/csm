<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

p2m\sbAdmin\assets\SBAdmin2Asset::register($this);
p2m\assets\TimelineAsset::register($this);
p2m\assets\MorrisAsset::register($this);
/* @var $this yii\web\View */
/* @var $model app\models\Withdraw */
/* @var $form yii\widgets\ActiveForm */

$range = range(1, $balance);
?>

  <?php $form = ActiveForm::begin([
      'action' => Url::to(['withdraw/addcarts']),
        'options' => [
                    'id' => 'carts',
                ]
    ]); ?>
    <?= Html::hiddenInput('deposits_id', $depid, ['class'=>'form-control']); ?> 
    <?= Html::hiddenInput('products_id', $proid, ['class'=>'form-control']); ?> 
    <label>สินค้า</label>    
    <?= Html::textInput('proname', $proname, ['class'=>'form-control', 'readonly' => true]); ?> 
    <br>
    <label>จำนวน</label>
    <?php // Html::textInput('amount', $balance, ['class'=>'form-control']); ?> 
    <?= Html::dropDownList('amount', $balance , array_combine($range, $range),['class'=>'form-control']) ?>
    <br>
    
        <?= Html::submitButton(' เพิ่ม ', ['class' => 'btn btn-success fa fa-plus']) ?>

<?php ActiveForm::end(); ?>

