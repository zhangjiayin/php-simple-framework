<?php

require_once CONTROLLER_DIR . 'user.controller.php';
/**
 * ErrorController  error controller
 * 
 * @uses ActioinController
 * @package 
 * @version 0.1
 * @copyright since 2007 taobao.com
 * @author zhangjiayin <yanliz.jy@taobao.com> 
 * @license contact yanli.zjy@taobao.com
 */
class AdminController extends UserController {

    public function indexAction() {
        $this->setNoRender();
    }
    
    public function testAction() {
        $this->forward404();
    }

    public function __call($name, $params) {
        $this->indexAction();
    }
}
