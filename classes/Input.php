<?php

class Input
{
    public static function exists($type = 'post')
    {
        switch ($type){
            case 'post':
                return (!empty($_POST)) ? true : false;
            case 'get':
                return (!empty($_GET)) ? true : false;
            default:
                return false;
            break;
        }
        /*
        if(!empty($_POST)){
            return true;
        } elseif (!empty($_GET)){
            return true;
        }
        return false;
        */
    }

    public static function get($item)
    {
        if(isset($_POST[$item])){
            return $_POST[$item];
        } elseif(isset($_GET[$item])){
            return $_GET[$item];
        }
        
        return '';
    }
}