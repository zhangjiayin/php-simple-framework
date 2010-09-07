<?php

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
class ErrorController extends ActionController {

    public $Error = 404;

    public function indexAction() {
    }

    public function notfoundAction() {
    }

    public function _forward404Action() {
        $this->notfoundAction();
        $this->setTemplate('notfound');
    }
}
