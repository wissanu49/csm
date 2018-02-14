<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\SubDeposits */

$this->title = 'Create Sub Deposits';
$this->params['breadcrumbs'][] = ['label' => 'Sub Deposits', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sub-deposits-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
