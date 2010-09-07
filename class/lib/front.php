<?php

require_once LIB_DIR . 'action.php';
require_once CONTROLLER_DIR . 'error.controller.php';

/**
 * Controller contrller class
 * 
 * @package 
 * @version 0.1
 * @copyright since 2007 taobao.com
 * @author zhangjiayin <yanliz.jy@taobao.com> 
 * @license contact yanli.zjy@taobao.com
 */
class FrontController {

    public $view = null;

    public $actions_chain = array();

    /**
     * dispatch 
     * 
     * @access public
     * @return void
     */
    public function dispatch() {

        $pathInfo = $_SERVER["PATH_INFO"];
        $pathInfo = ltrim($pathInfo , '/');

        $action = array(
            'controller' => 'index',    
            'action' => 'index',    
        );

        //TODO
        $urls_map = array(
            0 => 'controller',
            1 => 'action',
        );

        $pre_actions_tmp = explode('/', $pathInfo);
        $pre_actions_tmp_length = count($pre_actions_tmp);
        if(!empty($pathInfo) && $pre_actions_tmp_length > 0) {
            foreach($pre_actions_tmp as $index => $value) {
                if($index == count($urls_map)) {
                    break;
                }

                $map_key = $urls_map[$index];
                $value = trim($value);
                if(!empty($value)) {
                    $action[$map_key] = $value;
                }
            }
        }

        $this->actions_chain[] = $action;

        $i = 0;
        $max_loop = 20;
    
        while($i < $max_loop) {
            $action = $this->actions_chain[$i];
            $controller = $this->loadController($action["controller"], $action);
            if($controller != null) {
                $controller->setView($this->view);
                $controller->dispatch();
            }
            
            $i++;
            if($i == count($this->actions_chain)) {
                break;
            }
        }

        if(!empty($controller) && $controller->view != null) {
            $controller->view->rend();
        }
    }

    /**
     * loadController  load right controller 
     * 
     * @param mixed $controller_name 
     * @param mixed $action_info 
     * @access public
     * @return void
     */
    public function loadController($controller_name, $action_info) {

        $controller_class_file = CONTROLLER_DIR . strtolower($controller_name) . '.controller.php';
        $controller_class_name = ucfirst(strtolower($controller_name)) . 'Controller';

        if(file_exists($controller_class_file)) {
            require_once $controller_class_file;
        }

        $controller = null;

        if(class_exists($controller_class_name)) {
            $controller = new $controller_class_name();
            $controller->setFrontContext($this);
            $controller->setInfo($action_info);
        } 
        
        if(!($controller instanceof ActionController)) {
            $this->ErrorNotFound();
        }
            
        return $controller;
    }

    /**
     * ErrorNotFound 
     * 
     * @access private
     * @return void
     */
    public function ErrorNotFound() {
        $action = array(
            'controller' => 'error',    
            'action' => 'notfound',    
        );
       $this->actions_chain[] = $action;
    }

    public function setView(View $view) {
        $this->view =  $view;
    }

    /**
     * forward404 forward
     * 
     * @access public
     * @return void
     */
    public function forward404() {
        $action = array(
            'controller' => 'error',    
            'action' => '_forward404',    
        );
       $this->actions_chain[] = $action;
    }
}
