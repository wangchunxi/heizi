<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/5/24
 * Time: 14:08
 */
namespace app\admin\controller;
use app\admin\model\Admin;

class Index extends  Base{
    function __construct()
    {
        parent::__construct();
    }

    public function index(){
        $Admin = new Admin();
        $User_info = $Admin->find_user_Info(session('uid'));
        $this->assign('User_info',$User_info);
        return view('index/index');
    }

    public function info(){
        return view('index/info');
    }
}
