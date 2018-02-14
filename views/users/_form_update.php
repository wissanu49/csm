<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

p2m\sbAdmin\assets\SBAdmin2Asset::register($this);
p2m\assets\TimelineAsset::register($this);
p2m\assets\MorrisAsset::register($this);
/* @var $this yii\web\View */
/* @var $model app\models\Users */
/* @var $form yii\widgets\ActiveForm */
?>


<?php $form = ActiveForm::begin(); ?>

<div class="row">
    <div class="col-lg-6">
        <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'fullname')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'status')->dropDownList(['Active' => 'ปกติ', 'Suspend' => 'ระงับกานใช้งาน',], ['prompt' => '--สถานะ--']) ?>

        <?= $form->field($model, 'role')->dropDownList(['User' => 'ผู้ใช้งาน', 'Admin' => 'ผู้ดูแลระบบ',], ['prompt' => '--กลุ่มผู้ใช้งาน--']) ?>
    </div>
</div>
<div class="form-group">
    <?= Html::submitButton('  บันทึก ', ['class' => 'btn btn-success fa fa-save']) ?>&nbsp;
    <?= Html::a('  เปลี่ยนรหัสผ่าน ',['changepwd','id'=>$model->id], ['class' => 'btn btn-primary fa fa-save']) ?>
</div>

<?php ActiveForm::end(); ?>

