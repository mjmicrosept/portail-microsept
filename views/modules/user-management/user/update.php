<?php


/**
 * @var yii\web\View $this
 * @var webvimark\modules\UserManagement\models\User $model
 */

$this->title = Yii::t('microsept', 'Editing user') . ' : ' . $model->username;
$this->params['breadcrumbs'][] = ['label' => Yii::t('microsept', 'Users'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->username, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('microsept', 'Editing');
?>
<div class="user-update" style="margin:30px 10px;">

	<div class="card" style="border:1px solid #acb5bd">
		<div class="card-header bg-secondary" style="border-bottom:1px solid #acb5bd">
            <h4><?= $this->title ?></h4>
		</div>

		<div class="card-body">
			<?php
                echo $this->render('_form', ['model'=>$model,'id'=>$id,'assignment'=>$assignment]);
			?>
		</div>
	</div>

</div>