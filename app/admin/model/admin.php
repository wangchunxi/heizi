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
    /*前提准备
      获取提交变量
      获取加密字符串
    */
    public function data($data){
        $this->data($data);
        $this->str = 'heizi';
        return $this;
    }

    public function  admin_add(){
        $data = $this->data();
        $data['add_time'] = time();
        $data['add_ip'] =getIp();
        $data['password'] =$this->encrypt_password( $data['password']);
        db()->add($data);
    }

    /*加密密码*/
    function encrypt_password($password=''){
       $password = md5($this->str.md5($password));
        return $password;
    }
}