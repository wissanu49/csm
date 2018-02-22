<?php

use yii\helpers\Html;
use app\models\Numbertostring;
use app\models\Products;
use app\models\Units;

p2m\sbAdmin\assets\SBAdmin2Asset::register($this);
p2m\assets\TimelineAsset::register($this);
p2m\assets\MorrisAsset::register($this);
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$NumToString = new Numbertostring();
$infos = app\models\Info::find()->all();
foreach ($infos as $info) {
    $company = $info->company_name;
    $address = $info->address;
    $phone = $info->phone;
    $logo = $info->logo;
}
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
                            <td style="width: 60%">
                                <h3>
                                    LYMRR
                                </h3>
                            </td>
                            <td style="text-align: center;">
                                <h4><strong>ใบรับฝากสินค้า</strong></h4>
                                <h6><strong>เลขที่ <?= $id ?></strong></h6>
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
                                                <h6><strong>ชื่อลูกค้า :</strong> <?= $dep->customers->fullname ?> </h6>
                                            </td>
                                            <td style="text-align: center;">
                                                <h6><strong>วันที่</strong> <?= Yii::$app->formatter->asDate($dep->deposit_date) ?></h6>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <table class="table">
                                    <tr>
                                        <td style="width: 10%;text-align: center;"><h6><strong>#</strong></h6></td>
                                        <td style="width: 65%;"><h6><strong>รายการ</strong></h6></td>
                                        <th style="width: 15%;"><h6><strong>ราคา/หน่วย</strong></h6></th>
                                        <td style="width: 10%;text-align: center;"><h6><strong>จำนวน</strong></h6></td>
                                    </tr>
                                    <?php
                                    $i = 0;
                                    foreach ($dataProvider as $cart) {
                                        $product = Products::getProduct($cart->products_id);
                                        $price = Products::getPrice($cart->products_id);
                                        $product_unit = Products::getUnitId($cart->products_id);
                                        $unit = Units::getUnitName($product_unit->units_id);
                                        ?>
                                        <tr >
                                            <td style="text-align: center;"><h6><?= $i + 1 ?>.</h6></td>
                                            <td><h6><?= $product->name ?></h6></td>
                                            <td><h6><?= $price->price ?></h6></td>
                                            <td style="text-align: center;"><h6><?= $cart->amount ?>&nbsp;<?= $unit->name; ?></h6></td>
                                        </tr>
                                        <?php
                                        $i++;
                                    }
                                    ?>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" style="text-align: center;">
                                <div>
                                    <?= Html::a(' หน้าหลัก ', Yii::$app->homeUrl, ['class' => 'btn btn-warning fa fa-home']) ?>&nbsp;
                                    <?= Html::a(' พิมพ์ Slip ', ['deposits/printpdf', 'id' => $id], ['target' => '_blank', 'class' => 'btn btn-warning fa fa-print']) ?>&nbsp;
                                    <?= Html::a(' พิมพ์ A4', ['deposits/printpdfa4', 'id' => $id], ['target' => '_blank', 'class' => 'btn btn-info fa fa-print']) ?>&nbsp;
                                    <?= Html::a(' พิมพ์ Dot Matrix', ['deposits/printpdfa4', 'id' => $id], ['target' => '_blank', 'class' => 'btn btn-success fa fa-print']) ?>
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

