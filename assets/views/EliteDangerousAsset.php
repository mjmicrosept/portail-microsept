<?php
/**
 * Created by PhpStorm.
 * User: JMaratier
 * Date: 27/02/2019
 * Time: 08:59
 */

namespace app\assets\views;

use yii\web\AssetBundle;

class EliteDangerousAsset extends AssetBundle
{
    public $sourcePath = '@app/assets/web';
    public $css = [
        'css/elite-dangerous.css',
    ];
    public $js = [

    ];
    public $depends = [
    ];
}