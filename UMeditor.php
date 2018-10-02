<?php
namespace moxuandi\umeditor;

use Yii;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\widgets\InputWidget;

/**
 * UMeditor renders a editor js plugin for classic editing.
 *
 * @author  zhangmoxuan <1104984259@qq.com>
 * @link  http://www.zhangmoxuan.com
 * @QQ  1104984259
 * @Date  2018/6/18
 * @see http://ueditor.baidu.com/website/umeditor.html
 */
class UMeditor extends InputWidget
{
    /**
     * @var array 配置接口, 参阅 UMeditor 官方文档(http://fex.baidu.com/ueditor/#start-toolbar)
     * @see assets/umeditor.config.js
     */
    public $editorOptions = [];


    public function init()
    {
        if($this->hasModel()){
            parent::init();
            $this->id = Html::getInputId($this->model, $this->attribute);
        }elseif($this->attribute){
            $this->id .= '_' . $this->attribute;
        }

        $_options = [
            'imageUrl' => Url::to(['UmeUpload']),
            'imagePath' => '',
            'initialFrameWidth' => 1000,
            'initialFrameHeight' => 320,
            'lang' => strtolower(Yii::$app->language) == 'en-us' ? 'en' : 'zh-cn'
        ];
        $this->editorOptions = array_merge($_options, $this->editorOptions);
    }

    public function run()
    {
        self::registerEditorScript();
        if($this->hasModel()){
            return Html::activeTextarea($this->model, $this->attribute, ['id'=>$this->id]);
        }else{
            return Html::textarea(is_null($this->name) ? $this->id : $this->name, $this->value, ['id'=>$this->id]);
        }
    }

    protected function registerEditorScript()
    {
        UMeditorAsset::register($this->view);
        $editorOptions = Json::encode($this->editorOptions);
        $script = "UM.getEditor('{$this->id}', $editorOptions);";
        $this->view->registerJs($script);
    }
}
