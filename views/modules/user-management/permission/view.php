<?php
/**
 * @var $this yii\web\View
 * @var yii\widgets\ActiveForm $form
 * @var array $routes
 * @var array $childRoutes
 * @var array $permissionsByGroup
 * @var array $childPermissions
 * @var yii\rbac\Permission $item
 */

use webvimark\modules\UserManagement\components\GhostHtml;
use webvimark\modules\UserManagement\UserManagementModule;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

$this->title = Yii::t('microsept', 'Settings for permission') . ' : ' . $item->description;
$this->params['breadcrumbs'][] = ['label' => Yii::t('microsept', 'Permissions'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="role-view" style="margin:30px 10px;">
    <h2 class="lte-hide-title"><?= $this->title ?></h2>

    <p>
        <?= GhostHtml::a(Yii::t('microsept', 'Edit'), ['update', 'id' => $item->name], ['class' => 'btn btn-sm btn-primary']) ?>
        <?= GhostHtml::a(Yii::t('microsept', 'Create'), ['create'], ['class' => 'btn btn-sm btn-success']) ?>
    </p>

    <div class="row">
        <div class="col-sm-6">
            <div class="card" style="border:1px solid #acb5bd">
                <div class="card-header bg-secondary" style="border-bottom:1px solid #acb5bd">
                    <strong>
                        <span class="fas fa-th"></span> <?= Yii::t('microsept', 'Child permissions') ?>
                    </strong>
                </div>
                <div class="card-body">

                    <?= Html::beginForm(['set-child-permissions', 'id'=>$item->name]) ?>

                    <div class="row">
                        <?php foreach ($permissionsByGroup as $groupName => $permissions): ?>
                            <div class="col-sm-6">
                                <fieldset>
                                    <legend><?= $groupName ?></legend>

                                    <?= Html::checkboxList(
                                        'child_permissions',
                                        ArrayHelper::map($childPermissions, 'name', 'name'),
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

        <div class="col-sm-6">
            <div class="card" style="border:1px solid #acb5bd">
                <div class="card-header bg-secondary" style="border-bottom:1px solid #acb5bd">
                    <strong>
                        <span class="fas fa-th"></span> Routes

                        <?= Html::a(
                            Yii::t('microsept','Refresh routes'),
                            ['refresh-routes', 'id'=>$item->name],
                            [
                                'class' => 'btn btn-outline-primary btn-sm pull-right',
                                'style'=>'margin-top:-5px;float:right;',
                            ]
                        ) ?>

                    </strong>
                </div>

                <div class="card-body">

                    <?= Html::beginForm(['set-child-routes', 'id'=>$item->name]) ?>

                    <div class="row">
                        <div class="col-sm-3">
                            <?= Html::submitButton(
                                '<span class="glyphicon glyphicon-ok"></span> ' . Yii::t('microsept', 'Save'),
                                ['class'=>'btn btn-primary btn-sm']
                            ) ?>
                        </div>

                        <div class="col-sm-6">
                            <input id="search-in-routes" autofocus="on" type="text" class="form-control input-sm" placeholder="<?= Yii::t('microsept','Search route') ?>">
                        </div>

                        <div class="col-sm-3 text-right">
                            <span id="show-only-selected-routes" class="btn btn-outline-secondary btn-sm">
                                <i class="fa fa-minus"></i> <?= Yii::t('microsept','Show only selected') ?>
                            </span>
                            <span id="show-all-routes" class="btn btn-outline-secondary btn-sm hide">
                                <i class="fa fa-plus"></i> <?= Yii::t('microsept','Show all') ?>
                            </span>

                        </div>
                    </div>

                    <hr/>

                    <?= Html::checkboxList(
                        'child_routes',
                        ArrayHelper::map($childRoutes, 'name', 'name'),
                        ArrayHelper::map($routes, 'name', 'name'),
                        [
                            'id'=>'routes-list',
                            'separator'=>'<div class="separator"></div>',
                            'item'=>function($index, $label, $name, $checked, $value) {
                                    return Html::checkbox($name, $checked, [
                                        'value' => $value,
                                        'label' => '<span class="route-text">' . $label . '</span>',
                                        'labelOptions'=>['class'=>'route-label'],
                                        'class'=>'route-checkbox',
                                    ]);
                            },
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
    </div>
</div>

<?php
$js = <<<JS

var routeCheckboxes = $('.route-checkbox');
var routeText = $('.route-text');

// For checked routes
var backgroundColor = '#D6FFDE';

function showAllRoutesBack() {
	$('#routes-list').find('.hide').each(function(){
		$(this).removeClass('hide');
	});
}

//Make tree-like structure by padding controllers and actions
routeText.each(function(){
	var _t = $(this);

	var chunks = _t.html().split('/').reverse();
	var margin = chunks.length * 40 - 40;

	if ( chunks[0] == '*' )
	{
		margin -= 40;
	}

	_t.closest('label').css('margin-left', margin);

});

// Highlight selected checkboxes
routeCheckboxes.each(function(){
	var _t = $(this);

	if ( _t.is(':checked') )
	{
		_t.closest('label').css('background', backgroundColor);
	}
});

// Change background on check/uncheck
routeCheckboxes.on('change', function(){
	var _t = $(this);

	if ( _t.is(':checked') )
	{
		_t.closest('label').css('background', backgroundColor);
	}
	else
	{
		_t.closest('label').css('background', 'none');
	}
});


// Hide on not selected routes
$('#show-only-selected-routes').on('click', function(){
	$(this).addClass('hide');
	$('#show-all-routes').removeClass('hide');

	routeCheckboxes.each(function(){
		var _t = $(this);

		if ( ! _t.is(':checked') )
		{
			_t.closest('label').addClass('hide');
			_t.closest('div.separator').addClass('hide');
		}
	});
});

// Show all routes back
$('#show-all-routes').on('click', function(){
	$(this).addClass('hide');
	$('#show-only-selected-routes').removeClass('hide');

	showAllRoutesBack();
});

// Search in routes and hide not matched
$('#search-in-routes').on('change keyup', function(){
	var input = $(this);

	if ( input.val() == '' )
	{
		showAllRoutesBack();
		return;
	}

	routeText.each(function(){
		var _t = $(this);

		if ( _t.html().indexOf(input.val()) > -1 )
		{
			_t.closest('label').removeClass('hide');
			_t.closest('div.separator').removeClass('hide');
		}
		else
		{
			_t.closest('label').addClass('hide');
			_t.closest('div.separator').addClass('hide');
		}
	});
});

JS;

$this->registerJs($js);
?>