<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use app\models\User;
use kartik\builder\FormAsset;
use app\assets\views\KartikCommonAsset;


/**
 * @var yii\web\View $this
 * @var webvimark\modules\UserManagement\models\User $model
 * @var yii\bootstrap\ActiveForm $form
 */

FormAsset::register($this);
KartikCommonAsset::register($this);

$baseUrl = Yii::$app->request->baseUrl;

$iduser = 0;
$assign = '';
$permissionradio = 0;

if(Yii::$app->user->isSuperadmin) {
    $permissionradio = 1;
}

if(isset($id)) {
    $iduser = $id;
    if(isset($assignment))
        $assign = $assignment;
}

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

<div class="user-form">

    <?php $form = ActiveForm::begin([
        'id'=>'user',
        'layout'=>'horizontal',
        'validateOnBlur' => false,
    ]); ?>

	<?= $form->field($model->loadDefaultValues(), 'status')
		->dropDownList(User::getStatusList()) ?>

	<?= $form->field($model, 'username')->textInput(['maxlength' => 255, 'autocomplete'=>'off']) ?>

	<?php if ( $model->isNewRecord ): ?>

		<?= $form->field($model, 'password')->passwordInput(['maxlength' => 255, 'autocomplete'=>'off']) ?>

		<?= $form->field($model, 'repeat_password')->passwordInput(['maxlength' => 255, 'autocomplete'=>'off']) ?>
	<?php endif; ?>

	<?php if ( User::hasPermission('editUserEmail') ): ?>

		<?= $form->field($model, 'email')->textInput(['maxlength' => 255]) ?>

	<?php endif; ?>

    <div class="form-group field-user-check-permissions">
        <label class="control-label col-sm-3"><?= Yii::t('microsept', 'Profil') ?></label>
        <div class="col-sm-6">
            <div class="radio">
                <label>
                    <input type="radio" name="radioPermission" id="radioPermissionRespCommercial" class="radioPermission" value="<?= Yii::$app->params['roleRespCommercial'] ?>" >
                    <?= Yii::t('microsept','Resp_Commercial') ?>
                </label>
            </div>
            <div class="radio">
                <label>
                    <input type="radio" name="radioPermission" id="radioPermissionCommercial" class="radioPermission" value="<?= Yii::$app->params['roleCommercial'] ?>" >
                    <?= Yii::t('microsept','Commercial') ?>
                </label>
            </div>
            <div class="radio">
                <label>
                    <input type="radio" name="radioPermission" id="radioPermissionRespFormation" class="radioPermission" value="<?= Yii::$app->params['roleRespFormation'] ?>" >
                    <?= Yii::t('microsept','Resp_Formation') ?>
                </label>
            </div>
            <div class="radio">
                <label>
                    <input type="radio" name="radioPermission" id="radioPermissionFormation" class="radioPermission" value="<?= Yii::$app->params['roleFormation'] ?>" >
                    <?= Yii::t('microsept','Formation') ?>
                </label>
            </div>
            <div class="radio">
                <label>
                    <input type="radio" name="radioPermission" id="radioPermissionAdv" class="radioPermission" value="<?= Yii::$app->params['roleAdv'] ?>" >
                    <?= Yii::t('microsept','Adv') ?>
                </label>
            </div>
            <div class="radio">
                <label>
                    <input type="radio" name="radioPermission" id="radioPermissionPrelevement" class="radioPermission" value="<?= Yii::$app->params['rolePrelevement'] ?>" >
                    <?= Yii::t('microsept','Prelevement') ?>
                </label>
            </div>
        </div>
    </div>

	<div class="form-group">
		<div class="col-sm-offset-3 col-sm-9">
			<?php if ( $model->isNewRecord ): ?>
				<?= Html::submitButton(
					'<span class="fas fa-plus-circle"></span> ' . Yii::t('microsept',isset($clientId)? 'Suivant' : 'Create'),
					['class' => 'btn btn-success']
				) ?>
			<?php else: ?>
				<?= Html::submitButton(
					'<span class="fas fa-check"></span> ' . Yii::t('microsept', 'Save'),
					['class' => 'btn btn-primary btn-validate']
				) ?>
			<?php endif; ?>
		</div>
	</div>

	<?php ActiveForm::end(); ?>

</div>


<?php

$this->registerJs(<<<JS
    //actions au chargement de la page en cas d'update
	if({$iduser} != 0){
        $("input:radio").each(function(){
            if($(this).val() == '$assign')
                $(this).prop('checked',true);
        });
	}
	else{

	}
	
	//Event du click sur les boutons radio des droits utilisateurs
    $('.radioPermission').click(function(){
        var id = $(this).attr('id');
        if($permissionradio == 1){
            switch(id){
                case 'radioPermissionPortailAdmin' :

                    break;
                case 'radioPermissionLaboAdmin':

                    break;
                case 'radioPermissionLaboUser' :

                    break;
                case 'radioPermissionClientAdmin' :

                    break;
                case 'radioPermissionClientUserGroup' :

                    break;
                case 'radioPermissionClientUser' :

                    break;
            }
        }
    });


JS
);

?>


