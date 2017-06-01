<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/5/31
 * Time: 14:31
 */
namespace app\admin\model;
use think\Model;
class admin extends Model{
    private $data;
    public function data($data){
        $this->data($data);
        return $this;
    }
    public function  admin_add(){
        $data = $this->data();
        $data['add_time'] = time();
        //$data['res_id'] = ;
        //$data['add_id'] = ;
        db()->add($data);
    }
}