<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

p2m\sbAdmin\assets\SBAdmin2Asset::register($this);
p2m\assets\TimelineAsset::register($this);
p2m\assets\MorrisAsset::register($this);
/* @var $this yii\web\View */
/* @var $model app\models\Products */
/* @var $form yii\widgets\ActiveForm */
//$model = new \app\models\Products();
?>


<?php $form = ActiveForm::begin(); ?>
<div class="row">
    <div class="col-lg-12">
        <div class="row">
            <div class="col-lg-4">
                <?= $form->field($model, 'name')->textInput(['placeholder'=>'ชื่อสินค้า'])->label(false) ?>
            </div>
            <div class="col-lg-3">      
                <?= $form->field($model, 'price')->textInput(['placeholder'=>'ราคาต่อเดือน'])->label(false) ?>
            </div>
            <div class="col-lg-3">
                <?= $form->field($model, 'units_id')->dropDownList(ArrayHelper::map(app\models\Units::find()->all(), 'id', 'name'), ['prompt' => '-หน่วย-'])->label(false) ?>
            </div>
            <div class="col-lg-2">
                 <div class="form-group">
        <?= Html::submitButton(' บันทึก ', ['class' => 'btn btn-success btn-lg fa fa-save']) ?>
    </div>
            </div>
        </div>
        
    </div>
   
</div>
    <?php ActiveForm::end(); ?>
