<?php
use webvimark\extensions\GridPageSize\GridPageSize;
use webvimark\modules\UserManagement\components\GhostHtml;
use webvimark\modules\UserManagement\models\rbacDB\AuthItemGroup;
use webvimark\modules\UserManagement\models\rbacDB\Permission;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\Pjax;

/**
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var webvimark\modules\UserManagement\models\rbacDB\search\PermissionSearch $searchModel
 * @var yii\web\View $this
 */
$this->title = Yii::t('microsept', 'Permissions');
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="permission-index" style="margin:30px 10px;">
    <div class="card" style="border:1px solid #acb5bd">
        <div class="card-header bg-secondary" style="border-bottom:1px solid #acb5bd">
            <div class="row">
                <div class="col-sm-6">
                    <h4><?= $this->title ?></h4>
                </div>
                <div class="col-sm-6">
                    <div class="form-inline pull-right" style="float:right;">
                        <?= GridPageSize::widget([
                            'pjaxId'=>'permission-grid-pjax',
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
                'id'=>'permission-grid-pjax',
            ]) ?>

            <?= \kartik\grid\GridView::widget([
                'id'=>'permission-grid',
                'dataProvider' => $dataProvider,
                'pager'=>[
                    'options'=>['class'=>'pagination pagination-sm'],
                    'hideOnSinglePage'=>true,
                    'lastPageLabel'=>'>>',
                    'firstPageLabel'=>'<<',
                ],
                'filterModel' => $searchModel,
                'layout'=>'{items}<div class="row"><div class="col-sm-8">{pager}</div><div class="col-sm-4 text-right">{summary}</div></div>',
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn', 'options'=>['style'=>'width:10px'] ],

                    [
                        'attribute'=>'description',
                        'value'=>function($model){
                                if ( $model->name == Yii::$app->getModule('user-management')->commonPermissionName )
                                {
                                    return Html::a(
                                        $model->description,
                                        ['view', 'id'=>$model->name],
                                        ['data-pjax'=>0, 'class'=>'label label-primary']
                                    );
                                }
                                else
                                {
                                    return Html::a($model->description, ['view', 'id'=>$model->name], ['data-pjax'=>0]);
                                }
                            },
                        'format'=>'raw',
                    ],
                    'name',
                    [
                        'attribute'=>'group_code',
                        'filter'=>ArrayHelper::map(AuthItemGroup::find()->asArray()->all(), 'code', 'name'),
                        'value'=>function(Permission $model){
                                return $model->group_code ? $model->group->name : '';
                            },
                        'label'=>Yii::t('microsept','group_code')
                    ],
                    ['class' => '\kartik\grid\ActionColumn',
                        'template' => '{view} {update} {delete}',
                        'noWrap' => true,
                        'vAlign'=>'middle',
                        'buttons' => [
                            //update button
                            'update' => function ($url,Permission $model) {
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