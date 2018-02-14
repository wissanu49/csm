<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\SearchSubDeposits */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Sub Deposits';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sub-deposits-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Sub Deposits', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'products_id',
            'amount',
            'deposits_id',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
