<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap\Modal;
use yii\helpers\Url;

p2m\sbAdmin\assets\SBAdmin2Asset::register($this);
p2m\assets\TimelineAsset::register($this);
p2m\assets\MorrisAsset::register($this);
/* @var $this yii\web\View */
/* @var $searchModel app\models\SearchCustomers */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'รายชื่อลูกค้า';
$this->params['breadcrumbs'][] = $this->title;


?>
<div class="row">
<?php
Modal::begin([
    'headerOptions' => ['id' => 'modalHeader'],
    'id' => 'modal',
    'size' => 'modal-lg',
]);
echo "<div id='modalContent'></div>";
Modal::end();
?>


    <p style="text-align: right;">
        <?= Html::button(' เพิ่มลูกค้ารายใหม่ ', ['value' => Url::to(['customers/create']), 
                            'title' => 'เพิ่มลูกค้ารายใหม่',
                            'id' => 'showModalButton', 
                            'class' => 'btn btn-primary fa fa-plus'
                            ]); ?>
    </p>

    
    <?php  echo $this->render('_search', ['model' => $searchModel]); ?>

   
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            'fullname',
            'address:ntext',
            'phone',
             [
                'label' => '',
                //'attribute' => 'status',
                'format' => 'raw',
                'filter' => FALSE, //กำหนด filter แบบ dropDownlist จากข้อมูล ใน field แบบ foreignKey
                'value' => function ($data) {
                        return Html::a(' สินค้า เข้า/ออก/คงเหลือ ', yii\helpers\Url::to(['customers/report', 'uid' => $data->id]), ['class' => 'btn btn-success']);
                    
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
                'template' => '{update}',
                'buttons' => [
                    'update' => function ($url, $model) {
                        /*
                        return Html::a('<span class="fa fa-edit"></span>', $url, [
                                    'title' => '',
                                    'class' => 'btn btn-primary' ,
                        ]);
                         * 
                         */
                        
                        return Html::button('', ['value' => Url::to(['customers/update', 'id' => $model->id]), 
                            'title' => 'แก้ไขข้อมูลลูกค้า : '.$model->fullname,
                            'id' => 'showModalButton', 
                            'class' => 'btn btn-primary fa fa-edit'
                            ]);
                    },
                    
                ],
            ],
        ],
    ]); ?>
</div>
<?php
//$js = Yii::getAlias('@web').'/js/modal.js';
$js = "$(document).on('click', '#showModalButton', function(){
        if ($('#modal').data('bs.modal').isShown) {
            $('#modal').find('#modalContent')
                    .load($(this).attr('value'));
            document.getElementById('modalHeader').innerHTML = '<h4>' + $(this).attr('title') + '</h4>';
        } else {
            $('#modal').modal('show')
                    .find('#modalContent')
                    .load($(this).attr('value'));
            document.getElementById('modalHeader').innerHTML = '<h4>' + $(this).attr('title') + '</h4>';
        }
    });";
$this->registerJs($js)
?>