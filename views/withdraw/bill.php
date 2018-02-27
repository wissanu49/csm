<?php

use yii\helpers\Html;
use app\models\Numbertostring;
use app\models\Products;
use app\models\Units;
use app\models\Withdraw;

p2m\sbAdmin\assets\SBAdmin2Asset::register($this);
p2m\assets\TimelineAsset::register($this);
p2m\assets\MorrisAsset::register($this);
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$NumToString = new Numbertostring();
/*
  $infos = app\models\Info::find()->all();
  foreach ($infos as $info) {
  $company = $info->company_name;
  $address = $info->address;
  $phone = $info->phone;
  $logo = $info->logo;
  }
 * 
 */
?>

<div class="row">
    <div class="col-md-1"></div>
    <div class="col-md-10">   

        <div class="panel panel-default">
            <!-- /.panel-heading -->
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table">
                        <tr>
                            <td colspan="3" style="text-align: center;">
                                <h3><strong>LYMRR</strong></h3>
                            </td>
                        </tr>
                        <tr>
                            <td style="width: 60%">
                            </td>
                            <td>
                                <table style="width:100%">
                                    <tr>
                                        <td style="text-align: center;">
                                            <h5><strong>ใบเสร็จรับเงิน/เบิกสินค้า</strong></h5>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="text-align: center;">
                                            <h5><strong>เลขที่ <?= $billid ?></strong></h5>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <table style="width:100%">
                                    <?php
                                    foreach ($depModel as $dep) {
                                        $depid = $dep->id;
                                        ?>
                                        <tr>
                                            <td style="text-align: left; width: 60%;">
                                                <h5><strong>เลขที่ใบนำฝาก :</strong> <?= $dep->id ?> </h5>
                                                <h5><strong>ลูกค้า :</strong> <?= $dep->customers->fullname ?> </h5>
                                            </td>
                                            <td style="text-align: center;">
                                                <h5><strong>วันที่  <?= $dep->deposit_date ?></strong></h5>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <table class="table">
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
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" style="text-align: center;">
                                <div>
                                    <?= Html::a(' หน้าหลัก ', Yii::$app->homeUrl, ['class' => 'btn btn-warning fa fa-home']) ?>&nbsp;
                                    <?= Html::a(' พิมพ์ Slip', ['withdraw/printpdf', 'id' => $billid, 'depid' => $depid], ['target' => '_blank', 'class' => 'btn btn-danger fa fa-print']) ?>
                                    &nbsp;
                                    <?= Html::a(' พิมพ์ A4 ', ['withdraw/printpdfa4', 'id' => $billid, 'depid' => $depid], ['target' => '_blank', 'class' => 'btn btn-info fa fa-print']) ?>
                                    &nbsp;
                                    <?= Html::a(' พิมพ์ Dot Matrix', ['withdraw/printpdfdot', 'id' => $billid, 'depid' => $depid], ['target' => '_blank', 'class' => 'btn btn-success fa fa-print']) ?>
                                </div>
                            </td>
                        </tr>
                    </table>
                </div>

            </div>
        </div>
    </div>
    <div class="col-md-1">

    </div>
</div>