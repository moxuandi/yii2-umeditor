<?php
namespace moxuandi\umeditor;

use yii\web\AssetBundle;

/**
 * Asset bundle for the UMeditor.
 *
 * @author  zhangmoxuan <1104984259@qq.com>
 * @link  http://www.zhangmoxuan.com
 * @QQ  1104984259
 * @Date  2018/6/18
 */
class UMeditorAsset extends AssetBundle
{
    public $sourcePath = '@vendor/moxuandi/yii2-umeditor/assets';

    public $css = [
        'themes/default/css/umeditor.min.css',
    ];

    public $js = [
        'third-party/template.min.js',
        'umeditor.config.js',
        'umeditor.min.js',
    ];

    public $depends = [
        'yii\web\JqueryAsset',
    ];
}
