<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use app\models\Products;
use app\models\Units;
use unclead\multipleinput\MultipleInput;
use unclead\multipleinput\MultipleInputColumn;

p2m\sbAdmin\assets\SBAdmin2Asset::register($this);
p2m\assets\TimelineAsset::register($this);
p2m\assets\MorrisAsset::register($this);

/* @var $this yii\web\View */
/* @var $model app\models\Withdraw */

$this->title = 'ทำรายการเบิก/ถอน : ' . $id;
//$this->params['breadcrumbs'][] = ['label' => 'รายการเบิก/ถอน', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
/*
$this->registerJs('
            $("#order-items").on("afterAddRow", function(e){
                //console.log("test");
                
            });
            $.fn.init_change = function(){
                
                var product_id = $(this).val();
                
                $.get(
                    "'.Url::toRoute('/site/product-detail').'",
                    {
                        id: product_id
                    },
                    function (data)
                    {
                        var result = data.split("-");
                                   
                        $(".field-order-items-"+sid[2]+"-product_name").text(result[0]);
                        $(".field-order-items-"+sid[2]+"-price").text(result[1]);
            
                    }
                );
            
            };
       
        ');
 * 
 */
?>
<?php

$form = ActiveForm::begin([
    'options' => [
        'id' => 'withdraw',
    ]
]);
?>
<?php // $form->field($model, 'deposits_id')->hiddenInput(['value' => $id])->label(false);    ?>
<div class="row">
    <div class="col-lg-6">
            <!-- /.panel-heading -->
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover">
                        <tr>
                            <th style="width: 10px">#</th>
                            <th>รายการ</th>
                            <th width="100px">คงเหลือ</th>
                            <th>เบิก/ถอน</th>
                        </tr>
                        <?php
                        $i = 0;
                        foreach ($dataProvider as $cart) {
                            $product = Products::getProduct($cart->products_id);
                            $price = Products::getPrice($cart->products_id);
                            $product_unit = Products::getUnitId($cart->products_id);
                            $unit = Units::getUnitName($product_unit->units_id);
                            ?>
                            <?= $form->field($model, 'products_id[' . $i . ']')->hiddenInput(['value' => $cart->products_id])->label(false); ?>
                            <tr>
                                <td><?= $i + 1 ?>.</td>
                                <td><?= $product->name ?></td>
                                <td><?= $cart->balance ?>&nbsp;<?= $unit->name; ?></td>
                                <td>
                                    <?php /*
                                            $form->field($model, 'items')->widget(MultipleInput::className(), [
                                                'allowEmptyList' => false,
                                                'min' => 1,
                                                'columns' => [
                                                    [
                                                        'name' => 'products_id',
                                                        //'title' => 'Products',
                                                        'enableError' => true,
                                                        'type' => MultipleInputColumn::TYPE_HIDDEN_INPUT,
                                                        'defaultValue' => $cart->products_id,
                                                    ],
                                                    [
                                                        'name' => 'deposits_id',
                                                        //'title' => 'Products',
                                                        'enableError' => true,
                                                        'type' => MultipleInputColumn::TYPE_HIDDEN_INPUT,
                                                        'defaultValue' => $id,
                                                    ],
                                                    [
                                                        'name' => 'amount',
                                                        //'title' => 'Amount',
                                                        'enableError' => true,
                                                        'type' => MultipleInputColumn::TYPE_TEXT_INPUT,
                                                        'defaultValue' => $cart->amount,
                                                    ],
                                                ]
                                            ])
                                            ->label(false);
                                     * 
                                     */
                                    ?>
                                    <?=  $form->field($model, 'amount['.$i.']')->textInput(['class' => 'form-control', 'value'=> $cart->amount, 'size' => '2', 'maxlenght'=> '3'])->label(FALSE);  ?>
                                     <?= Html::a(' เคลียร์ ', ['withdraw/checkout', 'id' => $id], ['class' => 'btn btn-info fa fa-repeat']) ?> &nbsp;
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
            <div style="float: right">
                <?= Html::a(' ย้อนกลับ ', Yii::$app->request->referrer, ['class' => 'btn btn-warning fa fa-arrow-left']) ?> &nbsp;
                <?= Html::a(' เคลียร์ ', ['withdraw/checkout', 'id' => $id], ['class' => 'btn btn-info fa fa-repeat']) ?> &nbsp;
                <?= Html::submitButton(' บันทึก ', ['class' => 'btn btn-success fa fa-save']) ?>

            </div>
            <?php ActiveForm::end(); ?>
    </div>
