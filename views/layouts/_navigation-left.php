<?php
/**
 * navigation-left.php
 *
 * @author Pedro Plowman
 * @copyright Copyright &copy; Pedro Plowman, 2017
 * @link https://github.com/p2made
 * @package p2made/yii2-sb-admin-theme
 * @license MIT
 */

use yii\bootstrap\Html;
use yii\helpers\Url;

use p2m\widgets\MetisNav;
use p2m\helpers\FA;

$arrowIcon = FA::i('arrow')->tag('span');
?>
<section class="navbar-default sidebar" role="navigation">
	<div class="sidebar-nav navbar-collapse">
		<ul class="nav" id="side-menu">
			<li class="sidebar-search">
				
			</li>
			<li><?= Html::a(
				FA::fw('dashboard') . ' หน้าหลัก',
				Yii::$app->homeUrl
			) ?></li><!-- Dashboard -->
                        <li><?= Html::a(
				FA::fw('list') . 'รายการฝาก',
				Url::to(['/deposits'])
			) ?></li>
                        <li><?= Html::a(
				FA::fw('download') . 'ใบเสร็จรับเงิน/เบิกสินค้า',
				Url::to(['/withdraw'])
			) ?></li>
                        <li><?= Html::a(
				FA::fw('users') . 'รายชื่อลูกค้า',
				Url::to(['/customers'])
			) ?></li>
			
			 <li><?= Html::a(
				FA::fw('remove') . 'ยกเลิกรายการ',
				Url::to(['/void'])
			) ?></li>
                          <li><?= Html::a(
				FA::fw('bar-chart-o') . 'รายงาน',
				Url::to(['/reports'])
			) ?></li>
                        <?php if(Yii::$app->user->identity->role == 'Admin'){ ?>
                        <li>
				<a href="#"><?= FA::fw('user') ?> ผู้ดูแลระบบ<?= $arrowIcon ?></a>
				<?= MetisNav::widget([
					'encodeLabels' => false,
					'options' => ['class' => 'nav nav-second-level'],
					'items' => [
                                                ['label' => 'ผู้ใช้งาน', 'url' => ['/users/']],
                                                ['label' => 'ข้อมูลองค์กร', 'url' => ['/info/update/1']],
                                                ['label' => 'รายงาน', 'url' => ['/reports']],
                                                ['label' => 'รายการสินค้า', 'url' => ['/products/']],
                                                ['label' => 'หน่วยนับ', 'url' => ['/units/']],
					],
				//array('label'=>'About', 'url'=>array('/site/page', 'view'=>'about')),
				]) ?>
			</li><!-- Products -->
                        <?php } ?>
                        <li>
                            <?= Html::a('ออกจากระบบ', ['site/logout'], ['data-method' => 'post'],['linkOptions' => ['data-method' => 'post']]) ?>
                        </li><!-- Logout -->
		</ul>
	</div>
</section>
