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
class MaskingAsset extends AssetBundle
{
    public $sourcePath = '@vendor/igorescobar/jquery-mask-plugin/dist';
    public $js = [
        'jquery.mask.js',
    ];
}

