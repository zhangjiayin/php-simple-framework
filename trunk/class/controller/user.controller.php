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
abstract class  UserController extends Action{

    public function __construct() {
        $this->redirect('http://www.baidu.com');
    }
    public function needAuth() {
    }
}
