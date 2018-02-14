<?php
/**
 * error.php
 *
 * @author Pedro Plowman
 * @copyright Copyright &copy; Pedro Plowman, 2017
 * @link https://github.com/p2made
 * @package p2made/yii2-sb-admin-theme
 * @license MIT
 */

use yii\bootstrap\Html;
use p2m\helpers\FA;
p2m\sbAdmin\assets\SBAdmin2Asset::register($this);
p2m\assets\TimelineAsset::register($this);
p2m\assets\MorrisAsset::register($this);
/* @var $this yii\web\View */
$this->title = $name;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */
?>
<div id="content-wrapper">
	<div class="row">
		<div class="col-lg-6 col-lg-offset-3 col-sm-12">
			<div class="panel panel-red">
				<div class="panel-heading">
					<div class="row">
						<div class="col-md-2">
							<h1><div class="huge"><i class="fa fa-warning"></i></div></h1>
						</div>
						<div class="col-md-10">
							<h3><?= nl2br(Html::encode($message)) ?></h3>
						</div>
					</div>
				</div>
				<div class="panel-body">

					<p><a href='<?= Yii::$app->homeUrl ?>'>กลับหน้าหลัก</a> </p>

					

				</div>
			</div>
		</div>
	</div><!-- /.row -->
</div><!-- /#page-wrapper -->
