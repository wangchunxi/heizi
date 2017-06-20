<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/5/31
 * Time: 14:31
 */
namespace app\model;
use think\Model;
class Admin extends Model{
    private $str ='heizi';
    private $Post ;
    /*前提准备
      获取提交变量
    */
    public function post($data){
        $this->Post = $data;
        return $this;
    }
    public function  admin_add(){
        $data = $this->Post;
        $data['add_time'] = time();
        $data['reg_ip'] =getIp();
        $data['password'] =$this->encrypt_password( $data['password']);
        $this->save($data);
    }

    /*加密密码*/
    function encrypt_password($password=''){
       $password = md5($this->str.md5($password));
        return $password;
    }
}