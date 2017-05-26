<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/5/25
 * Time: 10:58
 */
function get_url(){
    $array = array('m'=>request()->module(),'c'=>request()->controller(),'a'=>request()->action());
    return $array;
}