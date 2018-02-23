<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\widgets\Pjax;

p2m\sbAdmin\assets\SBAdmin2Asset::register($this);
p2m\assets\TimelineAsset::register($this);
p2m\assets\MorrisAsset::register($this);
/* @var $this yii\web\View */
/* @var $searchModel app\models\SearchDeposits */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'รายการเช่า/ฝาก';
$this->params['breadcrumbs'][] = $this->title;
?>
<?php Pjax::begin(); ?>

<?php // echo $this->render('_search', ['model' => $searchModel]); ?>

<p style="text-align:right;">
    <?= Html::a(' ทำรายการใหม่', ['carts/'], ['class' => 'btn btn-success btn-lg fa fa-plus']) ?>
</p>
<?=
GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'columns' => [
        // ['class' => 'yii\grid\SerialColumn'],

        [
            //'label' => '',
            'attribute' => 'status',
            'format' => 'raw',
            'filter' => Html::activeDropDownList($searchModel, 'status', ['void' => 'ยกเลิก', 'remain' => 'คงเหลือ', 'closed' => 'ปิด'], ['class' => 'form-control', 'prompt' => '']),
            'value' => function ($data) {
                if ($data->status == 'void') {
                    return Html::button(' Void ', ['class' => 'btn btn-warning', 'disabled' => true]);
                } else if ($data->status == 'remain') {
                    return Html::button(' คงเหลือ ', ['class' => 'btn btn-info', 'disabled' => true]);
                } else if ($data->status == 'closed') {
                    return Html::button(' ปิด ', ['class' => 'btn btn-success', 'disabled' => true]);
                }
            }
        ],
        'id',
        [
            'attribute' => 'customers_id',
            'filter' => ArrayHelper::map(app\models\Customers::find()->all(), 'id', 'fullname'), //กำหนด filter แบบ dropDownlist จากข้อมูล ใน field แบบ foreignKey
            'value' => function($model) {
                return $model->customers->fullname;
            }
        ],
        'deposit_date:date',
        'comment',
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
                                'class' => 'btn btn-primary',
                    ]);
                }
            ],
        ],
    ],
]);
?>
<?php Pjax::end(); ?>

