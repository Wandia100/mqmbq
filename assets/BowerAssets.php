<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;

/**
 * Main application asset bundle. use;
 *
 * @author Qiang Xue <qiang.xue@gmail.com> <!-- igorescobar\jquery-mask-plugin\src -->
 * @since 2.0
 */
class BowerAssets extends AssetBundle
{
    public $sourcePath = '@bower';
    public $js = [
        //'toastr/toastr.js',
    ];
    public $css = [
        //'toastr/toastr.css',
    ];
}
