<?php
/**
 * KM Websolutions Projects
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2010 KM Websolutions
 * @license http://www.yiiframework.com/license/
 */

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;
use kartik\alert\Alert;
use webvimark\modules\UserManagement\components\GhostHtml;
use webvimark\modules\UserManagement\UserManagementModule;
use app\assets\AppAsset;


AppAsset::register($this);

/**
 * @var yii\web\View $this
 * @var dektrium\user\models\LoginForm $model
 * @var dektrium\user\Module $module
 */
//$this->context->layout = '@app/themes/coreui/views/layouts/blank';
$this->title = Yii::t('microsept', 'Sign in');

$this->registerJS(<<<JS
    $(document.body).addClass('app').addClass('flex-row').addClass('align-items-center').css({'display':'flex','background-color':'#e4e5e6'});
JS
);
?>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <?php $form = ActiveForm::begin([
                'options'=>['autocomplete'=>'off'],
                'validateOnBlur'=>false,
                'fieldConfig' => [
                    'template'=>"{input}\n{error}",
                    'options' => [
                        'tag' => false,
                    ],
                ],
            ]) ?>
            <div class="card-group">
                <div class="card p-4">
                    <div class="card-body">
                        <h1>S'identifier</h1>
                        <p class="text-muted">Connectez-vous à votre compte</p>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="far fa-user"></i>
                                </span>
                            </div>
                            <!--<input class="form-control" type="text" placeholder="Username">-->
                            <?= $form->field($model, 'username')
                                ->textInput(['placeholder'=>$model->getAttributeLabel('username'), 'autocomplete'=>'off','class'=>'form-control']) ?>
                        </div>
                        <div class="input-group mb-4">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="fas fa-unlock-alt"></i>
                                </span>
                            </div>
                            <?= $form->field($model, 'password')
                                ->passwordInput(['placeholder'=>$model->getAttributeLabel('password'), 'autocomplete'=>'off','class'=>'form-control']) ?>
                        </div>
                        <?php if(isset($error) && !is_null($error)) : ?>
                            <?= Alert::widget([
                                'type' => Alert::TYPE_DANGER,
                                'icon' => 'fa fa-ban',
                                'body' => $error
                            ]) ?>
                        <?php endif; ?>
                        <div class="row">
                            <div class="col-6">
                                <!--<button class="btn btn-primary px-4" type="button">Login</button>-->
                                <?= Html::submitButton(
                                    Yii::t('microsept','ToLogin'),
                                    ['class' => 'btn btn-primary px-4']
                                ) ?>
                            </div>
                            <div class="col-6 text-right">
                                <button class="btn btn-link px-0" type="button">Forgot password?</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card text-white bg-primary py-5 d-md-down-none" style="width:44%">
                    <div class="card-body text-center">
                        <div>
                            <h2>Sign up</h2>
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                            <button class="btn btn-primary active mt-3" type="button">Register Now!</button>
                        </div>
                    </div>
                </div>
            </div>
            <?php ActiveForm::end() ?>
        </div>
    </div>
</div>






