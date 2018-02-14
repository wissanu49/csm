<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use app\models\Customers;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;

p2m\sbAdmin\assets\SBAdmin2Asset::register($this);
p2m\assets\TimelineAsset::register($this);
p2m\assets\MorrisAsset::register($this);
/* @var $this yii\web\View */
/* @var $searchModel app\models\SearchCustomers */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'รายการสินค้า เข้า/ออก/คงเหลือ';
$this->params['breadcrumbs'][] = $this->title;
//die(var_dump($deposits));
?>
<div class="row">
    <div class="col-lg-3">
        <?php
        $form = ActiveForm::begin([
                    'action' => ['report'],
                    'method' => 'post',
        ]);
        ?>

        <?=
        $form->field($searchModel, 'id')->widget(Select2::classname(), [
            'data' => ArrayHelper::map(Customers::find()->all(), 'id', 'fullname'),
            'language' => 'th',
            'options' => ['placeholder' => 'ค้นหารายชื่อ ...', 'onchange' => 'this.form.submit()',],
            'pluginOptions' => [
                'allowClear' => true
            ],
            'class' => 'form-control',
        ])->label(FALSE);
        ?>

    </div>
    <div class="col-lg-4">
        <?= Html::submitButton(' ค้นหา ', ['class' => 'btn btn-info btn-lg fa fa-search']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>

<div class="row">
    <div class="col-lg-12">

        <div style="text-align: center;">
            <?php
            $customers = new Customers();
            $customers = $customers->getCustomerData($cusid);
            //var_dump($customers);
            foreach ($customers as $cus) {
                echo "<h4><b>ลูกค้า</b> : " . $cus->fullname . "</h4>";
            }
            //echo $customers['fullname'];
            ?>
        </div>
    </div>
</div>
    
<div class="row">
    <div class="col-lg-6">
        <div class="panel panel-warning">
            <div class="panel-heading">
                <h5>รายการฝากเข้า : <?= date('d-m-Y') ?></h5>
            </div>
            <!-- /.panel-heading -->
            <div class="panel-body">
                <table class="table table-bordered">
                    <tr>
                        <th>เลขเอกสาร</th>
                        <th>สินค้า</th>
                        <th>จำนวน</th>
                    </tr>
                    <?php
                    foreach ($deposits as $dep) {
                        ?>
                        <tr>
                            <td><?= $dep['id'] ?></td>
                            <td><?= $dep['name'] ?></td>
                            <td><?= $dep['amount'] ?></td>
                        </tr>
                    <?php } ?>
                </table>
            </div>
        </div>
    </div>

    <div class="col-lg-6">
        <div class="panel panel-info">
            <div class="panel-heading">
                <h5>รายการเบิก : <?= date('d-m-Y') ?></h5>
            </div>
            <!-- /.panel-heading -->
            <div class="panel-body">
                <table class="table table-bordered">
                    <tr>
                        <th>เลขเอกสาร</th>
                        <th>สินค้า</th>
                        <th>จำนวน</th>
                    </tr>
                    <?php
                    foreach ($withdraw as $with) {
                        ?>
                        <tr>
                            <td><?= $with['withdraw_id'] ?></td>
                            <td><?= $with['name'] ?></td>                
                            <td><?= $with['amount'] ?></td>
                        </tr>
                    <?php } ?>
                </table>
            </div>

        </div>
    </div>
</div>
<div class="row">
        <div class="col-lg-12">
            <div class="panel panel-success">
                <div class="panel-heading">
                    <h5>รายการคงเหลือ</h5>
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">

                    <table class="table table-bordered">
                        <tr>
                            <th>เลขเอกสาร</th>
                            <th>สินค้า</th>
                            <th>คงเหลือ</th>
                        </tr>
                        <?php
                        foreach ($remain as $rem) {
                            ?>
                            <tr>
                                <td><?= $rem['deposits_id'] ?></td>
                                <td><?= $rem['name'] ?></td>
                                <td><?= $rem['balance'] ?></td>
                            </tr>
                        <?php } ?>
                    </table>
                </div>
            </div>
        </div>
    </div>
