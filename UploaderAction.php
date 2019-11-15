<?php
namespace moxuandi\umeditor;

use Yii;
use yii\base\Action;
use yii\helpers\Json;
use moxuandi\helpers\Uploader;

/**
 * UMEditor 接收上传图片控制器.
 *
 * @author zhangmoxuan <1104984259@qq.com>
 * @link http://www.zhangmoxuan.com
 * @QQ 1104984259
 * @Date 2019-2-8
 */
class UploaderAction extends Action
{
    /**
     * @var array 上传配置信息接口
     */
    public $config = [];


    public function init()
    {
        parent::init();
        Yii::$app->request->enableCsrfValidation = false;  // 关闭csrf
        $_config = [
            'maxSize' => 1*1024*1024,  // 上传大小限制, 单位B, 默认1MB, 注意修改服务器的大小限制
            'allowFiles' => ['.png', '.jpg', '.jpeg', '.gif', '.bmp'],  // 允许上传的文件类型
            'pathFormat' => '/uploads/image/{yyyy}{mm}{dd}/{hh}{ii}{ss}_{rand:6}',  // 文件保存路径

            'rootPath' => dirname(Yii::$app->request->scriptFile),
            'rootUrl' => Yii::$app->request->hostInfo,
        ];
        $this->config = array_merge($_config, $this->config);
    }

    /**
     * @throws yii\base\Exception
     */
    public function run()
    {
        // 生成上传实例对象并完成上传
        $upload = new Uploader('upfile', $this->config);
        $info = [
            'originalName' => $upload->realName,   // 原始文件名, eg: 'img_6.jpg'
            'name' => $upload->fileName,           // 新文件名, eg: '083934_533790.jpg'
            'url' => $upload->fullName,            // 返回的 URL 地址, eg: '/uploads/image/20190208/083934_533790.jpg'
            'size' => $upload->fileSize,           // 文件大小, eg: 108527
            'type' => '.' . $upload->fileExt,      // 文件类型, eg: '.jpg'
            'state' => Uploader::$stateMap[$upload->status],  // 上传状态, 上传成功时必须返回'SUCCESS'
        ];

        // 输出结果
        if($callback = Yii::$app->request->get('callback')){
            echo '<script>' . $callback . '(' . Json::encode($info) . ')</script>';
        }else{
            echo Json::encode($info);
        }
        exit();
    }
}
