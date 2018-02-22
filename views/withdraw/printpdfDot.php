<?php

use yii\helpers\Html;
use app\models\Numbertostring;
use app\models\Products;
use app\models\Withdraw;


$NumToString = new Numbertostring();
$this->title = "ใบเสร็จรับเงิน/เบิกสินค้า";
?>

<table class="table" style="width:100%; font-size:10px; line-height: 16px">
    <tr>
         <td style="width: 60%;">
            <h5><strong>LYMRR</strong></h5>
            <b>วันที่ :</b> <?= Yii::$app->formatter->asDate(date('Y-m-d'))?>
        </td>
        <td style="text-align: center;">
            <h5><strong>ใบเสร็จรับเงิน/เบิกสินค้า</strong></h5>
            <strong>เลขที่ : <?= $id ?></strong>

        </td>
    </tr>
    <tr>
        <td colspan="2">
            <table class="table " style="width:100%; font-size:10px;">
                <?php foreach ($depModel as $dep) { ?>
                    <tr>
                        <td style="text-align: left; width: 60%;">
                            <strong>ลูกค้า :</strong> <?= $dep->customers->fullname ?><br>
                            <strong>เลขใบฝาก :</strong> <?= $dep->id ?> 
                            
                        </td>
                        <td style="text-align: center;">
                            <strong>วันที่ฝาก :</strong> <?= Yii::$app->formatter->asDate($dep->deposit_date) ?>
                        </td>
                    </tr>
                <?php } ?>

            </table>
        </td>
    </tr>
    <tr>
        <td colspan="2">
            <table class="table" style="font-size:10px;" >
                <tr style="text-align: center;">
                    <td style="text-align: center;"><strong>#</strong></td>
                    <td style="text-align: left;"><strong>รายการ</strong></td>
                    <td style="text-align: center;"><strong>จำนวน</strong></td>
                    <td style="text-align: center;"><strong>ราคา</strong></td>
                    <td style="text-align: center;"><strong>เวลาฝาก</strong></td>
                    <td style="text-align: right;"><strong>รวม</strong></td>
                </tr>
                <?php
                $i = 1;
                $total = 0;
                $format = Yii::$app->formatter;
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
                        <td><?= $product->name ?></td>
                        <td style="text-align: center;"><?= $data->amount ?></td>
                        <td style="text-align: center;"><?= Yii::$app->formatter->asDecimal($price->price) ?></td>
                        <td style="text-align: center;"><?= $TimeTotal ?> เดือน</td>
                        <td style="text-align: right;"><?= Yii::$app->formatter->asDecimal($data->price) ?></td>
                    </tr>
                <?php
                $i++; } ?>
                <tr>
                    <td colspan="6" style="text-align: center;"> &nbsp;</td>
                </tr>
                <tr style="text-align: center; vertical-align: middle; ">
                    <td colspan="4" style="text-align: center;">
                        <h6><strong><?= $NumToString->Convert($total) ?></strong></h6>
                    </td>
                    
                    <td colspan="2" style="text-align: right; ">
                        <h6><strong><?= Yii::$app->formatter->asDecimal($total) ?></strong></h6>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td colspan="2">
            <table class="table">
                <tr>
                    <td style="text-align: center; width: 35%;">
                        <h6>..........................................<br>
                            ผู้ชำระเงิน</h6></td>
                    <td></td>
                    <td style="text-align: center;  width: 35%;">
                        <h6>..........................................<br>
                            ผู้รับเงิน</h6></td>
                </tr>
            </table>
        </td>
    </tr>
</table>

