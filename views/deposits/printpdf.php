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

<table class="table">
    <tr>
        <td style="width: 60%">
            <h3>
                <strong>LYMRR</strong>
            </h3>
        </td>
        <td style="text-align: center;">
            <h5><strong>ใบรับฝากสินค้า</strong></h5>
            <h6><strong>เลขที่ <?= $id ?></strong></h6>

        </td>
    </tr>
    <tr>
        <td colspan="2">
            <table class="table " style="width:100%">
                <?php foreach ($depModel as $dep) { ?>
                    <tr>
                        <td style="text-align: left; width: 60%;">
                            <h6><strong>ลูกค้า :</strong> <?= $dep->customers->fullname ?> </h6>
                        </td>
                        <td style="text-align: left;">
                            <h6><strong>วันที่ :</strong> <?= Yii::$app->formatter->asDate($dep->deposit_date) ?></h6>
                        </td>
                    </tr>
                <?php } ?>

            </table>
        </td>
    </tr>
    <tr>
        <td colspan="2">
            <table class="table" >
                <tr style="text-align: center;">
                    <td style="width: 5%;text-align: center;"><h6><strong>#</strong></h6></td>
                    <td style="width: 65%"><h6><strong>รายการ</strong></h6></td>
                    <th style="width: 10%;"><h6><strong>ราคา</strong></h6></th>
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
        <td colspan="2">
            <table class="table">
                <tr>
                    <td style="text-align: center; width: 35%;">
                        <h6>..........................<br>
                        ผู้ฝากสินค้า</h6></td>
                    <td></td>
                    <td style="text-align: center;  width: 35%;">
                        <h6>..........................<br>
                        ผู้บันทึกรายการ</h6></td>
                </tr>
            </table>
        </td>
    </tr>
</table>

