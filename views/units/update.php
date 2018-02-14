<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Units */

$this->title = 'แก้ไขข้อมูล : '.$model->name;
$this->params['breadcrumbs'][] = ['label' => 'หน่วยนับ', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['update', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="units-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
