<?php
require_once CONTROLLER_DIR .'action.controller.php';
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
class IndexController extends ActionController {

    public function indexAction() {
        $this->setVar("title", "dddd");
    }
    
    public function testAction() {
       # $this->forward404();
    }

    public function __call($name, $params) {
        $this->indexAction();
    }
}
