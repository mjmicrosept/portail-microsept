<?php
/**
 * Created by PhpStorm.
 * User: JMaratier
 * Date: 05/10/2018
 * Time: 09:49
 */

namespace app\assets\views;
use yii\web\AssetBundle;
/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class LayoutMainAsset extends AssetBundle
{

    public $sourcePath = '@app/assets/web';
    public $css = [
        'css/animate.min.css',
        'css/loader.css',
        'css/404.css',
        'css/bootstrap-toggle.css',
        'css/site.css',
        'css/microsept.css',
    ];

    public $js = [
        'js/bootstrap-toggle.js',
        'js/bootstrap.min.js',
        'js/colors.js',
        //'js/main.js',
        //'js/popovers.js',
        //'js/tooltips.js',
        //'js/widgets.js',
        'js/perfect-scrollbar.min.js',
        'js/coreui.min.js'
    ];
    public $depends = [

    ];
}