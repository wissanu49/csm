<?php
/**
 * login.php
 *
 * @author Pedro Plowman
 * @copyright Copyright &copy; Pedro Plowman, 2017
 * @link https://github.com/p2made
 * @package p2made/yii2-sb-admin-theme
 * @license MIT
 */

use yii\bootstrap\Html;
use yii\bootstrap\ActiveForm;
use p2m\helpers\FA;
use p2m\helpers\BSocial;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

$this->title = 'Cold Storage Managements';

$fieldOptions1 = [
	'options' => ['class' => 'form-group has-feedback', 'autofocus' => 'autofocus'],
	'inputTemplate' => "{input}<i class='glyphicon glyphicon-envelope form-control-feedback'></i>",
];

$fieldOptions2 = [
	'options' => ['class' => 'form-group has-feedback'],
	'inputTemplate' => "{input}<i class='glyphicon glyphicon-lock form-control-feedback'></i>",
];
?>
<div class="sb-box">
	<div class="sb-logo">
		<?= Html::a('Cold Storage Managements', Yii::$app->homeUrl) ?>
	</div>
	<div class="sb-box-body panel panel-default">
		<div class="panel-body">

			<p class="sb-box-msg">เข้าสู่ระบบ</p>

			<?php $form = ActiveForm::begin([
				'id' => 'login-form',
				'enableClientValidation' => false
			]); ?>

				<?= $form
					->field($model, 'username', $fieldOptions1)
					->label(false)
					->textInput(['placeholder' => $model->getAttributeLabel('username')])
				?>

				<?= $form
					->field($model, 'password', $fieldOptions2)
					->label(false)
					->passwordInput(['placeholder' => $model->getAttributeLabel('password')])
				?>

				<div class="row">
					<div class="col-xs-8">
						<?= $form->field($model, 'rememberMe')->checkbox() ?>
					</div>
					<div class="col-xs-4">
						<?= Html::submitButton(' เข้าสู่ระบบ ', [
							'class' => 'btn btn-success btn-block btn-flat',
							'name' => 'login-button'
						]) ?>
					</div>
				</div>

			<?php ActiveForm::end(); ?>


		</div>
	</div>

	
</div>
