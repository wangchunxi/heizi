<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/5/25
 * Time: 10:23
 */
namespace app\admin\controller;
//use app\admin\controller\Base
use Auth\Auth;
use think\Controller;
class  Base extends  Controller{

    public function _initialize()
    {
        $auth = new Auth();
        $Auth = $auth->check(get_url(),1,'m');
        dump($Auth);
//        $a = array(1,2,3,4,5);
//        $b = array(2,3,5,8);
//        dump(array_merge($a,$b));
    }
}
