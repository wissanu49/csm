<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use app\models\Customers;

/* @var $this yii\web\View */
/* @var $model app\models\SearchCustomers */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="customers-search">

    <?php
    $form = ActiveForm::begin([
                'action' => ['index'],
                'method' => 'get',
    ]);
    ?>

    <div class="row">
        <div class="col-lg-4">
            <?=
            $form->field($model, 'id')->widget(Select2::classname(), [
                'data' => ArrayHelper::map(Customers::find()->all(), 'id', 'fullname'),
                'language' => 'th',
                'options' => ['placeholder' => 'ค้นหารายชื่อ ...', 'onchange'=>'this.form.submit()'],
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
    </div>

<?php ActiveForm::end(); ?>

</div>
