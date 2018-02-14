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
                                <h6>
                                    <strong><?= $company ?></strong><br>
                                    <?= $address ?><br>
                                    <?= $phone ?>
                                </h6>
                            </td>
                            <td>
                                <h4><strong>ใบรับฝาก</strong></h4>
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
                                                <h5><strong>ชื่อลูกค้า :</strong> <?= $dep->customers->fullname ?> </h5>
                                                <h5><strong>ที่อยู่ :</strong> <?= $dep->customers->address ?></h5> 
                                            </td>
                                            <td style="text-align: center;">
                                                <h5><strong>วันที่</strong> <?= $dep->deposit_date ?></h5>
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
                                        <td style="width: 5%;"><strong>#</strong></td>
                                        <td style="width: 35%;"><strong>รายการ</strong></td>
                                        <th style="width: 15%;">ราคาฝาก/หน่วย</th>
                                        <td style="width: 10%;"><strong>จำนวน</strong></td>
                                    </tr>
                                    <?php
                                    $i = 0;
                                    foreach ($dataProvider as $cart) {
                                        $product = Products::getProduct($cart->products_id);
                                        $price = Products::getPrice($cart->products_id);
                                        $product_unit = Products::getUnitId($cart->products_id);
                                        $unit = Units::getUnitName($product_unit->units_id);
                                        ?>
                                        <tr>
                                            <td><?= $i + 1 ?>.</td>
                                            <td><?= $product->name ?></td>
                                            <td><?= $price->price ?> &nbsp;</td>
                                            <td><?= $cart->amount ?>&nbsp;<?= $unit->name; ?></td>
                                        </tr>
                                        <?php
                                        $i++;
                                    }
                                    ?>
                                </table>
                            </td>
                        </tr>
                    </table>
                </div>

            </div>
        </div>
    </div>
    <div class="col-md-1">
        <div>
            <?= Html::a(' พิมพ์ ', ['withdraw/printpdf', 'id' => $billId], ['target' => '_blank', 'class' => 'btn btn-info fa fa-print']) ?>
        </div>
    </div>
</div>

