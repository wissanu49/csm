<?php

use yii\helpers\Html;

p2m\sbAdmin\assets\SBAdmin2Asset::register($this);
p2m\assets\TimelineAsset::register($this);
p2m\assets\MorrisAsset::register($this);
/* @var $this yii\web\View */
/* @var $model app\models\Customers */

$this->title = 'เพิ่มลูกค้าใหม่';
$this->params['breadcrumbs'][] = ['label' => 'รายชื่อลูกค้า', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="customers-create">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
