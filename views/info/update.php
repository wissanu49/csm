<?php

use yii\helpers\Html;
p2m\sbAdmin\assets\SBAdmin2Asset::register($this);
p2m\assets\TimelineAsset::register($this);
p2m\assets\MorrisAsset::register($this);
/* @var $this yii\web\View */
/* @var $model app\models\Info */

$this->title = 'ข้อมูลองค์กร';
$this->params['breadcrumbs'][] = 'ข้อมูลองค์กร';
?>

<div class="row">
    <div class="col-lg-3"></div>
    <div class="col-lg-6">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
        </div>
<div class="col-lg-3"></div>
</div>

