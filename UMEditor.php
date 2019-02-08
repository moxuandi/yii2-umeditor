<?php
namespace moxuandi\umeditor;

use Yii;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\widgets\InputWidget;

/**
 * UMEditor renders a editor js plugin for classic editing.
 *
 * @author zhangmoxuan <1104984259@qq.com>
 * @link http://www.zhangmoxuan.com
 * @QQ 1104984259
 * @Date 2019-2-8
 * @see http://ueditor.baidu.com/website/umeditor.html
 */
class UMEditor extends InputWidget
{
    /**
     * @var array 配置接口, 参阅 UMeditor 官方文档(http://fex.baidu.com/ueditor/#start-toolbar)
     * @see assets/umeditor.config.js
     */
    public $editorOptions = [];


    public function init()
    {
        parent::init();
        $this->hasModel() ? $this->id = $this->options['id'] : $this->id = $this->options['id'] = $this->id . '_' . $this->name;
        $this->editorOptions = array_merge([
            'imageUrl' => Url::to(['UmeUpload']),
            'imagePath' => '',
            'initialFrameWidth' => 1000,
            'initialFrameHeight' => 320,
            'lang' => strtolower(Yii::$app->language) == 'en-us' ? 'en' : 'zh-cn'
        ], $this->editorOptions);
    }

    /**
     * 渲染输入域
     * @return string
     */
    public function run()
    {
        self::registerScript();
        return $this->hasModel() ? Html::activeTextarea($this->model, $this->attribute, $this->options) : Html::textarea($this->name, $this->value, $this->options);
    }

    /**
     * 注册客户端脚本
     */
    private function registerScript()
    {
        UMEditorAsset::register($this->view);
        $editorOptions = Json::encode($this->editorOptions);
        $this->view->registerJs("UM.getEditor('{$this->id}', $editorOptions);");
    }
}
