<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/6/23
 * Time: 14:47
 */
namespace app\admin\controller;
use think\Controller;
use app\common;
class  User extends  common{
    private $model;
    private $post;
    public function _initialize()
    {
        $this->post =  input('post.');
        parent::_initialize(); // TODO: Change the autogenerated stub
        $this->model = new \app\admin\logic\user();
    }

    public function index(){
        return view();
    }
    public function info(){
        return view();
    }
    public function update(){
        if(request()->isPost()){
            return $this->model->set_post($this->post)->update_data();
        }
    }
    public function accredit(){

    }
    public function vali_data(){
        if(request()->isPost()){
            return $this->model->set_post($this->post)->vali_data();
        }
    }
}
