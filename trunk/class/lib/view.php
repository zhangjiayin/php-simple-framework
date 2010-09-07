<?php

/**
 * View  view dir
 * 
 * @package 
 * @version 0.1
 * @copyright since 2007 taobao.com
 * @author zhangjiayin <yanliz.jy@taobao.com> 
 * @license contact yanli.zjy@taobao.com
 */
class View {

    public $template = "";
    public $vars = array();
    public $template_ext = "html";

    public $template_dir = '';

    public function setTemplateDir($dir) {
        $this->template_dir = TEMPLATE_DIR . $dir;
    }
    
    public function setTemplate($template) {

        if(empty($this->template_dir)) {
            $this->setTemplateDir('');
        }

        $this->template = $template;
    }

    public function rend() {
        include_once $this->getTemplateFile();    
    }

    public function setVar($key, $value) {
        $this->vars[$key] = $value;
    }

    public function getTemplateFile() {
        return rtrim($this->template_dir , DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . $this->template . '.' . $this->template_ext;
    }

    public function templateIsExists() {
        return file_exists($this->getTemplateFile());
    }
}
