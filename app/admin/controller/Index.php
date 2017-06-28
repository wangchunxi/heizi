<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/5/24
 * Time: 14:08
 */
namespace app\admin\controller;
use app\admin\controller\Base;

class Index extends  Base{
//    function _initialize()
//    {
//    }

    public function index(){
      return view('index/index');
    }
}