<?php
class Config
{
    public static function get($path = null)
    {
        if($path){
            $path = explode('.', $path);
            $config = $GLOBALS['config']; 

            foreach($path as $item){//mysql.some_key.key2.key3.key4
                if (isset($config[$item])){
                    $config = $config[$item];
                }
            }
            
            return $config;
        }
        return false;
    }
}