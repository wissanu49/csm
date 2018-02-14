<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use dosamigos\datepicker\DatePicker;
use dosamigos\datepicker\DateRangePicker;
use app\models\Products;
use app\models\Units;

p2m\sbAdmin\assets\SBAdmin2Asset::register($this);
p2m\assets\TimelineAsset::register($this);
p2m\assets\MorrisAsset::register($this);
/* @var $this yii\web\View */
/* @var $model app\models\Products */
/* @var $form yii\widgets\ActiveForm */

$now = date('Y-m-d');
?>



<div class="row">
    <div class="col-lg-4"></div>
    <div class="col-lg-4">
        <div class="row">
            <div class="col-lg-2"></div>
            <div class="col-lg-8">
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
                        'value' => $date,
                        'template' => '{addon}{input}',
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
                <div class="form-group" style="text-align: center;">
                    <?= Html::submitButton(' ค้นหา ', ['class' => 'btn btn-success fa fa-search']) ?>
                </div>
                <?php ActiveForm::end(); ?>
            </div>  
            <div class="col-lg-2"></div>

        </div>
    </div>

    <div class="col-lg-4"></div>
</div>
<div class="row">
    <div class="col-lg-3"></div>
    <div class="col-lg-6">
        <div style="text-align: center;">
            <h4>รายงานรายได้ประจำวันที่ <?= Yii::$app->formatter->asDate($date); ?></h4>
        </div>
        <div class="box">
            <!-- /.box-header -->
            <div class="box-body no-padding">
                <table class="table table-bordered">
                    <thead>
                    <td style="width: 15px;">#</td>
                    <td style="width: 15px;"><strong>วันที่</strong></td>
                    <td style="width: 40px;"><strong>รายการ</strong></td>
                    <td style="width: 15px;"><strong>จำนวน</strong></td>                    
                    <td style="width: 15px;"><strong>รายได้</strong></td>
                    </thead>
                    <?php
                    $i = 0;
                    $total = 0;
                    foreach ($dataProvider as $data) {

                        $total = $total + $data->price;
                        $product = Products::getProduct($data->products_id);
                        //$price = Products::getPrice($data->products_id);
                        $product_unit = Products::getUnitId($data->products_id);
                        $unit = Units::getUnitName($product_unit->units_id);
                        ?>
                        <tr>
                            <td><?= $i + 1 ?>.</td>
                            <td style="text-align: center;"><?= Yii::$app->formatter->asDate($data->date_withdraw); ?></td>
                            <td><?= $product->name ?></td>
                            <td style="text-align: center;"><?= $data->amount ?>&nbsp;<?= $unit->name; ?></td>                            
                            <td style="text-align: right;"><?= Yii::$app->formatter->asDecimal($data->price); ?></td>

                        </tr>
                        <?php
                        $i++;
                    }
                    ?>
                    <tr>
                        <td colspan="4"></td>
                        <td style="text-align: right;"><h5><?= Yii::$app->formatter->asDecimal($total); ?></h5></td>
                    </tr>
                </table>
            </div>

            <div style="text-align: center;">
                <?= Html::a(' พิมพ์ ', ['reports/printdaily', 'date' => $date], ['target' => '_blank', 'class' => 'btn btn-info fa fa-print']) ?>
            </div>
        </div>
    </div>
    <div class="col-lg-3"></div>
</div>



