<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\SubDeposits */

$this->title = 'Update Sub Deposits: {nameAttribute}';
$this->params['breadcrumbs'][] = ['label' => 'Sub Deposits', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="sub-deposits-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
