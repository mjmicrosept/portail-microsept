<?php
namespace app\assets\components\BootstrapContextMenu;
/**
 * Created by PhpStorm.
 * User: JMaratier
 * Date: 05/03/2019
 * Time: 15:39
 */

use yii\web\AssetBundle;

class ContextMenuAsset extends AssetBundle
{
    /**
     * @var string the directory that contains the source asset files for this asset bundle.
     * A source asset file is a file that is part of your source code repository of your Web application.
     */
    public $sourcePath = '@app/assets/web';

    /**
     * @var array list of JavaScript files that this bundle contains. Each JavaScript file can be
     * specified in one of the following formats:
     */
    public $js = [
        'js/bootstrap-contextmenu.js',
    ];

    /**
     * @var array list of CSS files that this bundle contains. Each CSS file can be specified
     * in one of the three formats as explained in [[js]].
     */
    public $css = [
        'css/context-menu.css'
    ];
}