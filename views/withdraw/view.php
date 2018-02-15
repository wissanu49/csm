<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\models\Numbertostring;
use app\models\Products;
use app\models\Units;
use app\models\Withdraw;

p2m\sbAdmin\assets\SBAdmin2Asset::register($this);
p2m\assets\TimelineAsset::register($this);
p2m\assets\MorrisAsset::register($this);
/* @var $this yii\web\View */
/* @var $model app\models\Withdraw */

$this->title = 'รายการเบิกเลขที่ : ' . $model->withdraw_id;
$this->params['breadcrumbs'][] = ['label' => 'รายการเบิก', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$NumToString = new Numbertostring();
?>
<div class="row">
    <div class="col-md-1"></div>
    <div class="col-md-10"> 

        <table class="table table-striped table-bordered">
            <tr style="text-align: center;">
                <td style="width: 5%"><strong>#</strong></td>
                <td style="width: 35%"><strong>รายการ</strong></td>
                <td style="width: 10%"><strong>จำนวน</strong></td>
                <td style="width: 15%"><strong>ราคา/หน่วย/เดือน</strong></td>
                <td style="width: 15%"><strong>เวลาฝาก</strong></td>
                <td style="width: 10%"><strong>รวม (บาท)</strong></td>
            </tr>
            <?php
            $i = 1;
            $total = 0;
            foreach ($dataProvider as $data) {
                $depid = $data->deposits_id;
                $id = $data->withdraw_id;
                $status = $data->void;
                $product = Products::getProduct($data->products_id);
                $price = Products::getPrice($data->products_id);
                $dep = app\models\Deposits::find()->select('deposit_date')->where(['id' => $data->deposits_id])->one();
                //var_dump($dep);
                $time = new Withdraw();
                $TimeTotal = $time->CheckDate($dep->deposit_date, $data->date_withdraw);
                $total += $data->price;
                ?>
                <tr>
                    <td style="text-align: center;"><?= $i ?></td>
                    <td>&nbsp<?= $product->name ?></td>
                    <td style="text-align: center;"><?= $data->amount ?></td>
                    <td style="text-align: center;"><?= $price->price ?></td>
                    <td style="text-align: center;"><?= $TimeTotal ?> เดือน</td>
                    <td style="text-align: center;"><?= $data->price ?></td>
                </tr>
            <?php } ?>
            <tr style="text-align: center; vertical-align: middle;">
                <td colspan="4" >
                    <h5><strong><?= $NumToString->Convert($total) ?></strong></h5>
                </td>
                <td><strong>ราคารวม</strong></td>
                <td >
                    <strong><?= $total ?></strong>
                </td>
            </tr>
        </table>

        <div style="text-align: center;">
            <?= Html::a(' ย้อนกลับ ', Yii::$app->request->referrer, ['class' => 'btn btn-warning fa fa-arrow-left']) ?>
            <?php
            if (Yii::$app->user->identity->role == "Admin") {
                if ($status == 'false') {
                    ?>
                    &nbsp;
                    <?= Html::a(' พิมพ์ Slip ', ['withdraw/printpdf', 'id' => $id, 'depid' => $depid], ['target' => '_blank', 'class' => 'btn btn-info fa fa-print']) ?>
                    &nbsp;
                    <?= Html::a(' พิมพ์ A4 ', ['withdraw/printpdfa4', 'id' => $id, 'depid' => $depid], ['target' => '_blank', 'class' => 'btn btn-info fa fa-print']) ?>
                    <?php
                }
            }
            ?>
        </div>
    </div>
    <div class="col-md-1"></div>
</div>