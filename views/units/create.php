<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;

p2m\sbAdmin\assets\SBAdmin2Asset::register($this);
p2m\assets\TimelineAsset::register($this);
p2m\assets\MorrisAsset::register($this);

/* @var $this yii\web\View */
/* @var $model app\models\Units */

$this->title = 'เพิ่มรายการใหม่';
$this->params['breadcrumbs'][] = ['label' => 'หน่วยนับ', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="units-create">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
