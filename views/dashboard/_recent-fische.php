<?php
/**
 * KM Websolutions Projects
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2010 KM Websolutions
 * @license http://www.yiiframework.com/license/
 */

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

use yii\helpers\Url;
use yii\grid\GridView;
use kmergen\widgets\LinkPager;

?>
<?php Yii::beginProfile('GridView') ?>
<div class="card">
    <div class="card-header clearfix">
        <h3 class="float-left"><?= Yii::t('microsept', 'Recent Fische') ?></h3>
        <div class="float-right"><a href="<?= Url::to(['recent-fische']) ?>"><?= Yii::t('microsept', 'Refresh') ?> <i
                        class="fa fa-refresh"></i></a></div>
    </div>
    <div class="card-body">

    </div>
</div>
<?php Yii::endProfile('GridView') ?>