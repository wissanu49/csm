<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use kartik\date\DatePicker;
use yii\helpers\ArrayHelper;
use app\models\Products;
use app\models\Units;
use yii\web\View;

p2m\sbAdmin\assets\SBAdmin2Asset::register($this);
p2m\assets\TimelineAsset::register($this);
p2m\assets\MorrisAsset::register($this);
/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'เลือกรายการสินค้า';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <div class="col-lg-4">
        <?php $form = ActiveForm::begin(); ?>
        <?=
        $form->field($model, 'products_id')->widget(Select2::classname(), [
            'data' => ArrayHelper::map(Products::find()->all(), 'id', 'name'),
            'language' => 'th',
            'options' => ['placeholder' => 'ค้นหาสินค้า ...'],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]);
        ?>
        <?= $form->field($model, 'amount')->textInput() ?>
        <div class="form-group">
            <?= Html::submitButton(' เพิ่ม ', ['class' => 'btn btn-success fa fa-plus']) ?>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
    <div class="col-lg-8">
        <h4>รายการสินค้า</h4>
        <div class="box">
            <!-- /.box-header -->
            <div class="box-body no-padding">
                <table class="table table-condensed">
                    <tr>
                        <th style="width: 10px">#</th>
                        <th>รายการ</th>
                        <th>ราคา/หน่วย/เดือน</th>
                        <th>จำนวน</th>
                        <th style="width: 10px">ยกเลิก</th>

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
                            <td><?= $price->price ?> บาท</td>
                            <td><?= $cart->amount ?>&nbsp;<?= $unit->name; ?></td>

                            <td>
                                <?= Html::a('', ['/carts/removeitem', 'id' => $cart->id], ['class' => 'btn btn-danger fa fa-times']) ?>
                            </td>

                        </tr>
                        <?php
                        $i++;
                    }
                    ?>
                </table>

            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
        <?= Html::a(' บันทึกรายการ ', ['/carts/checkout',], ['class' => 'btn btn-info fa fa-save']) ?>
    </div>

</div>
