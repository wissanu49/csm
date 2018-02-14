<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;

p2m\sbAdmin\assets\SBAdmin2Asset::register($this);
p2m\assets\TimelineAsset::register($this);
p2m\assets\MorrisAsset::register($this);

/* @var $this yii\web\View */
/* @var $searchModel app\models\SearchUnits */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'หน่วยนับ';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="row">
    <div class="col-lg-6">

        <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

        <p>
            <?= Html::a(' เพิ่มรายการใหม่', ['create'], ['class' => 'btn btn-success fa fa-plus']) ?>
        </p>

        <?=
        GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                //'id',
                'name',
                [
                    'class' => 'yii\grid\ActionColumn',
                    'visibleButtons' => [
                        'view' => function ($model, $key, $index) {
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
                        'delete' => function ($url, $model) {
                            return Html::a('<span class="fa fa-remove"></span>', ['units/delete', 'id' => $model->id], [
                                        'title' => '',
                                        'class' => 'btn btn-danger',
                                        'data-method' => 'post',
                                        'data-confirm' => Yii::t('yii', 'คุณต้องการลบรายการ ' . $model->name . ' ใช่หรือไม่?'),
                            ]);
                        }
                    ],
                ],
            ],
        ]);
        ?>
    </div>
</div>
