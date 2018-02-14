<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;

p2m\sbAdmin\assets\SBAdmin2Asset::register($this);
p2m\assets\TimelineAsset::register($this);
p2m\assets\MorrisAsset::register($this);
/* @var $this yii\web\View */
/* @var $searchModel app\models\SearchUsers */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'ผู้ใช้งาน';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="users-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(' สร้างผู้ใช้งาน ', ['create'], ['class' => 'btn btn-success fa fa-plus']) ?>
    </p>

    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            //'id',
            'username',
            //'password',
            'fullname',
            'status',
            [
                'label' => 'สิทธิ์',
                //'attribute' => 'status',
                'format' => 'raw',
                'filter' => FALSE, //กำหนด filter แบบ dropDownlist จากข้อมูล ใน field แบบ foreignKey
                'value' => function ($data) {
                    if ($data['role'] == 'Admin') {
                        return Html::a('ผู้ดูแลระบบ', '', ['class' => 'btn btn-success']);
                    } else if ($data['role'] == 'User') {
                        return Html::a('ผู้ใช้งาน', '', ['class' => 'btn btn-primary']);
                    }
                }
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'visibleButtons' => [
                    'view' => function ($model, $key, $index) {
                        return false;
                    },
                    'delete' => function ($model, $key, $index) {
                        return false;
                    },
                ],
                'template' => '{update} {delete}',
                'buttons' => [
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
</div>
