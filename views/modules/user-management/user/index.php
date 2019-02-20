<?php

use webvimark\modules\UserManagement\components\GhostHtml;
use webvimark\modules\UserManagement\models\rbacDB\Role;
use webvimark\modules\UserManagement\models\User;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\widgets\Pjax;
use webvimark\extensions\GridBulkActions\GridBulkActions;
use webvimark\extensions\GridPageSize\GridPageSize;

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var webvimark\modules\UserManagement\models\search\UserSearch $searchModel
 */

$this->title = Yii::t('microsept', 'Users');
$this->params['breadcrumbs'][] = $this->title;


?>
<div class="user-index" style="margin:30px 10px;">

	<div class="card" style="border:1px solid #acb5bd">
		<div class="card-header bg-secondary" style="border-bottom:1px solid #acb5bd">
			<div class="row">
				<div class="col-sm-6">
                    <h4><?= $this->title ?></h4>
				</div>
				<div class="col-sm-6">
                    <div class="form-inline" style="float:right">
                        <?= GridPageSize::widget([
                            'pjaxId'=>'user-grid-pjax',
                            'viewFile' => '@app/views/widgets/grid-page-size/index.php',
							'text'=>Yii::t('microsept','Records per page')
                        ]) ?>
                        &nbsp;
                        <?= GhostHtml::a(
                            '<i class="fa fa-plus"></i> ' . Yii::t('microsept', 'Create'),
                            ['/user-management/user/create'],
                            ['class' => 'btn btn-success']
                        ) ?>
                    </div>
				</div>
			</div>
		</div>

		<div class="card-body">
			<?php Pjax::begin([
				'id'=>'user-grid-pjax',
			]) ?>

			<?= \kartik\grid\GridView::widget([
				'id'=>'user-grid',
				'dataProvider' => $dataProvider,
				'bsVersion' => '4.1.3',
				'pager'=>[
					'options'=>['class'=>'pagination pagination-sm'],
					'hideOnSinglePage'=>true,
					'lastPageLabel'=>'>>',
					'firstPageLabel'=>'<<',
				],
				'filterModel' => $searchModel,
				'layout'=>'{items}<div class="row"><div class="col-sm-8">{pager}</div><div class="col-sm-4 text-right">{summary}'.GridBulkActions::widget([
						'gridId'=>'user-grid',
						'promptText'=>Yii::t('microsept','Modif status'),
						'wrapperClass' => 'form-inline float-right',
						'actions'=>[
							'-----',
							Url::to(['bulk-activate', 'attribute'=>'status'])=>Yii::t('microsept', 'Activate'),
							Url::to(['bulk-deactivate', 'attribute'=>'status'])=>Yii::t('microsept', 'Deactivate'),
						],
					]).'</div></div>',
				'columns' => [
					[
						'class'=>'webvimark\components\StatusColumn',
						'attribute'=>'superadmin',
						'format' => 'raw',
						//'hAlign' => 'center',
						'value' => function($model){
			                if($model->superadmin){
			                    return '<span class="badge badge-success" style="padding:5px 10px;"> Oui </span>';
                            }
                            else{
                                return '<span class="badge badge-warning" style="padding:5px 10px;">Non</span>';
                            }
                        },
						'visible'=>Yii::$app->user->isSuperadmin,
					],

					[
						'attribute'=>'username',
						'value'=>function(User $model){
								return Html::a($model->username,['view', 'id'=>$model->id],['data-pjax'=>0]);
							},
						'format'=>'raw',
					],
					[
						'attribute'=>'email',
						'format'=>'raw',
						'visible'=>User::hasPermission('viewUserEmail'),
                        'value'=>function($model){
			                if(!is_null($model->email))
			                    return $model->email;
			                else
			                    return '';
                        }
					],
					[
						'attribute'=>'gridRoleSearch',
						'filter'=>ArrayHelper::map(Role::getAvailableRoles(Yii::$app->user->isSuperAdmin),'name', 'description'),
						'value'=>function(User $model){
								return implode(', ', ArrayHelper::map($model->roles, 'name', 'description'));
							},
						'format'=>'raw',
						'visible'=>User::hasPermission('viewUserRoles'),
					],
					[
						'value'=>function(User $model){
								return GhostHtml::a(
									Yii::t('microsept', 'Roles and permissions'),
									['/user-management/user-permission/set', 'id'=>$model->id],
									['class'=>'btn btn-sm btn-primary', 'data-pjax'=>0]);
							},
						'format'=>'raw',
						'visible'=>User::canRoute('/user-management/user-permission/set'),
						'options'=>[
							'width'=>'10px',
						],
					],
					[
						'class'=>'webvimark\components\StatusColumn',
						'attribute'=>'status',
                        'format' => 'raw',
                        //'hAlign' => 'center',
                        'value' => function($model){
                            if($model->status){
                                return '<span class="badge badge-success" style="padding:5px 10px;"> Actif </span>';
                            }
                            else{
                                return '<span class="badge badge-warning" style="padding:5px 10px;">Inactif</span>';
                            }
                        },
					],
					['class' => 'yii\grid\CheckboxColumn', 'options'=>['style'=>'width:10px'] ],
					['class' => '\kartik\grid\ActionColumn',
						'template' => '{view} {update} {delete}',
						'noWrap' => true,
						'vAlign'=>'middle',
						'buttons' => [
							//update button
							'update' => function ($url, $model) {
								if($model->superadmin) {
									return '';
								}
								else {
									return Html::a('<span class="fa fa-pencil-alt"></span>', $url, [
										'title' => Yii::t('app','Update'),
										'data-method' => 'post',
									]);
								}
							},
							'delete' => function ($url, $model) {
                                return Html::a('<span class="fa fa-trash-alt"></span>', $url, [
                                    'title' => Yii::t('app','Delete'),
                                    'data-method' => 'post',
                                    'data-confirm' => Yii::t('app', 'Delete user')
                                ]);
                            }
						],
					],
				],
			]); ?>

			<?php Pjax::end() ?>

		</div>
	</div>
</div>
