<?php
/**
 * ActioinController  actoin超类
 * 
 * @abstract
 * @package 
 * @version 0.1
 * @copyright since 2007 taobao.com
 * @author zhangjiayin <yanliz.jy@taobao.com> 
 * @license contact yanli.zjy@taobao.com
 */
abstract class ActionController {
    
    public  $view = null;

    protected $frontContext = null;

    protected $action_info  = null;
        
    /**
     * setfrontContext 
     * 
     * @param mixed $frontContext
     * @access public
     * @return void
     */
    public function setFrontContext($frontContext) {
        $this->frontContext = $frontContext;
    }

    /**
     * setInfo 
     * 
     * @param mixed $action_info 
     * @access public
     * @return void
     */
    public function setInfo($action_info){
        $this->action_info = $action_info;
    }

    /**
     * dispatch 开始转发
     * 
     * @access public
     * @return void
     */
    public function dispatch() {
        $action = $this->action_info['action'];
        $actionName = $action . 'Action';

        if(is_callable(array($this, $actionName))) {
            $this->setTemplate($this->action_info['controller'] . DIRECTORY_SEPARATOR . $this->action_info['action']);
            $this->$actionName();
        }  else {
            $this->ErrorNotFound();
        }
    }
    
    /**
     * setTemplateDir 
     * 
     * @param mixed $dir 
     * @access public
     * @return void
     */
    public function setTemplateDir($dir) {
        return $this->view->setTemplateDir($dir);
    }

    /**
     * setTemplate 
     * 
     * @param mixed $template 
     * @access public
     * @return void
     */
    public function setTemplate($template) {
        return $this->view->setTemplate($template);
    }

    /**
     * forward404  转发找不到
     * 
     * @access protected
     * @return void
     */
    protected function forward404() {
        $this->frontContext->forward404();
    }

    /**
     * redirect  重定向
     * 
     * @param mixed $url 
     * @access protected
     * @return void
     */
    protected function redirect($url) {
        header("Location: $url");
        exit;
    }
    
    /**
     * ErrorNotFound 正常找不到
     * 
     * @access protected
     * @return void
     */
    protected function ErrorNotFound() {
        $this->frontContext->ErrorNotFound();
    }

    /**
     * setNoRender 
     * 
     * @access protected
     * @return void
     */
    protected function setNoRender() {
        $this->view = null;
    }

    /**
     * setView 
     * 
     * @param View $view 
     * @access public
     * @return void
     */
    public function setView(View $view) {
        $this->view = $view;   
    }

    /**
     * setVar 
     * 
     * @param mixed $key 
     * @param mixed $value 
     * @access public
     * @return void
     */
    public function setVar($key, $value) {
        $this->view->setVar($key, $value);
    }
}
