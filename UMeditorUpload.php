<?php
namespace moxuandi\umeditor;

use Yii;
use yii\base\Action;
use yii\helpers\Json;
use moxuandi\helpers\Uploader;

/**
 * UMeditor 接收上传图片控制器.
 *
 * @author  zhangmoxuan <1104984259@qq.com>
 * @link  http://www.zhangmoxuan.com
 * @QQ  1104984259
 * @Date  2018/6/18
 */
class UMeditorUpload extends Action
{
    /**
     * @var array 上传配置接口
     */
    public $config = [];


    public function init()
    {
        parent::init();
        Yii::$app->request->enableCsrfValidation = false;  // 关闭csrf
        $_config = [
            'maxSize' => 1*1024*1024,  // 上传大小限制, 单位B, 默认1MB, 注意修改服务器的大小限制
            'allowFiles' => ['.png', '.jpg', '.jpeg', '.gif', '.bmp'],  // 允许上传的文件类型
            'pathFormat' => '/uploads/image/{yyyy}{mm}/{yy}{mm}{dd}_{hh}{ii}{ss}_{rand:4}',  // 文件保存路径
            'thumbStatus' => false,  // 是否生成缩略图
            'thumbWidth' => 300,  // 缩略图的宽度
            'thumbHeight' => 200,  // 缩略图的高度
            'thumbMode' => 'outbound',  // 生成缩略图的模式, 可用值: 'inset'(补白), 'outbound'(裁剪, 默认值).
        ];
        $this->config = array_merge($_config, $this->config);
    }

    public function run()
    {
        // 生成上传实例对象并完成上传
        $upload = new Uploader('upfile', $this->config);
        $info = [
            'originalName' => $upload->realName,  // 原始文件名, eg: 'img_6.jpg'
            'name' => $upload->fileName,           // 新文件名, eg: '171210_054500_8166.jpg'
            'url' => $upload->fullName,            // 返回的 URL 地址, eg: '/uploads/image/201712/171210_054500_8166.jpg'
            'size' => $upload->fileSize,           // 文件大小, eg: 108527
            'type' => '.' . $upload->fileExt,      // 文件类型, eg: '.jpg'
            'state' => $upload->stateInfo,         // 上传状态, 上传成功时必须返回'SUCCESS'
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