<?php

use yii\helpers\Html;
p2m\sbAdmin\assets\SBAdmin2Asset::register($this);
p2m\assets\TimelineAsset::register($this);
p2m\assets\MorrisAsset::register($this);
/* @var $this yii\web\View */
/* @var $model app\models\Customers */

$this->title = 'แก้ไขข้อมูล : '.$model->fullname;
$this->params['breadcrumbs'][] = ['label' => 'รายชื่อลูกค้า', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->fullname, 'url' => ['update', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'แก้ไขข้อมูล';
?>
<div class="customers-update">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
