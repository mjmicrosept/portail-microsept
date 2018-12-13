<?php
/**
 * KM Websolutions Projects
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2010 KM Websolutions
 * @license http://www.yiiframework.com/license/
 */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ListView;
use kmergen\widgets\LinkPager;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
?>

<?php
Yii::beginProfile('ListView');
$header = '<th>ID</th>';
$header .= '<th>' . Yii::t('microsept', 'Fische Art') . '</th>';
$header .= '<th>' . Yii::t('microsept', 'Title') . '</th>';
$header .= '<th>' . Yii::t('microsept', 'Created at') . '</th>';
?>
<div class="card">
    <div class="card-header clearfix">
        <h3 class="float-left"><?= Yii::t('microsept', 'Recent Fische ListView') ?></h3>
        <div class="float-right"><a href="<?= Url::to(['recent-fische-listview']) ?>"><?= Yii::t('microsept', 'Refresh') ?> <i
                        class="fa fa-refresh"></i></a></div>
    </div>
    <div class="card-body">

    </div>
</div>
<?php Yii::endProfile('ListView') ?>