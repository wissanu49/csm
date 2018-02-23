<?php

use yii\helpers\Html;
use app\models\Numbertostring;
use app\models\Products;
use app\models\Withdraw;
use app\models\Units;
use yii\helpers\StringHelper;

$NumToString = new Numbertostring();

$this->title = "ใบรับฝากสินค้า";
?>

<table class="table" style="width:100%; font-size:10px; line-height: 16px">
    <tr>
        <td style="width: 60%">
            <h5>
                <strong>LYMRR</strong>
            </h5>
            <strong>วันที่ :</strong> <?= Yii::$app->formatter->asDate(date('Y-m-d')) ?>
        </td>
        <td style="text-align: center;">
            <h5><strong>ใบรับฝากสินค้า</strong></h5>
            <strong>เลขที่ : <?= $id ?></strong>

        </td>
    </tr>
    <?php foreach ($depModel as $dep) { ?>
        <tr>
            <td style="text-align: left; width: 60%;">
                <strong>ลูกค้า :</strong> <?= $dep->customers->fullname ?> <br>
                
            </td>
            <td style="text-align: center;">
                <strong>วันที่ฝาก :</strong> <?= Yii::$app->formatter->asDate($dep->deposit_date) ?>
            </td>
        </tr>
    <?php } ?>

    <tr>
        <td colspan="2">
            <table class="table" style="width:80%; font-size:10px;" >
                <tr style="text-align: center;">
                    <td style="text-align: center;"><strong>#</strong></td>
                    <td ><strong>รายการ</strong></td>
                    <th style="text-align: right;"><strong>ราคาฝาก</strong></th>
                    <td style="text-align: right;"><strong>จำนวน</strong></td>
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
                        <td style="text-align: center;"><?= $i + 1 ?>.</td>
                        <td><?= $product->name ?></td>
                        <td style="text-align: right;"><?= Yii::$app->formatter->asDecimal($price->price) ?></td>
                        <td style="text-align: right;"><?= $cart->amount ?>&nbsp;<?= $unit->name; ?></td>
                    </tr>
                    <?php
                    $i++;
                }
                ?>

            </table>
        </td>
    </tr>

    <tr>
        <td colspan="2">
            <table class="table">
                <tr>
                    <td style="text-align: center; width: 35%;">
                        ..........................<br>
                        ผู้ฝากสินค้า</td>
                    <td></td>
                    <td style="text-align: center;  width: 35%;">
                        ..........................<br>
                        ผู้บันทึก</td>
                </tr>
            </table>
        </td>
    </tr>
</table>

