<?php
/**
 * @var yii\widgets\ActiveForm $form
 * @var webvimark\modules\UserManagement\models\rbacDB\Role $model
 */
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use kartik\builder\FormAsset;
use app\assets\views\KartikCommonAsset;

FormAsset::register($this);
KartikCommonAsset::register($this);

$this->registerCss(<<<CSS
    .form-group{
        display:flex;
    }
    .control-label{
        padding-top: 7px;
        margin-bottom: 0;
        text-align: right;
    }
    .col-sm-offset-3 {
        margin-left: 25%;
    }
CSS
);

?>

<?php $form = ActiveForm::begin([
	'id'             => 'role-form',
	'layout'         => 'horizontal',
	'validateOnBlur' => false,
]) ?>

	<?= $form->field($model, 'description')->textInput(['maxlength' => 255, 'autofocus'=>$model->isNewRecord ? true:false]) ?>

	<?= $form->field($model, 'name')->textInput(['maxlength' => 64]) ?>


	<div class="form-group">
		<div class="col-sm-offset-3 col-sm-9">
			<?php if ( $model->isNewRecord ): ?>
				<?= Html::submitButton(
					'<span class="fas fa-plus-circle"></span> ' . Yii::t('microsept', 'Create'),
					['class' => 'btn btn-success']
				) ?>
			<?php else: ?>
				<?= Html::submitButton(
					'<span class="fas fa-check"></span> ' . Yii::t('microsept', 'Save'),
					['class' => 'btn btn-primary']
				) ?>
			<?php endif; ?>
		</div>
	</div>
<?php ActiveForm::end() ?>