<?php
/**
 * Created by PhpStorm.
 * User: JMaratier
 * Date: 12/12/2018
 * Time: 11:12
 */
namespace app\assets\views;
use yii\web\AssetBundle;

class FontAwesomeAsset extends AssetBundle
{

    public $sourcePath = '@vendor/fortawesome';
    public $css = [
        'css/animate.min.css',
        'css/loader.css',
        'css/404.css',
        'css/bootstrap-toggle.css',
        'css/site.css'
    ];
    public $js = [
        'js/bootstrap-toggle.js',
        'js/colors.js',
        'js/main.js',
        'js/popovers.js',
        'js/tooltips.js',
        'js/widgets.js',
    ];
    public $depends = [

    ];
}