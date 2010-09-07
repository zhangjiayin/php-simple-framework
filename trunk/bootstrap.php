<?php
//根目录
define ('ROOT' , dirname(__FILE__) . DIRECTORY_SEPARATOR);
//基本的库目录
define ('LIB_DIR', ROOT . 'class/lib' . DIRECTORY_SEPARATOR);
//dao 目录
define ('DAO_DIR', ROOT . 'class/dao' . DIRECTORY_SEPARATOR);
//constroller目录
define ('CONTROLLER_DIR', ROOT . 'class/controller' . DIRECTORY_SEPARATOR);
//config dir
define ('CONF_DIR', ROOT . 'conf' . DIRECTORY_SEPARATOR);

//包含配置和 前端转发器
require_once CONF_DIR . 'config.php';
require_once LIB_DIR . 'front.php';
require_once LIB_DIR . 'view.php';

$front = new  FrontController();

//模板目录
define ('TEMPLATE_DIR', ROOT . 'templates' . DIRECTORY_SEPARATOR);
$front->setView(new View());

$front->dispatch();
