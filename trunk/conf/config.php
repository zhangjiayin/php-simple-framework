<?php

class Config {

    public static $CONFIG = array();


    private static $clusters = array(
        "PROD_CLUSTER"	=> array("cm2","cm3","cm4","cm5"),
        "STAGING"		=> array("search155.sqa"),
        "SANDBOX"		=> array("prepub36.cm1"),
    );

    public static function init() {

        $ENV = array(
            "REMOTEIP" 	=> htmlspecialchars((isset($_GET["ip"])&&!empty($_GET["ip"]))?$_GET["ip"]:getenv("REMOTE_ADDR"),ENT_QUOTES),
            "HOSTNAME" 	=> php_uname("n"),
            "INTERNAL_USER" =>false,
        );


        $cluster = preg_replace("/.+?\.(.+)/", "\\1", $ENV["HOSTNAME"]);
    
        if (in_array(preg_replace("/.+?\.(.+)/", "\\1", $ENV["HOSTNAME"]), self::$clusters["PROD_CLUSTER"])) {
            $ENV["CLUSTER"] = "product";
        }elseif (in_array($ENV["HOSTNAME"],self::$clusters["STAGING"])){
            $ENV["CLUSTER"] = "staging";
        }elseif (in_array($ENV["HOSTNAME"],self::$clusters["SANDBOX"])){
            $ENV["CLUSTER"] = "sandbox";
        }else{
            $ENV["CLUSTER"] = "dev";
        }
    

        $config = include "cluster.d/config.inc.php";
        if(file_exists(CONF_DIR . "cluster.d/{$ENV["CLUSTER"]}.inc.php")) {
            $cluster_config = include "cluster.d/{$ENV["CLUSTER"]}.inc.php";
        }
        
        self::$CONFIG = array_merge($config, $cluster_config);
    }
}

Config::init();
