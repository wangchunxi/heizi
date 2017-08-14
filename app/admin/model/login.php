<?php
    /**
     * Created by PhpStorm.
     * User: Administrator
     * Date: 2017/7/24
     * Time: 14:42
     */
    namespace app\admin\model;
    use think\Model;
    class login extends Model{
        private $post;
        private $model;
        public  function  __construct()
        {
            $this->model = new Admin();
        }
        function  set_post($post){
            $this->post = $post;
            return $this;
        }
        function login(){
            $post = $this->post;
            /*获取提交信息*/
//            if(!captcha_check($post['code'])){
//                exception('验证码错误');
//            }
            /*用账号进行查询*/
            $result = $this->model->find_user_Info('',$post['username'],'password,username,id,login_time,login_ip,status');
        //    print_r( $result);
            /*未查询到提示账号不存在*/
            if(!$result){
                exception('账号不存在');
            }
            /*加密密码*/
            $password = $this->model->encrypt_password($post['password']);
            /*对比失败提示密码错误*/
            if($result['password'] !== $password){
                exception('密码错误');
            }
            /*查看用状态*/
            if($result['status']!=1){
                exception('账号被冻结了,请联系管理员');
            }
            $data['id'] = $result['id'];
            /*对比成功记录登录时间和ip*/
            $data['login_time'] = time();
            $data['login_ip'] =getIp();
            /*验证成功记录session*/
            session('uid', $data['id']);
            session('username',$result['username']);
            /*第一次登陆不用记录上次登陆的时间*/
            if($result['login_time']){
                $data['last_login_time'] = $result['login_time'];
               session('last_login_time',$result['login_time']);
            }
            if($result['login_ip']){
                $data['last_login_ip'] = $result['login_ip'];
                session('last_login_ip',$result['login_ip']);
            }
           // print_r($data);
            $this->model->set_post($data)->save_login();
            /*返回数据*/
            return ajax_return(true,'登陆成功!','',url('admin/index/index'));
        }
    }