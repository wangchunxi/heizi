<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/5/24
 * Time: 14:08
 */
namespace app\admin\controller;

class Index extends  Base{
    public function index(){
      return view('index/index');
    }
    public function info(){
        return view('index/info');
    }
}
