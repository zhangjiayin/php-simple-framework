<?php
/**
 * Request  请求封装
 * 
 * @package 
 * @version 0.1
 * @copyright since 2007 taobao.com
 * @author zhangjiayin <yanliz.jy@taobao.com> 
 * @license contact yanli.zjy@taobao.com
 */
class Request {

    public function get($key, $default=null) {
        return isset($_GET[$key]) ? $_GET[$key] : $default;
    }

    public function post($key, $default=null) {
        return isset($_POST[$key]) ? $_POST[$key] : $default;
    }

    public function request($key, $default=null) {
        return isset($_REQUEST[$key]) ? $_REQUEST[$key] : $default;
    }

    public function cookie($key, $default=null) {
        return isset($_COOKIE[$key]) ? $_COOKIE[$key] : $default;
    }
}
