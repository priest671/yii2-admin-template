<?php
/**
 * @author Skorobogatko Alexei <skorobogatko.oleksii@gmail.com>
 * @copyright 2016
 * @version $Id$
 * @since 0.2
 */

namespace app\base\actions;

use app\base\Action;
use app\base\Controller;
use app\components\Param;
use app\models\Config;
use app\widgets\ActiveForm;
use app\widgets\Check;
use app\widgets\Tabs;
use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

/**
 * Site settings action.
 *
 * Build a page with site settings.
 * Include in your controller actions following:
 * ```php
 * public function actions() {
 *    return [
 *        ....
 *        'settings' => [
 *            'class' => 'app\base\actions\Settings',
 *        ],
 *        ....
 *    ];
 * }
 * ```
 *
 * @author skoro
 */
class Settings extends Action
{
    
    /**
     * @var string view title.
     */
    public $title;
    
    /**
     * @var array
     */
    public $tabsOptions = [];
    
    /**
     * @var string current active tab.
     */
    protected $_tab;
    
    /**
     * @var array
     */
    protected $_configs = [];
    
    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        if (!$this->title) {
            $this->title = Yii::t('app', 'Site settings');
        }
    }
    
    /**
     * @inheritdoc
     */
    public function run($tab = '')
    {
        $this->controller->getView()->title = $this->title;
        $this->_tab = $tab;
        
        if (Yii::$app->request->isPost) {
            $post = Yii::$app->request->post();
            $section = ArrayHelper::getValue($post, 'section', Param::DEFAULT_SECTION);
            
            /** @var $configs Config[] */
            $configs = Param::getConfigsBySection($section);
            if (Config::loadMultiple($configs, $post)) {
                Config::validateMultiple($configs);
                
                /** @var $config Config */
                foreach ($configs as $config) {
                    $isDirty = $config->getDirtyAttributes(['value']);
                    if (!$config->getErrors() && $isDirty && $config->save(false, ['value'])) {
                        $this->controller->addFlash(
                            Controller::FLASH_SUCCESS,
                            Yii::t('app', '<b>{title}</b> updated.', [
                                'title' => $config->title,
                            ])
                        );
                    }
                }
                
                $this->_configs[$section] = $configs;
            }
        }
        
        $this->tabsOptions['items'] = $this->renderTabs();
        return $this->controller->renderContent(Tabs::widget($this->tabsOptions));
    }
    
    /**
     * Renders items for Tabs widget.
     * @return string
     */
    protected function renderTabs()
    {
        $tabs = [];
        $sections = Param::getSections();
        foreach ($sections as $section) {
            $tabs[] = [
                'label' => $section,
                'content' => $this->renderSection($section),
                'active' => $this->_tab == $section,
            ];
        }
        return $tabs;
    }
    
    /**
     * Renders tab section content.
     * @param string $section
     * @return string
     */
    protected function renderSection($section)
    {
        $configs = isset($this->_configs[$section]) ?
                $this->_configs[$section] : Param::getConfigsBySection($section);
        
        ob_start();
        ob_implicit_flush(false);
        
        $form = ActiveForm::begin([
            'action' => [$this->id, 'tab' => $section],
            'pjax' => true,
        ]);
        
        echo Html::hiddenInput('section', $section);
        
        foreach ($configs as $config) {
            $desc = Html::encode($config->desc);
            $field = $form->field($config, "[{$config->id}]value", [
                'template' => "{label}{input}<p class='text-muted param-desc'><small>$desc</small></p>{error}",
            ]);
            
            switch ($config->value_type) {
                case 'text':
                case 'url':
                case 'email':
                case 'integer':
                    echo $field->textInput()->label($config->title);
                    break;
                
                case 'switch':
                    echo $field->widget(Check::className(), [
                        'label' => $config->title,
                    ])->label(false);
                    break;
            }
        }
        
        ActiveForm::endWithActions([
            'cancel' => false,
        ]);
        
        return ob_get_clean();
    }
}
