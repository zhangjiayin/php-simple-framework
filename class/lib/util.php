<?php
/**
 * Util  util functions
 * 
 * @package 
 * @version 0.1
 * @copyright since 2007 taobao.com
 * @author zhangjiayin <yanliz.jy@taobao.com> 
 * @license contact yanli.zjy@taobao.com
 */
class Util {
    /**
     * 将从cookie中取出的用户名转换成GBK编码(因数据库中为gbk,否则就会产生编码不一致)
     *
     * @param string $str
     * @return string
     */
    public static function unicode_hex_2_GBK($str){
        if(preg_match('/^([0-9a-zA-Z\_])*$/',$str)) return $str;
        $str_unicode_dec = unicode_hex_2_dec($str);
        $str_utf8 = Unicode_to_UTF($str_unicode_dec);
        $str_gbk = iconv('utf-8','GBK',$str_utf8);
        return $str_gbk;
    }


    /**
     * 网页中出现的 Unicode 编码是十六进制的，比如 中文"庐山" 被编码成了 "%u5E90%u5C71"，
     * 所以，需要从十六进制 Unicode 编码转换成十进制 Unicode 编码，下面的函数即实现了这种转换
     *
     * @param string $str
     * @return string $result
     */
    public static function unicode_hex_2_dec($str){
        if(!preg_match('/^([0-9a-zA-Z\_])*$/',$str)){
            $result = "";
            $arr = explode("\u",substr($str,2));
            foreach( $arr as $char ){
                $result.= "&#".hexdec($char).";";
            }
        }else{
            $result = $str;
        }
        return $result;
    }


    /**
     * 将unicode编码的字符串转换为utf-8格式
     *
     * @param string $input
     * @return string
     */
    public static function Unicode_to_UTF( $input){
        $utf = '';
        if(!is_array($input)){
            $input     = str_replace('&#', '', $input);
            $input     = explode(';', $input);
            $len = count($input);
            unset($input[$len-1]);
        }
        for($i=0; $i < count($input); $i++){

            if ( $input[$i] <128 ){
                $byte1 = $input[$i];
                $utf  .= chr($byte1);
            }
            if ( $input[$i] >=128 && $input[$i] <=2047 ){

                $byte1 = 192 + (int)($input[$i] / 64);
                $byte2 = 128 + ($input[$i] % 64);
                $utf  .= chr($byte1).chr($byte2);
            }
            if ( $input[$i] >=2048 && $input[$i] <=65535){

                $byte1 = 224 + (int)($input[$i] / 4096);
                $byte2 = 128 + ((int)($input[$i] / 64) % 64);
                $byte3 = 128 + ($input[$i] % 64);

                $utf  .= chr($byte1).chr($byte2).chr($byte3);
            }
            if ( $input[$i] >=65536 && $input[$i] <=2097151){

                $byte1 = 240 + (int)($input[$i] / 262144);
                $byte2 = 128 + ((int)($input[$i] / 4096) % 64);
                $byte3 = 128 + ((int)($input[$i] / 64) % 64);
                $byte4 = 128 + ($input[$i] % 64);
                $utf  .= chr($byte1).chr($byte2).chr($byte3).
                    chr($byte4);
            }
            if ( $input[$i] >=2097152 && $input[$i] <=67108863){

                $byte1 = 248 + (int)($input[$i] / 16777216);
                $byte2 = 128 + ((int)($input[$i] / 262144) % 64);
                $byte3 = 128 + ((int)($input[$i] / 4096) % 64);
                $byte4 = 128 + ((int)($input[$i] / 64) % 64);
                $byte5 = 128 + ($input[$i] % 64);
                $utf  .= chr($byte1).chr($byte2).chr($byte3).
                    chr($byte4).chr($byte5);
            }
            if ( $input[$i] >=67108864 && $input[$i] <=2147483647){

                $byte1 = 252 + ($input[$i] / 1073741824);
                $byte2 = 128 + (($input[$i] / 16777216) % 64);
                $byte3 = 128 + (($input[$i] / 262144) % 64);
                $byte4 = 128 + (($input[$i] / 4096) % 64);
                $byte5 = 128 + (($input[$i] / 64) % 64);
                $byte6 = 128 + ($input[$i] % 64);
                $utf  .= chr($byte1).chr($byte2).chr($byte3).
                    chr($byte4).chr($byte5).chr($byte6);
            }
        }
        return $utf;
    }
}
