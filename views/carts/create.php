<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Carts */

$this->title = 'Create Carts';
$this->params['breadcrumbs'][] = ['label' => 'Carts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="carts-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
