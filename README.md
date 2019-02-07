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
# 2.x(yii >= 2.0.16):
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
            'class' => 'moxuandi\umeditor\UMeditorAction',
            //可选参数, 参考 UMeditorAction::$_config
            'config' => [
                'thumbWidth' => 150,	// 缩略图宽度
                'thumbHeight' => 100,	// 缩略图高度
                'saveDatabase'=> true,  // 保存上传信息到数据库,
                  // 使用前请导入'database'文件夹中的数据表'upload'和模型类'Upload'
            ],
        ]
    ];
}
```

在`View`中添加:
```php
1. 简单调用:
$form->field($model, 'content')->widget('moxuandi\umeditor\UMeditor');

2. 带参数调用:
$form->field($model, 'content')->widget('moxuandi\umeditor\UMeditor', [
    'clientOptions' => [
        //编辑区域的大小
        'initialFrameWidth' => 920,
        'initialFrameHeight' => 400,
        //定制菜单
        'toolbar' => ['undo redo | bold italic underline'],
    ],
]);

3. 不带 $model 调用:
\moxuandi\umeditor\UMeditor::widget([
    'attribute' => 'content',
    'clientOptions' => [
        'initialFrameWidth' => 920,
    ]
]);
```

编辑器相关配置, 请在`view`中配置, 参数为`clientOptions`, 比如定制菜单, 编辑器大小, 语言等等, 具体参数请查看[umeditor.config.js](https://github.com/moxuandi/yii2-umeditor/blob/master/assets/umeditor.config.js).

文件上传相关配置, 请在`controller`中配置, 参数为`config`, 例如文件上传路径等.

以下实例提供所有配置参数: 
```php
public function actions()
{
  return [
    'UmeUpload' => [
      'class' => 'moxuandi\umeditor\UMeditorAction',
      'config' => [
        'maxSize' => 5*1024*1024,  // 上传大小限制, 单位B, 默认5MB, 注意修改服务器的大小限制
        'allowFiles' => ['.png', '.jpg', '.jpeg', '.gif', '.bmp'],  // 上传图片格式显示
        'thumbStatus' => true,  // 是否生成缩略图
        'thumbWidth' => 300,  // 缩略图宽度
        'thumbHeight' => 200,  // 缩略图高度
        'thumbCut' => 1,  // 生成缩略图的方式, 0:留白, 1:裁剪
        'pathFormat' => 'uploads/image/{yyyy}{mm}/{yy}{mm}{dd}_{hh}{ii}{ss}_{rand:4}',  // 上传保存路径, 可以自定义保存路径和文件名格式
        'saveDatabase' => false,  // // 保存上传信息到数据库, 使用前请导入'database'文件夹中的数据表'upload'和模型类'Upload'
      ],
    ]
  ];
}
```
