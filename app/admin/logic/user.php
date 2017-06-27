<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/6/29
 * Time: 17:06
 */
namespace app\index\logic;
use app\model\Admin;
use think\Model;
class user extends Model{
    private $str ='heizi';
    private $Post ;
    function __construct()
    {
        $this->model = new Admin();
    }

    private function post($data){
        $this->Post = $data;
        return $this;
    }
    /*加密密码*/
    function encrypt_password($password=''){
        $password = md5($this->str.md5($password));
        return $password;
    }

    /**
     * 修改和添加数据整合
     */
    private  function update_data(){
        $post = $this->Post;
        /*判断是添加or修改*/
        $data = $post;
        if($post['id']){
            //$data['update_id'] = ;
            $password = $this->encrypt_password( $data['password']);

            $data['update_time'] = time();
        }else{
            $data['add_time'] = time();
            $data['reg_ip'] =getIp();
            $data['password'] =$this->encrypt_password( $data['password']);
        }
        $this->model->admin_sava($data);
    }


}