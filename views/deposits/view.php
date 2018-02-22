<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\ArrayHelper;
use app\models\Products;
use app\models\Units;
use yii\helpers\Url;
use yii\bootstrap\Modal;

p2m\sbAdmin\assets\SBAdmin2Asset::register($this);
p2m\assets\TimelineAsset::register($this);
p2m\assets\MorrisAsset::register($this);

/* @var $this yii\web\View */
/* @var $model app\models\Deposits */

$this->title = 'เลขที่ใบฝาก : ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'รายการเช่า/ฝาก', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$session = Yii::$app->session;
?>
<?php
Modal::begin([
    'headerOptions' => ['id' => 'modalHeader'],
    'id' => 'modal',
    'size' => 'modal-md',
]);
echo "<div id='modalContent'></div>";


Modal::end();
?>
<div class="row">
    <div class="col-lg-12">
        <div class="row">
            <div class="col-lg-6">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        ข้อมูลใบงาน
                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body">
                        <?=
                        DetailView::widget([
                            'model' => $model,
                            'attributes' => [
                                'id',
                                [// the owner name of the model
                                    'attribute' => 'customers_id',
                                    'value' => $model->customers->fullname,
                                ],
                                'deposit_date:date',
                                [
                                    'attribute' => 'status',
                                    'value' => function ($data) {
                                        if ($data->status == 'remain') {
                                            return 'คงเหลือ';
                                        } elseif ($data->status == 'closed') {
                                            return 'ปิด';
                                        } elseif ($data->status == 'void') {
                                            return 'Void';
                                        }
                                    }
                                ],
                                [
                                    'attribute' => 'users_id',
                                    'value' => $model->users->fullname,
                                ],
                                'comment',
                                [
                                    'attribute' => '',
                                    'label' => '',
                                    'format' => 'raw',
                                    'value' => function ($data) {
                                        return Html::a(' พิมพ์ Slip ', ['deposits/printpdf', 'id' => $data->id], ['target' => '_blank', 'class' => 'btn btn-info fa fa-print'])." ".Html::a(' พิมพ์ A4', ['deposits/printpdfa4', 'id' => $data->id], ['target' => '_blank', 'class' => 'btn btn-info fa fa-print']);
                                    }
                                ],
                            ],
                        ]);
                        ?>
                    </div>
                </div>
            </div>
            <?php
            if ($model->status != 'void') {
                ?>
                <div class="col-lg-6">
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            รายการสินค้า
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover">
                                    <tr>
                                        <th style="width: 10px">#</th>
                                        <th>รายการ</th>
                                        <th>ฝาก</th>
                                        <th>เบิก</th>
                                        <th>คงเหลือ</th>
                                        <th style="width: 50px"></th>
                                    </tr>
                                    <?php
                                    $i = 0;
                                    foreach ($dataProvider as $cart) {
                                        $product = Products::getProduct($cart->products_id);
                                        $price = Products::getPrice($cart->products_id);
                                        $product_unit = Products::getUnitId($cart->products_id);
                                        $unit = Units::getUnitName($product_unit->units_id);
                                        $amount = app\models\Withdraw::getSumAmount($model->id, $cart->products_id);
                                        ?>
                                        <tr>
                                            <td><?= $i + 1 ?>.</td>
                                            <td><?= $product->name ?></td>
                                            <td><?= $cart->amount ?>&nbsp;<?= $unit->name; ?></td>
                                            <td><?= $amount ?>&nbsp;<?= $unit->name; ?></td>
                                            <td><?= $cart->balance ?>&nbsp;<?= $unit->name; ?></td>
                                            <td>
                                                <?php if ($cart->balance > 0) { ?>
                                                    <?= Html::button(' เบิก ', ['value' => Url::to(['withdraw/additem', 'id' => $model->id, 'pid' => $cart->products_id]), 'title' => ' เพิ่มรายการ ', 'id' => 'showModalButton', 'class' => 'btn btn-success fa fa-arrow-right']); ?>
                                                <?php } ?>
                                            </td>
                                        </tr>
                                        <?php
                                        $i++;
                                    }
                                    ?>
                                </table>
                                <?= Html::a(' ย้อนกลับ ', Yii::$app->request->referrer, ['class' => 'btn btn-warning fa fa-arrow-left']) ?> 
                            </div>
                        </div>
                    </div>

                </div>
            <?php } ?>
        </div>

    </div>
</div>
<?php
if ($model->status != 'void') {
    ?>
    <div class="row">
        <div class="col-lg-12">
            <div class="row">
                <div class="col-lg-6">
                    <div class="panel panel-warning">
                        <div class="panel-heading">
                            ประวัติการเบิก
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover">
                                    <tr>
                                        <th style="width: 10px">#</th>
                                        <th>เลขใบเบิก</th>
                                        <th>รายการ</th>
                                        <th>วันที่เบิก</th>
                                        <th>จำนวน</th>
                                    </tr>
                                    <?php
                                    $i = 0;
                                    foreach ($withdraw as $wd) {
                                        $product = Products::getProduct($wd->products_id);
                                        $price = Products::getPrice($wd->products_id);
                                        $product_unit = Products::getUnitId($wd->products_id);
                                        $unit = Units::getUnitName($product_unit->units_id);
                                        ?>
                                        <tr>
                                            <td><?= $i + 1 ?>.</td>
                                            <td><?= $wd->withdraw_id ?></td>
                                            <td><?= $product->name ?></td>
                                            <td><?= Yii::$app->formatter->asDate($wd->date_withdraw) ?></td>
                                            <td><?= $wd->amount ?>&nbsp;<?= $unit->name; ?></td>

                                        </tr>
                                        <?php
                                        $i++;
                                    }
                                    ?>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            รายการเบิก
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="table-responsive">

                                <?php
                                $i = 0;
                                if (isset($_SESSION['items'])) {
                                    ?>
                                    <table class="table table-striped table-bordered table-hover">
                                        <tr>
                                            <th style="width: 10px">#</th>
                                            <th>รายการ</th>
                                            <th>เบิก</th>
                                            <th>ราคา/หน่วย</th>
                                            <th >เวลาฝาก</th>
                                            <th>รวม (บาท)</th>
                                            <th style="width: 50px"></th>
                                        </tr>
                                        <?php
                                        $totalPrice = 0;
                                        foreach ($_SESSION['items'] as $key => $cart) {
                                            $proName = Products::getProduct($cart['proid']);
                                            $price = Products::getPrice($cart['proid']);
                                            $dep = app\models\Deposits::find()->select('deposit_date')->where(['id' => $cart['depid']])->one();
                                            $time = new app\models\Withdraw();
                                            $compare = $time->CheckDate($dep->deposit_date);
                                            if ($compare < 1) {
                                                $compare = 1;
                                            }
                                            $total = (($cart['amount'] * $price->price) * $compare);
                                            $totalPrice += $total;
                                            ?>
                                            <tr>
                                                <td><?= $i + 1 ?>.</td>
                                                <td><?= $proName->name ?></td>
                                                <td><?= $cart['amount'] ?></td>
                                                <td style="text-align: center;"><?= $price->price ?></td>
                                                <td style="text-align: center;"><?= $compare ?> เดือน</td>
                                                <td style="text-align: center;"><?= $total ?></td>
                                                <td><?= Html::a('', ['withdraw/removeitem', 'depid' => $cart['depid'], 'id' => $cart['proid']], ['class' => 'btn btn-danger fa fa-times']) ?></td>
                                            </tr>
                                            <?php
                                            $i++;
                                        }
                                        ?>
                                        <tr>
                                            <td colspan="4"></td>
                                            <td><b>ราคารวม</b></td>
                                            <td style="text-align: center;"><?= $totalPrice ?></td>
                                            <td></td>
                                        </tr>
                                    </table>

                                    <?= Html::a(' เคลียร์/ยกเลิก รายการ ', ['withdraw/clearcarts', 'id' => $model->id], ['class' => 'btn btn-info fa fa-refresh']) ?>
                                    <?= Html::a(' บันทึก ', ['withdraw/savedata'], ['class' => 'btn btn-success fa fa-save']); ?>
                                    <?php
                                }
                                ?>
                            </div>
                            <!-- /.box-body -->
                        </div>
                        <!-- /.box -->

                    </div>
                </div>
            </div>
        </div>

    </div>
<?php } ?>
<?php
//$js = Yii::getAlias('@web').'/js/modal.js';
$js = "$(document).on('click', '#showModalButton', function(){
        if ($('#modal').data('bs.modal').isShown) {
            $('#modal').find('#modalContent')
                    .load($(this).attr('value'));
            document.getElementById('modalHeader').innerHTML = '<h4>' + $(this).attr('title') + '</h4>';
        } else {
            $('#modal').modal('show')
                    .find('#modalContent')
                    .load($(this).attr('value'));
            document.getElementById('modalHeader').innerHTML = '<h4>' + $(this).attr('title') + '</h4>';
        }
    });";
$this->registerJs($js)
?>