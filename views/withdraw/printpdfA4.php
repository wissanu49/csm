<?php

use yii\helpers\Html;
use app\models\Numbertostring;
use app\models\Products;
use app\models\Withdraw;


$NumToString = new Numbertostring();
$this->title = "ใบเสร็จรับเงิน/เบิกสินค้า";
?>

<table class="table">
    <tr>
         <td style="text-align: left;">
            <h3><strong>LYMRR</strong></h3>
        </td>
        <td style="text-align: center;">
            <h5><strong>ใบเสร็จรับเงิน/เบิกสินค้า</strong></h5>
            <h6><strong>เลขที่ <?= $id ?></strong></h6>

        </td>
    </tr>
    <tr>
        <td colspan="2">
            <table class="table " style="width:100%">
                <?php foreach ($depModel as $dep) { ?>
                    <tr>
                        <td style="text-align: left; width: 60%;">
                            <h5><strong>เลขใบฝาก :</strong> <?= $dep->id ?> </h5>
                            <h5><strong>ลูกค้า :</strong> <?= $dep->customers->fullname ?> </h5>
                        </td>
                        <td style="text-align: center;">
                            <h5><strong>วันที่ :</strong> <?= Yii::$app->formatter->asDate($dep->deposit_date) ?></h5>
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
                    <td style="text-align: center;"><h5><strong>#</strong></h5></td>
                    <td style="text-align: left;"><h5><strong>รายการ</strong></h5></td>
                    <td style="text-align: center;"><h5><strong>จำนวน</strong></h5></td>
                    <td style="text-align: center;"><h5><strong>ราคา</strong></h5></td>
                    <td style="text-align: center;"><h5><strong>เวลาฝาก</strong></h5></td>
                    <td style="text-align: center;"><h5><strong>รวม</strong></h5></td>
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
                        <td style="text-align: center;  line-height: 25px;"><h5><?= $i ?></h5></td>
                        <td><h5><?= $product->name ?></h5></td>
                        <td style="text-align: center;"><h5><?= $data->amount ?></h5></td>
                        <td style="text-align: center;"><h5><?= Yii::$app->formatter->asDecimal($price->price) ?></h5></td>
                        <td style="text-align: center;"><h5><?= $TimeTotal ?> เดือน</h5></td>
                        <td style="text-align: center;"><h5><?= Yii::$app->formatter->asDecimal($data->price) ?></h5></td>
                    </tr>
                <?php
                $i++; } ?>
                <tr>
                    <td colspan="6" style="text-align: center; line-height: 30px;"> &nbsp;</td>
                </tr>
                <tr style="text-align: center; vertical-align: middle; ">
                    <td colspan="4" style="text-align: center; line-height: 30px;">
                        <h5><strong><?= $NumToString->Convert($total) ?></strong></h5>
                    </td>
                    
                    <td colspan="2" style="text-align: right; ">
                        <h5><strong><?= Yii::$app->formatter->asDecimal($total) ?></strong></h5>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
     <tr>
        <td colspan="2">&nbsp;<br></td>
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

