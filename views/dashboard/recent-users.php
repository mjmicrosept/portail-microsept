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

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
?>

<?php
$url = Url::to(['recent-users']);
$header = '<tr><th>ID</th>';
$header .= '<th>' . Yii::t('microsept', 'Username') . '</th>';
$header .= '<th>' . Yii::t('microsept', 'Email') . '</th>';
$header .= '<th>' . Yii::t('microsept', 'Created at') . '</th></tr>';
  

         
?>
