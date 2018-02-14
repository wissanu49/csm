<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

p2m\sbAdmin\assets\SBAdmin2Asset::register($this);
p2m\assets\TimelineAsset::register($this);
p2m\assets\MorrisAsset::register($this);

/* @var $this yii\web\View */
/* @var $model app\models\Void */

$this->title = "เลขที่คำขอ : " . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'คำขอยกเลิกเอกสาร', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="void-view">

    <?=
    DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'id',
            [// the owner name of the model
                'label' => 'ประเภทคำร้อง',
                'value' => function ($data) {
                    if ($data->type == "rec") {
                        return "ใบเสร็จรับเงิน/เบิกสินค้า";
                    } else {
                        return "ใบฝากสินค้า";
                    }
                }
            ],
            'void_id',
            [// the owner name of the model
                'label' => 'สถานะ',
                'value' => function ($data) {
                    if ($data->status == "request") {
                        return "รออนุมัติ";
                    } else  if ($data->status == "reject"){
                        return "ยกเลิก";
                    } else  if ($data->status == "approve"){
                        return "อนุมัติ";
                    }
                }
            ],
            'date_request',
            'date_action',
            'comment:ntext',
        ],
    ])
    ?>

</div>
