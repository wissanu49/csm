<?php

use p2m\helpers\FA;

p2m\sbAdmin\assets\SBAdmin2Asset::register($this);
p2m\assets\TimelineAsset::register($this);
p2m\assets\MorrisAsset::register($this);

$this->title = Yii::$app->name;
/* @var $form yii\bootstrap\ActiveForm */
$js = "$(function(){
    Morris.Bar({
        element: 'morris-bar-chart',
        data: [";
        foreach($summary_report as $data){
            $js .= "{ y : '".$data['month']."' , a : ".$data['val']."},";
        }
$js .= "],
        xkey: 'y',
        ykeys: ['a'],
        labels: ['รายได้'],
        hideHover: 'auto',
        resize: true,
    });
});";


$this->registerJs($js);
?>
<div id="content-wrapper">

    <div class="row">
         <div class="col-lg-3 col-md-6">
            <div class="panel panel-yellow">
                <div class="panel-heading">
                    <strong>รายได้วันนี้</strong>
                    <div class="row">
                        <div class="col-xs-12 text-right">
                            <div style="font-size: 25px;"><?= Yii::$app->formatter->asDecimal($today_income) ?></div>
                            <div>บาท</div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
         <div class="col-lg-3 col-md-6">
            <div class="panel panel-yellow">
                <div class="panel-heading">
                    <strong>รายได้ย้อนหลัง 7 วัน</strong>
                    <div class="row">
                        <div class="col-xs-12 text-right">
                            <div style="font-size: 25px;"><?= Yii::$app->formatter->asDecimal($weekly_income) ?></div>
                            <div>บาท</div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="panel panel-green">
                <div class="panel-heading">
                    <strong>รายได้ประจำเดือน</strong>
                    <div class="row">
                        <div class="col-xs-12 text-right">
                            <div style="font-size: 25px;"><?= Yii::$app->formatter->asDecimal($monthly_income) ?></div>
                            <div>บาท</div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
              
       
         <div class="col-lg-3 col-md-6">
            <div class="panel panel-green">
                <div class="panel-heading">
                    <strong>รายได้เดือนก่อน</strong>
                    <div class="row">
                        <div class="col-xs-12 text-right">
                            <div style="font-size: 25px;"><?= Yii::$app->formatter->asDecimal($lastmonth_income) ?></div>
                            <div>บาท</div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">

            <div class="panel panel-warning">
                <div class="panel-heading">
                    รายงานรายได้ประจำปี <?= date('Y') + 543; ?>
                </div><!-- /.panel-heading -->
                <div class="panel-body">
                    <div id="morris-bar-chart"></div>
                </div><!-- /.panel-body -->
            </div><!-- /.panel -->

        </div>
    </div>

</div><!-- /#content-wrapper -->
