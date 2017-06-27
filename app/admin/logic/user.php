<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/6/29
 * Time: 17:06
 */
namespace app\admin\logic;
use app\model\Admin;
use think\Model;
class user extends Model{
    private $str ='heizi';
    private $Post ;
    function __construct()
    {
        $this->model = new Admin();
    }

    public function post($data){
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
    public  function update_data(){
        $post = $this->Post;
        /*判断是添加or修改*/
        $data = $post;
        if($post['id']){
            //$data['update_id'] = ;
            $info = $this->model->set_map()->set_map()->one_find();
            $password = $this->encrypt_password( $data['password']);
            if($info['password'] == $password){
                unset($data['password']);
            }else{
                $data['password'] = $password;
            }
            $data['update_time'] = time();
        }else{
            $data['add_time'] = time();
            $data['reg_ip'] =getIp();
            $data['password'] =$this->encrypt_password( $data['password']);
        }
        $result = $this->model->admin_sava($data);

    }
    public function vali_data(){
        $result = $this->model->vali_data();
        if($result){
            return  json_encode(array('info'=>false,'tips'=>'信息已被注册','url'=>''));
        }else{
            return  json_encode(array('info'=>true,'tips'=>'信息可以使用','url'=>''));
        }
    }

}