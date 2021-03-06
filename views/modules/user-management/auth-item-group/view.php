<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/**
 * @var yii\web\View $this
 * @var webvimark\modules\UserManagement\models\rbacDB\AuthItemGroup $model
 */

$this->title = Yii::t('microsept','Permission group'). ' : ' .$model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('microsept', 'Permission groups'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="auth-item-group-view" style="margin:30px 10px;">

	<div class="card" style="border:1px solid #acb5bd">
        <div class="card-header bg-secondary" style="border-bottom:1px solid #acb5bd">
            <h4><?= $this->title ?></h4>
        </div>
		<div class="card-body">

			<p>
				<?= Html::a(Yii::t('microsept', 'Edit'), ['update', 'id' => $model->code], ['class' => 'btn btn-sm btn-primary']) ?>
				<?= Html::a(Yii::t('microsept', 'Create'), ['create'], ['class' => 'btn btn-sm btn-success']) ?>
				<?= Html::a(Yii::t('yii', 'Delete'), ['delete', 'id' => $model->code], [
					'class' => 'btn btn-sm btn-danger pull-right',
                    'style'=>'float:right;',
					'data' => [
						'confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
						'method' => 'post',
					],
				]) ?>
			</p>

			<?= DetailView::widget([
				'model' => $model,
				'attributes' => [
					[
						'attribute'=>'name',
						'value'=>$model->name,
						'label'=>Yii::t('microsept','Name'),
					],
					[
						'attribute'=>'code',
						'value'=>$model->code,
						'label'=>Yii::t('microsept','Code'),
					],
					[
						'attribute'=>'created_at',
						'value'=>date('d/m/Y h:i', $model->created_at),
						'label'=>Yii::t('microsept','created_at'),
					],
					[
						'attribute'=>'updated_at',
						'value'=>date('d/m/Y h:i', $model->updated_at),
						'label'=>Yii::t('microsept','updated_at'),
					],
				],
			]) ?>

		</div>
	</div>
</div>
