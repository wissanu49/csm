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
$this->title = Yii::$app->name;
?>


<div class="row">
    <div class="col-lg-3"></div>
    <div class="col-lg-6">
        <div style="text-align: center;">
            <h4>รายงานรายได้ระหว่างวันที่ <?= Yii::$app->formatter->asDate($date_from); ?> ถึงวันที่ <?= Yii::$app->formatter->asDate($date_to); ?></h4>
        </div>
        <br>
        <div class="box">
            <!-- /.box-header -->
            <div class="box-body no-padding">
                <table class="table table-bordered">
                    <tr>
                    <td style="width: 10px;text-align: center;">#</td>
                    <td style="width: 10px;text-align: center;"><strong>วันที่</strong></td>
                    <td style="width: 50px;text-align: center;"><strong>รายการ</strong></td>
                    <td style="width: 10px;text-align: center;"><strong>จำนวน</strong></td> 
                    <td style="width: 10px;text-align: center;"><strong>หน่วย</strong></td>
                    <td style="width: 10px;text-align: center;"><strong>รายได้</strong></td>
                    </tr>
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
                            <td>&nbsp;<?= $product->name ?></td>
                            <td style="text-align: center;"><?= $data->amount ?></td> 
                            <td style="text-align: center;"><?= $unit->name; ?></td>   
                            <td style="text-align: right;"><?= Yii::$app->formatter->asDecimal($data->price); ?></td>

                        </tr>
                        <?php
                        $i++;
                    }
                    ?>
                    <tr>
                        <td colspan="4"></td>
                        <td style="text-align: right;"><strong>รวม</strong></td>
                        <td style="text-align: right;"><h5><strong><?= Yii::$app->formatter->asDecimal($total); ?></strong></h5></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    <div class="col-lg-3"></div>
</div>



