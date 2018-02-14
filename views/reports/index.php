<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\grid\GridView;
use dosamigos\datepicker\DatePicker;
use dosamigos\datepicker\DateRangePicker;

p2m\sbAdmin\assets\SBAdmin2Asset::register($this);
p2m\assets\TimelineAsset::register($this);
p2m\assets\MorrisAsset::register($this);
/* @var $this yii\web\View */
/* @var $model app\models\Products */
/* @var $form yii\widgets\ActiveForm */

$now = date('Y-m-d');
$this->title = Yii::$app->name;
?>

<div class="row">
    <div class="col-lg-2"></div>
    <div class="col-lg-4">
        <?php
        $form = ActiveForm::begin([
                    'id' => 'daily-reports',
                    'action' => \yii\helpers\Url::to(['reports/daily'])
        ]);
        ?>
        <?= Html::hiddenInput('dailyreport', TRUE); ?>
        <div class="form-group">
            <label>รายงานรายได้ประจำวัน</label>
            <?=
            DatePicker::widget([
                'name' => 'date',
                'value' => '',
                'template' => '{addon}{input}',
                'language' => 'th',
                'clientOptions' => [
                    'autoclose' => true,
                    'format' => 'yyyy-mm-dd'
                ],
                'options' => [
                    'class' => "form-group input-group",
                ]
            ]);
            ?>
        </div> 
        <div class="form-group">
            <?= Html::submitButton(' ค้นหา ', ['class' => 'btn btn-success fa fa-search']) ?>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
    <?php
    $form = ActiveForm::begin([
                'id' => 'monthly-reports',
                'action' => \yii\helpers\Url::to(['reports/monthly'])
    ]);
    ?>
    <div class="col-lg-4">    
        <?= Html::hiddenInput('monthlyreport', TRUE); ?>
        <div class="form-group">
            <label>รายงานรายได้ระบุช่วงเวลา</label>
            <?=
            DateRangePicker::widget([
                'name' => 'date_from',
                'value' => '',
                'nameTo' => 'date_to',
                'valueTo' => '',
                'language' => 'th',
                'clientOptions' => [
                    'autoclose' => true,
                    'format' => 'yyyy-mm-dd'
                ],
                'options' => [
                    'class' => "form-group",
                ]
            ]);
            ?>
        </div>
        <div class="form-group">
            <?= Html::submitButton(' ค้นหา ', ['class' => 'btn btn-success fa fa-search']) ?>
        </div>
    </div>
    <?php ActiveForm::end(); ?>
 <div class="col-lg-2"></div>
</div>
<div class="row">
    <div class="col-lg-12">
        <?php 
        if ($mode == 'daily') { 
            
            ?>

            <?=
            GridView::widget([
                'dataProvider' => $dataProvider,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    'withdraw_id',
                    'deposits_id',
                    'date_withdraw:date',
                    [
                        'attribute' => 'users_id',
                        'filter' => ArrayHelper::map(app\models\Users::find()->all(), 'id', 'fullname'), //กำหนด filter แบบ dropDownlist จากข้อมูล ใน field แบบ foreignKey
                        'value' => function($model) {
                            return $model->users->fullname;
                        }
                    ],
                ],
            ]);
            ?>

        <?php } ?>
    </div>
</div>



