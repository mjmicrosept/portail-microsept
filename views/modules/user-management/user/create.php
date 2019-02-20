<?php


/**
 * @var yii\web\View $this
 * @var webvimark\modules\UserManagement\models\User $model
 */

$this->title = Yii::t('microsept', 'User creation');
$this->params['breadcrumbs'][] = ['label' => Yii::t('microsept', 'Users'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-create" style="margin:30px 10px;">

	<div class="card" style="border:1px solid #acb5bd">
		<div class="card-header bg-secondary" style="border-bottom:1px solid #acb5bd">
            <h4><?= $this->title ?></h4>
		</div>

		<div class="card-body">
			<?= $this->render('_form',['model'=> $model,'idClient'=>$idClient]) ?>
		</div>
	</div>

</div>
