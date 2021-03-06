<?php
/**
 * @var yii\widgets\ActiveForm $form
 * @var array $childRoles
 * @var array $allRoles
 * @var array $routes
 * @var array $currentRoutes
 * @var array $permissionsByGroup
 * @var array $currentPermissions
 * @var yii\rbac\Role $role
 */

use webvimark\modules\UserManagement\components\GhostHtml;
use webvimark\modules\UserManagement\models\rbacDB\Role;
use webvimark\modules\UserManagement\UserManagementModule;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

$this->title = Yii::t('microsept', 'Permissions for role') . ' : '. $role->description;
$this->params['breadcrumbs'][] = ['label' => Yii::t('microsept', 'Roles'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="role-view" style="margin:30px 10px;">
    <h2 class="lte-hide-title"><?= $this->title ?></h2>

    <p>
        <?= GhostHtml::a(Yii::t('microsept', 'Edit'), ['update', 'id' => $role->name], ['class' => 'btn btn-sm btn-primary']) ?>
        <?= GhostHtml::a(Yii::t('microsept', 'Create'), ['create'], ['class' => 'btn btn-sm btn-success']) ?>
    </p>

    <div class="row">
        <div class="col-sm-4">
            <div class="card" style="border:1px solid #acb5bd">
                <div class="card-header bg-secondary" style="border-bottom:1px solid #acb5bd">
                    <strong>
                        <span class="fas fa-th"></span> <?= Yii::t('microsept', 'Child roles') ?>
                    </strong>
                </div>
                <div class="card-body">
                    <?= Html::beginForm(['set-child-roles', 'id'=>$role->name]) ?>

                    <?= Html::checkboxList(
                        'child_roles',
                        ArrayHelper::map($childRoles, 'name', 'name'),
                        ArrayHelper::map($allRoles, 'name', 'description'),
                        [
                            'item'=>function ($index, $label, $name, $checked, $value) {
                                    $list = '<ul style="padding-left: 10px">';
                                    foreach (Role::getPermissionsByRole($value) as $permissionName => $permissionDescription)
                                    {
                                        $list .= $permissionDescription ? "<li>{$permissionDescription}</li>" : "<li>{$permissionName}</li>";
                                    }
                                    $list .= '</ul>';

                                    $helpIcon = Html::beginTag('span', [
                                        'title'        => Yii::t('microsept', 'Permissions for role') . ' - ' .$label,
                                        'data-content' => $list,
                                        'data-html'    => 'true',
                                        'role'         => 'button',
                                        'style'        => 'margin-bottom: 5px; padding: 0 5px',
                                        'class'        => 'btn btn-sm btn-default role-help-btn',
                                    ]);
                                    $helpIcon .= '?';
                                    $helpIcon .= Html::endTag('span');

                                    $isChecked = $checked ? 'checked' : '';
                                    $checkbox = "<label><input type='checkbox' name='{$name}' value='{$value}' {$isChecked}> {$label}</label>";

                                    return $helpIcon . ' ' . $checkbox;
                                },
                            'separator'=>'<br>'
                        ]
                    ) ?>

                    <hr/>
                    <?= Html::submitButton(
                        '<span class="glyphicon glyphicon-ok"></span> ' . Yii::t('microsept', 'Save'),
                        ['class'=>'btn btn-primary btn-sm']
                    ) ?>

                    <?= Html::endForm() ?>
                </div>
            </div>
        </div>

        <div class="col-sm-8">
            <div class="card" style="border:1px solid #acb5bd">
                <div class="card-header bg-secondary" style="border-bottom:1px solid #acb5bd">
                    <strong>
                        <span class="fas fa-th"></span> <?= Yii::t('microsept', 'Permissions') ?>
                    </strong>
                </div>
                <div class="card-body">
                    <?= Html::beginForm(['set-child-permissions', 'id'=>$role->name]) ?>

                    <div class="row">
                        <?php foreach ($permissionsByGroup as $groupName => $permissions): ?>
                            <div class="col-sm-6">
                                <fieldset>
                                    <legend><?= $groupName ?></legend>

                                    <?= Html::checkboxList(
                                        'child_permissions',
                                        ArrayHelper::map($currentPermissions, 'name', 'name'),
                                        ArrayHelper::map($permissions, 'name', 'description'),
                                        ['separator'=>'<br>']
                                    ) ?>
                                </fieldset>
                                <br/>
                            </div>


                        <?php endforeach ?>
                    </div>

                    <hr/>
                    <?= Html::submitButton(
                        '<span class="glyphicon glyphicon-ok"></span> ' . Yii::t('microsept', 'Save'),
                        ['class'=>'btn btn-primary btn-sm']
                    ) ?>

                    <?= Html::endForm() ?>

                </div>
            </div>
        </div>
    </div>
</div>
<?php
$this->registerJs(<<<JS

$('.role-help-btn').off('mouseover mouseleave')
	.on('mouseover', function(){
		var _t = $(this);
		_t.popover('show');
	}).on('mouseleave', function(){
		var _t = $(this);
		_t.popover('hide');
	});
JS
);
?>