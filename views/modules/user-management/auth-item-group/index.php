<?php

use webvimark\modules\UserManagement\components\GhostHtml;
use webvimark\modules\UserManagement\models\rbacDB\AuthItemGroup;
use yii\helpers\Html;
use yii\widgets\Pjax;
use webvimark\extensions\GridPageSize\GridPageSize;

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var webvimark\modules\UserManagement\models\rbacDB\search\AuthItemGroupSearch $searchModel
 */

$this->title = Yii::t('microsept', 'Permission groups');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="auth-item-group-index" style="margin:30px 10px;">

	<?php // echo $this->render('_search', ['model' => $searchModel]); ?>

	<div class="card" style="border:1px solid #acb5bd">
        <div class="card-header bg-secondary" style="border-bottom:1px solid #acb5bd">
            <div class="row">
                <div class="col-sm-6">
                    <h4><?= $this->title ?></h4>
                </div>
                <div class="col-sm-6">
                    <div class="form-inline pull-right" style="float:right;">
                        <?= GridPageSize::widget([
                            'pjaxId'=>'auth-item-group-grid-pjax',
                            'viewFile' => '@app/views/widgets/grid-page-size/index.php',
							'text'=>Yii::t('microsept','Records per page')
                        ]) ?>
                        &nbsp;
                        <?= GhostHtml::a(
                            '<i class="fa fa-plus"></i> ' . Yii::t('microsept', 'Create'),
                            ['create'],
                            ['class' => 'btn btn-success']
                        ) ?>
                    </div>
                </div>
            </div>
        </div>

		<div class="card-body">
			<?php Pjax::begin([
				'id'=>'auth-item-group-grid-pjax',
			]) ?>

			<?= \kartik\grid\GridView::widget([
				'id'=>'auth-item-group-grid',
				'dataProvider' => $dataProvider,
				'pager'=>[
					'options'=>['class'=>'pagination pagination-sm'],
					'hideOnSinglePage'=>true,
					'lastPageLabel'=>'>>',
					'firstPageLabel'=>'<<',
				],
				'layout'=>'{items}<div class="row"><div class="col-sm-8">{pager}</div><div class="col-sm-4 text-right">{summary}</div></div>',
				'filterModel' => $searchModel,
				'columns' => [
					['class' => 'yii\grid\SerialColumn', 'options'=>['style'=>'width:10px'] ],

					[
						'attribute'=>'name',
						'value'=>function($model){
								return Html::a($model->name, ['update', 'id'=>$model->code], ['data-pjax'=>0]);
							},
						'format'=>'raw',
						'label'=>Yii::t('microsept','Name')
					],
					'code',

					['class' => 'yii\grid\CheckboxColumn', 'options'=>['style'=>'width:10px'] ],
                    ['class' => '\kartik\grid\ActionColumn',
                        'template' => '{view} {update} {delete}',
                        'noWrap' => true,
                        'vAlign'=>'middle',
                        'buttons' => [
                            //update button
                            'update' => function ($url,AuthItemGroup $model) {
                                return Html::a('<span class="fa fa-pencil-alt"></span>', $url, [
                                    'title' => Yii::t('app','Update'),
                                    'data-method' => 'post',
                                ]);
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
