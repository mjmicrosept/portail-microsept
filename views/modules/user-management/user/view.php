<?php

use webvimark\modules\UserManagement\components\GhostHtml;
use webvimark\modules\UserManagement\models\rbacDB\Role;
use webvimark\modules\UserManagement\models\User;
use yii\helpers\ArrayHelper;
use yii\widgets\DetailView;

/**
 * @var yii\web\View $this
 * @var webvimark\modules\UserManagement\models\User $model
 */

$this->title = Yii::t('microsept', 'User') . ' : ' .$model->username;
$this->params['breadcrumbs'][] = ['label' => Yii::t('microsept', 'Users'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $model->username;
?>
<div class="user-view" style="margin:30px 10px;">

	<div class="card" style="border:1px solid #acb5bd">
        <div class="card-header bg-secondary" style="border-bottom:1px solid #acb5bd">
            <h4><?= $this->title ?></h4>
        </div>

		<div class="card-body">

		    <p>
			<?= GhostHtml::a(Yii::t('microsept', 'Edit'), ['update', 'id' => $model->id], ['class' => 'btn btn-sm btn-primary']) ?>
			<?= GhostHtml::a(Yii::t('microsept', 'Create'), ['create'], ['class' => 'btn btn-sm btn-success']) ?>
			<?= GhostHtml::a(
				Yii::t('microsept', 'Roles and permissions'),
				['/user-management/user-permission/set', 'id'=>$model->id],
				['class' => 'btn btn-sm btn-outline-secondary']
			) ?>
            <?= GhostHtml::a(
				Yii::t('microsept', 'Change password'),
				['change-password', 'id'=>$model->id],
				['class'=>'btn btn-sm btn-outline-secondary']
            ) ?>

			<?= GhostHtml::a(Yii::t('microsept', 'Delete'), ['delete', 'id' => $model->id], [
			    'class' => 'btn btn-sm btn-danger pull-right',
			    'style'=>'float:right;',
			    'data' => [
				'confirm' => Yii::t('app', 'Delete user'),
				'method' => 'post',
			    ],
			]) ?>
		    </p>

			<?= DetailView::widget([
				'model'      => $model,
				'attributes' => [
					'id',
					[
						'attribute'=>'status',
						'value'=>User::getStatusValue($model->status),
					],
					'username',
					[
						'attribute'=>'email',
						'value'=>$model->email,
						'format'=>'email',
						'visible'=>User::hasPermission('viewUserEmail'),
					],
					[
						'attribute'=>'email_confirmed',
						'value'=>$model->email_confirmed ? "Oui":"Non",
						'visible'=>User::hasPermission('viewUserEmail'),
					],
					[
						'label'=>Yii::t('microsept', 'Roles'),
						'value'=>implode('<br>', ArrayHelper::map(Role::getUserRoles($model->id), 'name', 'description')),
						'visible'=>User::hasPermission('viewUserRoles'),
						'format'=>'raw',
					],
					'created_at:datetime',
					'updated_at:datetime',
				],
			]) ?>

		</div>
	</div>
</div>
