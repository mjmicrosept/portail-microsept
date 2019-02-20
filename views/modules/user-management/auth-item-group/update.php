<?php


/**
 * @var yii\web\View $this
 * @var webvimark\modules\UserManagement\models\rbacDB\AuthItemGroup $model
 */

$this->title = Yii::t('microsept', 'Editing permission group') . ': ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('microsept', 'Permission groups'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->code]];
$this->params['breadcrumbs'][] = Yii::t('microsept', 'Editing')
?>
<div class="auth-item-group-update" style="margin:30px 10px;">

	<div class="card" style="border:1px solid #acb5bd">
		<div class="card-header bg-secondary" style="border-bottom:1px solid #acb5bd">
			<h4><?= $this->title ?></h4>
		</div>

		<div class="card-body">
			<?= $this->render('_form', compact('model')) ?>
		</div>
	</div>

</div>
