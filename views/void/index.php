<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel app\models\VoidSearch */
p2m\sbAdmin\assets\SBAdmin2Asset::register($this);
p2m\assets\TimelineAsset::register($this);
p2m\assets\MorrisAsset::register($this);
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'คำขอยกเลิกใบงาน';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="void-index">

    <?php Pjax::begin(); ?>
<?php // echo $this->render('_search', ['model' => $searchModel]);   ?>

    <p>
<?= Html::a(' ส่งคำขอ ', ['create'], ['class' => 'btn btn-success fa fa-plus']) ?>
    </p>

    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],
            //'id',
            [
                'attribute' => 'id',
                'headerOptions' => ['style' => 'width:5%'],
            ],
            [
                'attribute' => 'type',
                'format' => 'raw',
                'filter' => Html::activeDropDownList($searchModel, 'type', ['rec' => 'ใบเสร็จรับเงิน/เบิกสินค้า','dep' => 'ใบฝากสินค้า'], ['class' => 'form-control', 'prompt' => '']),
                'value' => function ($data) {
                    if ($data->type == 'rec') {
                        return Html::button(' ใบเสร็จรับเงิน/เบิกสินค้า ', ['class' => 'btn btn-success', 'disabled' => true]);
                    } else if ($data->type == 'dep') {
                        return Html::button(' ใบฝากสินค้า ', ['class' => 'btn btn-danger', 'disabled' => true]);
                    } 
                }
            ],
            'void_id',
            [
                'attribute' => 'status',
                'format' => 'raw',
                'filter' => Html::activeDropDownList($searchModel, 'status', ['request' => 'รออนุมัติ','reject' => 'ยกเลิก','approve' => 'อนุมัติ'], ['class' => 'form-control', 'prompt' => '']),
                'value' => function ($data) {
                    if ($data->status == 'approve') {
                        return Html::button(' อนุมัติ ', ['class' => 'btn btn-success', 'disabled' => true]);
                    } else if ($data->status == 'reject') {
                        return Html::button(' ยกเลิก ', ['class' => 'btn btn-danger', 'disabled' => true]);
                    } else if ($data->status == 'request') {
                        return Html::button(' รออนุมัติ ', ['class' => 'btn btn-info', 'disabled' => true]);
                    }
                }
            ],
            'date_request',
            'date_action',
            'comment:ntext',
            [
                'class' => 'yii\grid\ActionColumn',
                'headerOptions' => ['style' => 'width:10%'],
                'visibleButtons' => [
                    'delete' => function ($model, $key, $index) {
                        return false;
                    },
                ],
                'template' => ' {view} {update}',
                'buttons' => [
                    'view' => function ($url, $model) {
                        return Html::a('<span class="fa fa-list"></span>', $url, [
                                    'title' => '',
                                    'class' => 'btn btn-warning',
                        ]);
                    },
                    'update' => function ($url, $model) {
                           return Html::a('<span class="fa fa-edit"></span>', $url, [
                                    'title' => '',
                                    'class' => 'btn btn-primary',
                        ]); 
                    },
                ],
            ],
        ],
    ]);
    ?>
<?php Pjax::end(); ?>
</div>
