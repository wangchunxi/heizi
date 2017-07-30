<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/6/2
 * Time: 11:15
 */
namespace app\admin\controller;
use app\admin\model\login;
use app\common;
use Log\Log;
use think\cache\driver\Redis;
class Share extends  common{
    private $model;
    public function __construct()
    {
        parent::__construct();
        $this->model =  new login();
    }

    public function  login(){
        /*判断是否登陆过*/
        if(session('uid')>0){
            $this->redirect(url('admin/index/index','',false));
        }
        /*POST登陆提交*/
       if(request()->isPost()){
           try{
               /*提交数据处理*/
               $result = $this->model->set_post(input('post.'))->login();
               $log = new Log();
               $log->set_username(session('username'))->set_uid(session('uid'))->content()->action_log('h_admin');
               return  $result;
           }catch(\Exception $e){
               /*输出错误*/
               session(null);
               return ajax_return(false,$e->getMessage());
           }
       }
        $this->assign('submit_url',Url('login'));
        return view();
    }
    public function loginout(){
        session(null);
        $redis = new Redis();
        $redis->rm("1authority");
        $this->redirect(url('login','',false));
    }
}