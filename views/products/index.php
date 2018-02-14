<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\bootstrap\Modal;
use yii\helpers\Url;

p2m\sbAdmin\assets\SBAdmin2Asset::register($this);
p2m\assets\TimelineAsset::register($this);
p2m\assets\MorrisAsset::register($this);
/* @var $this yii\web\View */
/* @var $searchModel app\models\SearchProducts */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'สินค้า';
$this->params['breadcrumbs'][] = $this->title;


?>
<div class="products-index">
<?php
Modal::begin([
    'headerOptions' => ['id' => 'modalHeader'],
    'id' => 'modal',
    'size' => 'modal-lg',
]);
echo "<div id='modalContent'></div>";
Modal::end();
?>
    <div class="row">
        <div class="col-lg-2"></div>
        <div class="col-lg-8">
             <?php echo $this->render('_form',['model'=>$model]);  ?>
        </div>
        <div class="col-lg-2"></div>
    </div>
   

    
        <?php // Html::a(' เพิ่มรายการใหม่', ['create'], ['class' => 'btn btn-success fa fa-plus']) ?>
   

    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            //'id',
            'name',
            [
                'attribute' => 'price',
                'value' => function($model) {
                    return $model->price . " บาท";
                }
            ],
            [
                'attribute' => 'units_id',
                'filter' => ArrayHelper::map(app\models\Units::find()->all(), 'id', 'name'), //กำหนด filter แบบ dropDownlist จากข้อมูล ใน field แบบ foreignKey
                'value' => function($model) {
                    return $model->units->name;
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
                        
                        return Html::button('', ['value' => Url::to(['products/update', 'id' => $model->id]), 
                            'title' => 'แก้ไขรายการสินค้า : '.$model->name,
                            'id' => 'showModalButton', 
                            'class' => 'btn btn-primary fa fa-edit'
                            ]);
                    },
                ],
            ],
        ],
    ]);
    ?>
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
