<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/6/29
 * Time: 17:06
 */
namespace app\admin\logic;
use app\model\Admin;
use app\model\validata;
use think\Model;
use think\Validate;

class user extends Model{
    private $str ='heizi';
    private $Post ;
    private $rule;
    private $msg;
    private $model_val;
    function __construct()
    {
        $this->model = new Admin();
        $this->rule= array(
            'username'=>'require|unique|regex:/^[a-zA-Z0-9_-]+@[a-zA-Z0-9_-]+(\.[a-zA-Z0-9_-]+)+$/',
            'password'=>'require|regex:/^(?![0-9]+$)(?![a-zA-Z]+$)[0-9A-Za-z]{9,16}$/',
            'nickname'=>'require|regex:/^[\u4E00-\u9FA5\uf900-\ufa2d]{2,4}$/',
            'mobile'=>'require|unique|regex:/^1[34578]\d{9}$/'
        );
        $this->msg =array(
            'username.require'=>'邮箱不能为空','username.regex'=>'邮箱格式不对','username.unique'=>'邮箱已存在',
            'password.require'=>'密码不能为空',  'password.regex'=>'密码范围在8~16位数字加字母！',
            'nickname.require'=>'昵称不能为空',
            'mobile.require'=>'手机号码不能为空', 'mobile.unique'=>'手机号码已存在','mobile.regex'=>'手机号码格式错误',
        );
        $this->model_val =new Validate($this->rule,$this->msg);
    }

    public function set_post($data){
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
        $result =   $this->model_val->check($post);
        if(!$result){
            $tips =  $this->model_val->getError();
            return  json_encode(array('status'=>false,'info'=>$tips,'url'=>''));
        }
        /*判断是添加or修改*/
        $data = $post;
        if($post['id']){
            $map['id'] = $post['id'];
            $info = $this->model->set_and($map)->one_find();
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
            $data['password'] =$this->encrypt_password($data['password']);
        }
        $result = $this->model->admin_sava($data);
        if($result){
            return  json_encode(array('status'=>false,'info'=>'操作成功','url'=>''));
        }else{
            return  json_encode(array('status'=>false,'info'=>'操作失败','url'=>''));
        }
    }
    public function vali_data(){
        $post = $this->Post; $field = $post['field']; $value = $post['value'];
        $map[$field] ="'$value'";
        $result = $this->model->set_and($map)->vali_data();
        if($result){
            return  json_encode(array('status'=>false,'info'=>'信息已被注册','url'=>''));
        }else{
            return  json_encode(array('status'=>true,'info'=>'信息可以使用','url'=>''));
        }
    }

}