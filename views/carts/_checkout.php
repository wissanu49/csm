<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Customers;
use kartik\select2\Select2;
use kartik\date\DatePicker;
use app\models\Products;
use app\models\Units;
use yii\web\View;

p2m\sbAdmin\assets\SBAdmin2Asset::register($this);
p2m\assets\TimelineAsset::register($this);
p2m\assets\MorrisAsset::register($this);
/* @var $this yii\web\View */
/* @var $model app\models\Deposits */
/* @var $form yii\widgets\ActiveForm */
?>

<?php $form = ActiveForm::begin(); ?>
<div class="row">
    <div class="col-lg-4">

        <?= $form->field($model, 'id')->textInput(['readonly' => true]) ?>
        <?=
        $form->field($model, 'customers_id')->widget(Select2::classname(), [
            'data' => ArrayHelper::map(Customers::find()->all(), 'id', 'fullname'),
            'language' => 'th',
            'options' => ['placeholder' => 'ค้นหาลูกค้า ...'],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]);
        ?>
        <?= $form->field($model, 'comment')->textarea(['rows' => 5]) ?>
         <div class="form-group">
            <?= Html::submitButton(' ยืนยันรายการ ', ['class' => 'btn btn-success fa fa-plus']) ?>
            <?php //Html::a(' ยืนยันรายการ ', ['/carts/checkout',], ['class' => 'btn btn-info fa fa-save']) ?>
        </div>
    </div>
    <div class="col-lg-8">
        <div class="row">
            <div class="col-lg-12">
                <h4>รายการสินค้า</h4>
                <div class="box">
                    <!-- /.box-header -->
                    <div class="box-body no-padding">
                        <table class="table table-condensed">
                            <tr>
                                <th style="width: 10%;">#</th>
                                <th style="width: 60%;">รายการ</th>
                                <th style="width: 15%;">ราคาฝาก/หน่วย</th>
                                <th style="width: 15%;">จำนวน</th>
                            </tr>
                            <?php
                            $i = 0;
                            foreach ($carts as $cart) {
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
                    </div>
                </div>
            </div>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>


