<?php
/**
 * KM Websolutions Projects
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2010 KM Websolutions
 * @license http://www.yiiframework.com/license/
 */

use yii\helpers\Url;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$js = <<<JS
   $('.pjax-box').each(function(){
      var id = '#' + $(this).attr('id');
      var url = $(this).data('url');
      $(id).load(url);
   });
   
   $.pjax.defaults.timeout = 3000;
    
   $(".pjax-box").on('pjax:send', function() {
      var overlay = $('<div class="overlay"><div class="fa fa-refresh fa-spin"></div></div>');
      var b = $(this).find('.box').append(overlay);
 
   });
   $(".pjax-box").on('pjax:complete', function() {
      $('.box').find('.overlay').remove(); 
   });
JS;

$this->registerJs($js);
?>

<div class="row">
    <div class="col-md-6 main-col-left">
         <?php
        Pjax::begin(['id' => 'recentUsers',
            'enablePushState' => false,
            'options' => ['class' => 'pjax-box', 'data-url' => Url::to(['recent-users'])],
        ]);
        ?>
        <?php Pjax::end(); ?>
    </div>
    <div class="col-md-6 main-col-right">
     
    </div>
</div>

