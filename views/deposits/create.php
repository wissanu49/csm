<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;

p2m\sbAdmin\assets\SBAdmin2Asset::register($this);
p2m\assets\TimelineAsset::register($this);
p2m\assets\MorrisAsset::register($this);

/* @var $this yii\web\View */
/* @var $model app\models\Deposits */

$this->title = 'สร้างรายการใหม่';
$this->params['breadcrumbs'][] = ['label' => 'รายการเช่า/ฝาก', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="deposits-create">

    <?= $this->render('_form', [
        'model' => $model,
        'runningcode' => $runningcode,
    ]) ?>

</div>
