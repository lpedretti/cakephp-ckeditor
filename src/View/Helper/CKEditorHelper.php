<?php

namespace AkkaCKEditor\View\Helper;

use Cake\Utility\Hash;
use Cake\View\Helper;
use Cake\View\View;

/**
 * CKEditor Helper
 *
 * @property \Cake\View\Helper $Html
 */
class CKEditorHelper extends Helper
{

    /**
     * @var array
     */
    public $helpers = [
        'Html',
    ];

    /**
     * Default configuration.
     *
     * @var array
     *
     */
    protected $_defaultConfig = [
        'distribution' => 'full',
        'editor_config' => [],
    ];

    /**
     * Merged configuration
     *
     * @var array
     */
    protected $_configs = [];

    /**
     * Local plugins
     *
     * @var String
     */
    protected $_plugins = null;

    /**
     * Form textarea field CKEditor will be displayed on
     *
     * @var String
     */
    protected $_field = null;

    /**
     * Construct
     *
     * @param View $view
     * @param array $config
     */
    public function __construct(View $view, $config = [])
    {
        parent::__construct($view, $config);
        $this->_configs = $this->getConfig();
    }

    /**
     * Loads CKeditor into template
     *
     * @local_plugins => [
     *      'abbr' => [
     *          'location' => '/js/ckeditor/plugins/abbr/',
     *          'file' => 'abbr.js'
     *      ],
     * ]
     *
     * @return string
     */
    public function loadJs(/*$field = 'editor1', $local_plugins = []*/)
    {
        /*$this->_field = $field;

        if (!empty($local_plugins)) {
            $this->__setLocalPlugins();
        }*/

//        return <<<EOT
//            <script src="{$cdn_file}"></script>
//            <script>
//                {$this->_plugins}
//            </script>
//EOT;
        return '<script src="' . $this->jsUrl() . '"></script>';
    }

    /**
     * @param $field
     * @param array $options
     * @return mixed
     */
    public function replace($field, array $options = [])
    {
        return $this->Html->scriptBlock($this->script($field, $options));
    }

    private function __setLocalPlugins()
    {
        $plugins = '';

        foreach ($this->_configs['local_plugin'] as $key => $value) {
            $this->_plugins .= "CKEDITOR.plugins.addExternal( '{$key}', '{$value['location']}', '{$value['file']}' ); \n";
            $plugins .= "{$key},";
        }

        $this->_plugins .= "CKEDITOR.replace( '{$this->_field}', { \n";
        $this->_plugins .= "extraPlugins: '{$plugins}' \n";
        $this->_plugins .= "} ); \n";
    }

    /**
     * @return string
     */
    public function jsUrl()
    {
        return "/akka_c_k_editor/{$this->_configs['distribution']}/ckeditor.js";
    }

    /**
     * @param $field
     * @param array $options
     * @return string
     */
    public function script($field, array $options = [])
    {
        return "CKEDITOR.replace( '{$field}', " . json_encode(Hash::merge($options, $this->getDefaultEditorConfig())) . " );";
    }

    /**
     * @param array $options
     */
    public function setDefaultEditorConfig(array $options)
    {
        $this->setConfig('editor_config', $options);
    }

    /**
     * @return mixed
     */
    public function getDefaultEditorConfig()
    {
        return $this->getConfig('editor_config');
    }
}
