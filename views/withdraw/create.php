<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Withdraw */

$this->title = 'ทำรายการเบิก/ถอน';
$this->params['breadcrumbs'][] = ['label' => 'รายการเบิก/ถอน', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="withdraw-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
