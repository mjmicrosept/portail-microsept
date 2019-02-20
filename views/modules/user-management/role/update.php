<?php
/**
 * @var yii\widgets\ActiveForm $form
 * @var webvimark\modules\UserManagement\models\rbacDB\Role $model
 */


$this->title = Yii::t('microsept', 'Editing role') . ' : ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('microsept', 'Roles'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="role-update" style="margin:30px 10px;">
    <div class="card" style="border:1px solid #acb5bd">
        <div class="card-header bg-secondary" style="border-bottom:1px solid #acb5bd">
            <h4><?= $this->title ?></h4>
        </div>

        <div class="card-body">
            <?= $this->render('_form', [
                'model'=>$model,
            ]) ?>
        </div>
    </div>
</div>