<?php

use yii\helpers\Html;
p2m\sbAdmin\assets\SBAdmin2Asset::register($this);
p2m\assets\TimelineAsset::register($this);
p2m\assets\MorrisAsset::register($this);

/* @var $this yii\web\View */
/* @var $model app\models\Void */

$this->title = 'ส่งคำขอ';
$this->params['breadcrumbs'][] = ['label' => 'คำขอยกเลิกใบงาน', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <div class="col-lg-6">        

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
    </div>
</div>
