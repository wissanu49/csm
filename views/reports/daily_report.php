<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use dosamigos\datepicker\DatePicker;
use dosamigos\datepicker\DateRangePicker;

p2m\sbAdmin\assets\SBAdmin2Asset::register($this);
p2m\assets\TimelineAsset::register($this);
p2m\assets\MorrisAsset::register($this);
/* @var $this yii\web\View */
/* @var $model app\models\Products */
/* @var $form yii\widgets\ActiveForm */

$now = date('Y-m-d');
?>


<?php
$form = ActiveForm::begin([
            'id' => 'daily-reports',
            'action' => \yii\helpers\Url::to(['reports/'])
        ]);
?>
<div class="row">
    <div class="col-lg-4"></div>
    <div class="col-lg-4">
        <div class="form-group">
            <label>รายงานรายได้ประจำวัน</label>
            <?=
            DatePicker::widget([
                'name' => 'date',
                'value' => $now,
                'template' => '{addon}{input}',
                'language' => 'th',
                'clientOptions' => [
                    'autoclose' => true,
                    'format' => 'yyyy-mm-dd'
                ],
                'options' => [
                    'class'=>"form-group input-group",
                ]
            ]);
            ?>
        </div> 
        <div class="form-group">
            <?= Html::submitButton(' ค้นหา ', ['class' => 'btn btn-success fa fa-search']) ?>
        </div>

    </div>
    <div class="col-lg-4"></div>
</div>

<?php ActiveForm::end(); ?>
