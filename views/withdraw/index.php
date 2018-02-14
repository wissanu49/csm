<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;

p2m\sbAdmin\assets\SBAdmin2Asset::register($this);
p2m\assets\TimelineAsset::register($this);
p2m\assets\MorrisAsset::register($this);
/* @var $this yii\web\View */
/* @var $searchModel app\models\SearchWithdraw */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'รายการเบิก';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="withdraw-index">

    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'void',
                'format' => 'raw',
                'filter' => Html::activeDropDownList($searchModel, 'void', ['true' => 'ยกเลิก','false' => 'ปกติ'], ['class' => 'form-control', 'prompt' => '']),
                'value' => function ($data) {
                    if($data->void == 'true'){
                        return Html::button(' ยกเลิก ', ['class' => 'btn btn-danger', 'disabled'=>true]);
                    }else if($data->void == 'false'){
                        return Html::button(' ปกติ ', ['class' => 'btn btn-success', 'disabled'=>true]);
                    }
                    
                }
            ],
            'withdraw_id',
            'deposits_id',
            'date_withdraw:date',
            [
                'attribute' => 'users_id',
                'filter' => ArrayHelper::map(app\models\Users::find()->all(), 'id', 'fullname'), //กำหนด filter แบบ dropDownlist จากข้อมูล ใน field แบบ foreignKey
                'value' => function($model) {
                    return $model->users->fullname;
                }
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'visibleButtons' => [
                    'update' => function ($model, $key, $index) {
                        return false;
                    },
                    'delete' => function ($model, $key, $index) {
                        return false;
                    },
                ],
                'template' => '{view}',
                'buttons' => [
                    'view' => function ($url, $model) {
                        return Html::a('<span class="fa fa-edit"></span>', $url, [
                                    'title' => '',
                                    'class' => 'btn btn-primary btn',
                        ]);
                    }
                ],
            ],
            
        ],
    ]);
    ?>
</div>
