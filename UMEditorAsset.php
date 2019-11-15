<?php
namespace moxuandi\umeditor;

use yii\web\AssetBundle;

/**
 * Asset bundle for the UMEditor.
 *
 * @author zhangmoxuan <1104984259@qq.com>
 * @link http://www.zhangmoxuan.com
 * @QQ 1104984259
 * @Date 2019-2-8
 */
class UMEditorAsset extends AssetBundle
{
    public $sourcePath = '@vendor/moxuandi/yii2-umeditor/assets';
    public $css = [
        'dist/themes/default/css/umeditor.min.css',
    ];
    public $js = [
        'dist/umeditor.config.js',
        'dist/umeditor.min.js',
    ];
    public $depends = [
        'yii\web\JqueryAsset',
    ];
}
