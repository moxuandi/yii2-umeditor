[百度编辑器mini版 UMeditor for Yii2](http://ueditor.baidu.com/website/umeditor.html)
================
UMeditor，简称UM,是为满足广大门户网站对于简单发帖框，或者回复框需求所定制的在线富文本编辑器。
UM的主要特点就是容量和加载速度上的改变，主文件的代码量为139k，而且放弃了使用传统的iframe模式，采用了div的加载方式，以达到更快的加载速度和零加载失败率。
现在UM的第一个使用者是百度贴吧，贴吧每天几亿的pv是对UM各种指标的最好测试平台。
当然随着代码的减少，UM的功能对于UE来说还是有所减少，但我们经过调研和大家对于UM提出的各种意见，提供了现在UM的功能版本，虽然有删减，但也有增加，比如拖拽图片上传，chrome的图片拖动改变大小等。让UM能在功能和体积上达到一个平衡。
UM还会提供 CDN方式，减少大家部署的成本。我们的目标不仅是要提高在线编辑的编辑体验，也希望能改变前端技术中关于富文本技术的门槛，让大家不再觉得这块是个大坑。


安装:
------------
使用 [composer](http://getcomposer.org/download/) 下载:
```
# 2.2.x(yii >= 2.0.24):
composer require moxuandi/yii2-umeditor:"~2.2.0"

# 2.x(yii >= 2.0.16):
composer require moxuandi/yii2-umeditor:"~2.1.0"
composer require moxuandi/yii2-umeditor:"~2.0.0"

# 1.x(非重要Bug, 不再更新):
composer require moxuandi/yii2-umeditor:"~1.0"

# 旧版归档(不再更新):
composer require moxuandi/yii2-umeditor:"~0.1"

# 开发版:
composer require moxuandi/yii2-umeditor:"dev-master"
```


使用:
-----
在`Controller`中添加:
```php
public function actions()
{
    return [
        'UmeUpload' => [
            'class' => 'moxuandi\umeditor\UploaderAction',
            // 可选参数, 参考 UploaderAction::$_config
            'config' => [
                'maxSize' => 1*1024*1024,  // 上传大小限制, 单位B, 默认1MB, 注意修改服务器的大小限制
                'allowFiles' => ['.png', '.jpg', '.jpeg', '.gif', '.bmp'],  // 允许上传的文件类型
                'pathFormat' => '/uploads/image/{yyyy}{mm}{dd}/{hh}{ii}{ss}_{rand:6}',  // 文件保存路径

                // 图片上传根目录, 配合`views`中的`$imagePath`使用
                'rootPath' => dirname(Yii::$app->request->scriptFile),
                'rootUrl' => Yii::$app->request->hostInfo,
            ],
        ],
    ];
}
```

在`View`中添加:
```php
1. 简单调用:
$form->field($model, 'content')->widget('moxuandi\umeditor\UMEditor');

2. 带参数调用:
$form->field($model, 'content')->widget('moxuandi\umeditor\UMEditor', [
    'editorOptions' => [
        // 编辑区域的大小
        'initialFrameWidth' => '100%',
        'initialFrameHeight' => 400,

        // 图片修正地址, 配合`actions`中的`$rootPath`使用
        //'imagePath' => 'http://image.yii2advanced.com',

        // 定制菜单
        'toolbar' => ['undo redo | bold italic underline'],
    ]
]);

3. 不带 $model 调用:
\moxuandi\umeditor\UMEditor::widget([
    'name' => 'content',
    'editorOptions' => [
        'initialFrameWidth' => '100%',
    ]
]);
```

编辑器相关配置, 请在视图`view`中配置, 参数为`editorOptions`, 比如定制菜单, 编辑器大小, 语言等等, 具体参数请查看[umeditor.config.js](https://github.com/moxuandi/yii2-umeditor/blob/master/assets/umeditor.config.js).

文件上传相关配置, 请在控制器`controller`中配置, 参数为`config`, 例如文件上传路径等.

另可配置缩略图,裁剪图,水印等, 对图片做进一步处理; 详细配置请参考[moxuandi\helpers\Uploader](https://github.com/moxuandi/yii2-helpers)
```php
'config' => [
    // 缩略图
    'thumb' => [
        'width' => 300,
        'height' => 200,
        //'mode' => 'outbound',  // 'inset'(补白), 'outbound'(裁剪, 默认值)
        //'match' => ['image', 'thumb'],
    ],

    // 裁剪图像
    'crop' => [
        'width' => 300,
        'height' => 200,
        //'top' => 0,
        //'left' => 0,
        //'match' => ['image', 'crop'],
    ],

    // 添加边框
    'frame' => [
        'margin' => 20,
        //'color' => '666',
        //'alpha' => 100,
        //'match' => ['image', 'frame'],
    ],

    // 添加图片水印
    'watermark' => [
        'watermarkImage' => '@web/uploads/watermark.png',
        //'top' => 0,
        //'left' => 0,
        //'match' => ['image', 'watermark'],
    ],

    // 添加文字水印
    'text' => [
        'text' => '水印文字',
        'fontFile' => '@web/uploads/simhei.ttf',  // 字体文件的位置
        /*'fontOptions' => [
            'size' => 12,
            'color' => 'fff',
            'angle' => 0,
        ],*/
        //'top' => 0,
        //'left' => 0,
        //'match' => ['image', 'text'],
    ],

    // 调整图片大小
    'resize' => [
        'width' => 300,
        'height' => 200,
        //'keepAspectRatio' => true,  // 是否保持图片纵横比
        //'allowUpscaling' => false,  // 如果原图很小, 图片是否放大
        //'match' => ['image', 'resize'],
    ],
],
```
